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
        $sql = "SELECT id, name, price, storage, description, img AS image FROM products";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // HÀM LỌC TỔNG QUÁT (Dùng PDO)
    public function getFilteredProducts($filters) {
        $category_ids = $filters['category_ids'] ?? null; 
        $gender_id = $filters['gender_id'] ?? null;
        $price_min = $filters['price_min'] ?? null;
        $price_max = $filters['price_max'] ?? null;

        $sql = "SELECT id, name, price, description, img AS image, category_id, gender_id 
            FROM products 
            WHERE 1=1"; 
        
        $params = [];

        if (!empty($category_ids) && is_array($category_ids)) {
            $placeholders = implode(',', array_fill(0, count($category_ids), '?'));
            $sql .= " AND category_id IN ($placeholders)";
            $params = array_merge($params, $category_ids);
        } 
        
        if ($gender_id !== null) {
            $sql .= " AND gender_id = ?";
            $params[] = $gender_id;
        }

        if ($price_min !== null && $price_max !== null) {
            $sql .= " AND price >= ? AND price <= ?";
            $params[] = $price_min;
            $params[] = $price_max;
        }
        
        $sql .= " ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params); 
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // ... (các hàm lọc khác) ...

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

    // Hàm lấy sản phẩm liên quan
    public function getRelatedProducts($category_id, $current_product_id) {
        $sql = "SELECT id, name, price, img AS image 
             FROM products 
             WHERE category_id = ? AND id != ?
             ORDER BY id DESC
             LIMIT 4"; 
            
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$category_id, $current_product_id]);
        
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
    }// --- BỔ SUNG CÁC HÀM QUẢN TRỊ (ADMIN) ---

    // 1. Thêm sản phẩm
    public function insertProduct($name, $price, $storage, $desc, $img, $category_id, $gender_id) {
        $sql = "INSERT INTO products (name, price, storage, description, img, category_id, id_gender) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $price, $storage, $desc, $img, $category_id, $gender_id]);
    }

    // 2. Cập nhật sản phẩm
    public function updateProduct($id, $name, $price, $storage, $desc, $img, $category_id, $gender_id) {
        if ($img) {
            // Nếu có up ảnh mới -> Cập nhật cả ảnh
            $sql = "UPDATE products SET name=?, price=?, storage=?, description=?, img=?, category_id=?, id_gender=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$name, $price, $storage, $desc, $img, $category_id, $gender_id, $id]);
        } else {
            // Nếu không up ảnh -> Giữ nguyên ảnh cũ
            $sql = "UPDATE products SET name=?, price=?, storage=?, description=?, category_id=?, id_gender=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$name, $price, $storage, $desc, $category_id, $gender_id, $id]);
        }
    }

    // 3. Xóa sản phẩm
    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }


}