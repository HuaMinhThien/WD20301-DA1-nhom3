<?php
// File: models/ProductModel.php
// Hide products/categories with prefix [ẨN] on frontend - fully working

class ProductModel {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    // Get all visible categories only
    public function getAllCategories() {
        $sql = "SELECT id, name FROM category 
                WHERE name NOT LIKE '[ẨN] %' 
                ORDER BY id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all genders
    public function getAllGenders() {
        $sql = "SELECT id, name FROM gender ORDER BY id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all products (used in admin - no hide filter)
    public function getAllProducts() {
        $sql = "SELECT id, name, price, description, img AS image FROM products";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Main filter function for products page - hide [ẨN] products & categories
    public function getFilteredProducts($filters) {
        $sql = "SELECT DISTINCT 
                    p.id, 
                    p.name, 
                    p.img AS image, 
                    p.price
                FROM products p
                JOIN category c ON p.category_id = c.id
                WHERE 1=1
                  AND p.name NOT LIKE '[ẨN] %'
                  AND c.name NOT LIKE '[ẨN] %'";

        $params = [];

        if (!empty($filters['category_ids']) && is_array($filters['category_ids'])) {
            $placeholders = str_repeat('?,', count($filters['category_ids']) - 1) . '?';
            $sql .= " AND p.category_id IN ($placeholders)";
            $params = array_merge($params, $filters['category_ids']);
        }

        if (!empty($filters['gender_id']) && is_array($filters['gender_id'])) {
            $placeholders = str_repeat('?,', count($filters['gender_id']) - 1) . '?';
            $sql .= " AND p.gender_id IN ($placeholders)";
            $params = array_merge($params, $filters['gender_id']);
        }

        if (!empty($filters['color_id']) || !empty($filters['size_id'])) {
            $sql .= " AND EXISTS (
                        SELECT 1 FROM product_variant pv 
                        WHERE pv.product_id = p.id 
                          AND (pv.quantity > 0 OR pv.quantity IS NULL)";

            if (!empty($filters['color_id']) && is_array($filters['color_id'])) {
                $placeholders = str_repeat('?,', count($filters['color_id']) - 1) . '?';
                $sql .= " AND pv.color_id IN ($placeholders)";
                $params = array_merge($params, $filters['color_id']);
            }

            if (!empty($filters['size_id']) && is_array($filters['size_id'])) {
                $placeholders = str_repeat('?,', count($filters['size_id']) - 1) . '?';
                $sql .= " AND pv.size_id IN ($placeholders)";
                $params = array_merge($params, $filters['size_id']);
            }

            $sql .= ")";
        } else {
            $sql .= " AND (
                        EXISTS (SELECT 1 FROM product_variant pv WHERE pv.product_id = p.id AND (pv.quantity > 0 OR pv.quantity IS NULL))
                        OR NOT EXISTS (SELECT 1 FROM product_variant pv2 WHERE pv2.product_id = p.id)
                    )";
        }

        if ($filters['price_min'] !== null) {
            $sql .= " AND p.price >= ?";
            $params[] = $filters['price_min'];
        }
        if ($filters['price_max'] !== null) {
            $sql .= " AND p.price <= ?";
            $params[] = $filters['price_max'];
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Product details - hide if marked [ẨN]
    public function getProductDetails($id) {
        $sql = "SELECT id, name, price, description, 
                 img AS image, img_child AS image_child, category_id, gender_id 
                 FROM products p
                 JOIN category c ON p.category_id = c.id
                 WHERE p.id = ?
                   AND p.name NOT LIKE '[ẨN] %'
                   AND c.name NOT LIKE '[ẨN] %'
                 LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $product['thumbnails'] = [$product['image'], $product['image_child'], $product['image']];
            $product['sale_price'] = $product['price'];
            $product['description_full'] = $product['description'];
        }

        return $product ?: false;
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

        foreach ($variants_raw as $row) {
            if (!isset($colors[$row['color_id']])) {
                $colors[$row['color_id']] = ['id' => $row['color_id'], 'name' => $row['color_name']];
            }
            if (!isset($sizes[$row['size_id']])) {
                $sizes[$row['size_id']] = ['id' => $row['size_id'], 'name' => $row['size_name']];
            }
        }

        return [
            'colors' => array_values($colors),
            'sizes'  => array_values($sizes)
        ];
    }

    // Related products - hide [ẨN]
    public function getRelatedProducts($category_id, $current_product_id, $limit = 4) {
        $sql = "SELECT p.id, p.name, p.price, p.img AS image, p.category_id
                FROM products p
                JOIN category c ON p.category_id = c.id
                WHERE p.category_id = :category_id 
                  AND p.id != :current_product_id 
                  AND p.name NOT LIKE '[ẨN] %'
                  AND c.name NOT LIKE '[ẨN] %'
                ORDER BY RAND() 
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':current_product_id', $current_product_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get newest products (highest ID) - hide [ẨN]
    public function getNewestProducts($limit = 10) {
        $sql = "SELECT p.id, p.name, p.price, p.img AS image, p.category_id
                 FROM products p
                 JOIN category c ON p.category_id = c.id
                 WHERE p.name NOT LIKE '[ẨN] %'
                   AND c.name NOT LIKE '[ẨN] %'
                 ORDER BY p.id DESC 
                 LIMIT ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get products with highest stock - hide [ẨN]
    public function getHighestStockProducts($limit = 10) {
        $sql = "SELECT p.id, p.name, p.price, p.img AS image, p.category_id,
                 COALESCE(SUM(pv.quantity), 0) AS total_stock
                 FROM products p
                 JOIN category c ON p.category_id = c.id
                 LEFT JOIN product_variant pv ON pv.product_id = p.id
                 WHERE p.name NOT LIKE '[ẨN] %'
                   AND c.name NOT LIKE '[ẨN] %'
                 GROUP BY p.id
                 ORDER BY total_stock DESC 
                 LIMIT ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function getVariantDetails($variant_id) {
        $sql = "SELECT pv.quantity, s.name AS size_name, c.name AS color_name
                FROM product_variant pv
                JOIN size s ON pv.size_id = s.id
                JOIN color c ON pv.color_id = c.id
                WHERE pv.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $variant_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Product by ID (detail page) - hide [ẨN]
    public function getProductById($id) {
        $sql = "SELECT p.id, p.name, p.price, p.description, p.img AS image, p.img_child AS image_child, p.category_id, p.gender_id 
                FROM products p
                JOIN category c ON p.category_id = c.id
                WHERE p.id = :id
                  AND p.name NOT LIKE '[ẨN] %'
                  AND c.name NOT LIKE '[ẨN] %'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product && !empty($product['image_child'])) {
            $product['thumbnails'] = array_filter(explode(',', $product['image_child']));
        } else {
            $product['thumbnails'] = [];
        }

        if ($product && !empty($product['image'])) {
            array_unshift($product['thumbnails'], $product['image']);
        }

        return $product ?: false;
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

    public function getCategoryById($id) {
        $sql = "SELECT name FROM category WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $name = $stmt->fetchColumn();
        return $name ? $name : null;
    }
}
?>