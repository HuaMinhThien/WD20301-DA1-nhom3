<?php
// File: models/ProductModel.php (Đã sửa lỗi và đồng bộ dùng PDO)

class ProductModel {
    private $db; 

    // CHÚ Ý: Class này PHẢI nhận kết nối PDO qua constructor
    public function __construct($db_connection) {
        $this->db = $db_connection; 
    }

    // Lấy tất cả danh mục
    public function getAllCategories() {
        $sql = "SELECT id, name FROM category ORDER BY id ASC"; 
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Lấy tất cả giới tính
    public function getAllGenders() {
        $sql = "SELECT id, name FROM gender ORDER BY id ASC"; 
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm lấy tất cả sản phẩm
    public function getAllProducts() {
        $sql = "SELECT id, name, price, description, img AS image FROM products"; 
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // HÀM LỌC TỔNG QUÁT (Dùng PDO)
    public function getFilteredProducts($filters) {
        $sql = "SELECT DISTINCT 
                    p.id, 
                    p.name, 
                    p.img AS image,           -- đúng tên cột trong DB của bạn
                    p.price
                FROM products p
                INNER JOIN product_variant pv ON p.id = pv.product_id
                WHERE 1=1";

        $params = [];

        // 1. Lọc danh mục (hỗ trợ category_id = 12 → lọc nhiều ID)
        if (!empty($filters['category_ids'])) {
            $placeholders = str_repeat('?,', count($filters['category_ids']) - 1) . '?';
            $sql .= " AND p.category_id IN ($placeholders)";
            $params = array_merge($params, $filters['category_ids']);
        }

        // 2. Giới tính
        if ($filters['gender_id'] !== null) {
            $sql .= " AND p.gender_id = ?";
            $params[] = $filters['gender_id'];
        }

        // 3. Màu sắc
        if ($filters['color_id'] !== null) {
            $sql .= " AND pv.color_id = ?";
            $params[] = $filters['color_id'];
        }

        // 4. Kích cỡ
        if ($filters['size_id'] !== null) {
            $sql .= " AND pv.size_id = ?";
            $params[] = $filters['size_id'];
        }

        // 5. Khoảng giá
        if ($filters['price_min'] !== null) {
            $sql .= " AND p.price >= ?";
            $params[] = $filters['price_min'];
        }
        if ($filters['price_max'] !== null) {
            $sql .= " AND p.price <= ?";
            $params[] = $filters['price_max'];
        }

        // 6. Chỉ lấy sản phẩm còn hàng trong kho (rất quan trọng!)
        $sql .= " AND pv.quantity > 0";

        // 7. Sắp xếp mới nhất trước
        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Hàm lấy chi tiết một sản phẩm 
    public function getProductDetails($id) {
        $sql = "SELECT id, name, price, description, 
                 img AS image, img_child AS image_child, category_id, gender_id 
             FROM products 
             WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $product['thumbnails'] = [$product['image'], $product['image_child'], $product['image']];
            $product['sale_price'] = $product['price']; 
            $product['description_full'] = $product['description']; 
        }
        
        return $product;
    }


    public function getAvailableVariants($product_id) {
        $sql = "SELECT DISTINCT pv.color_id, c.name AS color_name, pv.size_id, s.name AS size_name
                FROM product_variant pv
                JOIN color c ON pv.color_id = c.id
                JOIN size s ON pv.size_id = s.id
                WHERE pv.product_id = :pid
                AND pv.quantity > 0";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':pid', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $variants_raw = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $colors = [];
        $sizes = [];

        // Lặp qua kết quả để nhóm màu và size duy nhất
        foreach ($variants_raw as $row) {
            // Sử dụng color_id làm key để đảm bảo tính duy nhất của màu
            if (!isset($colors[$row['color_id']])) {
                $colors[$row['color_id']] = ['id' => $row['color_id'], 'name' => $row['color_name']];
            }
            
            // Sử dụng size_id làm key để đảm bảo tính duy nhất của size
            if (!isset($sizes[$row['size_id']])) {
                $sizes[$row['size_id']] = ['id' => $row['size_id'], 'name' => $row['size_name']];
            }
        }

        return [
            // Chuyển mảng kết hợp thành mảng tuần tự (chỉ giữ lại giá trị)
            'colors' => array_values($colors), 
            'sizes' => array_values($sizes)
        ];
    }

    // Hàm lấy sản phẩm liên quan
    public function getRelatedProducts($category_id, $current_product_id, $limit = 4) {
        $sql = "SELECT id, name, price, img AS image, category_id  -- 🚨 BỔ SUNG category_id VÀO ĐÂY
                FROM products 
                WHERE category_id = :category_id 
                AND id != :current_product_id 
                ORDER BY RAND() 
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':current_product_id', $current_product_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Hàm lấy số lượng sản phẩm ngẫu nhiên
    public function getFeaturedProductsRandom($limit = 10) {
        $sql = "SELECT id, name, price, img AS image, category_id
                 FROM products 
                 ORDER BY RAND() 
                 LIMIT ?"; 
        
        $stmt = $this->db->prepare($sql);
        
        // 🚨 Sửa lỗi: Thay thế execute([$limit]) bằng bindParam để ép kiểu Integer cho LIMIT
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Hàm lấy Variant ID
    public function getVariantId($product_id, $color_id, $size_id) {
        $sql = "SELECT id FROM product_variant 
             WHERE product_id = :pid AND color_id = :cid AND size_id = :sid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':pid', $product_id);
        $stmt->bindParam(':cid', $color_id);
        $stmt->bindParam(':sid', $size_id);
        $stmt->execute();
        return $stmt->fetchColumn(); 
    }

    // Hàm lấy Variant Details
    public function getVariantDetails($variant_id) {
        $sql = "SELECT 
             pv.quantity, s.name AS size_name, c.name AS color_name
             FROM product_variant pv
             JOIN size s ON pv.size_id = s.id
             JOIN color c ON pv.color_id = c.id
             WHERE pv.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $variant_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getProductById($id) {
    // Lấy thông tin sản phẩm chính và các ảnh con (nếu có)
        $sql = "SELECT id, name, price, description, img AS image, img_child AS image_child, category_id, gender_id 
                FROM products 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Xử lý mảng ảnh con (tách chuỗi ảnh thành mảng thumbnails)
        if ($product && !empty($product['image_child'])) {
            $product['thumbnails'] = array_filter(explode(',', $product['image_child']));
        } else {
            $product['thumbnails'] = [];
        }
        
        // Thêm ảnh chính vào đầu danh sách thumbnails (để hiển thị)
        if ($product && !empty($product['image'])) {
            array_unshift($product['thumbnails'], $product['image']);
        }

        return $product;
    }
        public function getProductVariants($product_id) {
        $sql = "SELECT 
                    pv.id AS variant_id,
                    pv.size_id, s.name AS size_name,
                    pv.color_id, c.name AS color_name,
                    pv.quantity AS stock_quantity
                FROM product_variant pv
                JOIN size s ON pv.size_id = s.id
                JOIN color c ON pv.color_id = c.id
                WHERE pv.product_id = :product_id
                ORDER BY pv.size_id, pv.color_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}