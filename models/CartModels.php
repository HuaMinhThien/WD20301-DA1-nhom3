<?php
// File: /models/CartModels.php (ĐÃ SỬA: Tên bảng product_variant)

class CartModel {
    private $conn;
    private $cart_table = "cart";
    private $cart_detail_table = "cartdetail";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lấy ID Giỏ hàng (Cart ID) của người dùng hiện tại (hoặc Giỏ hàng chung user_id = 0)
     * Nếu chưa có, sẽ tạo mới.
     * @param int $userId ID người dùng (0 nếu chưa đăng nhập)
     * @return int|null Cart ID
     */
    private function getOrCreateCartId($userId) : ?int {
        // 1. Kiểm tra Cart có tồn tại không
        $query = "SELECT id FROM " . $this->cart_table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            return (int)$cart['id'];
        } else {
            // 2. Nếu chưa có, tạo mới Giỏ hàng (cart)
            // LƯU Ý: Nếu cột `date_create` của bạn KHÔNG có giá trị mặc định,
            // bạn phải thêm nó vào câu lệnh INSERT. Tôi thêm NOW() theo SQL của bạn.
            $insert_query = "INSERT INTO " . $this->cart_table . " (user_id, date_create) VALUES (:user_id, NOW())";
            $insert_stmt = $this->conn->prepare($insert_query);
            $insert_stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            if ($insert_stmt->execute()) {
                 return (int)$this->conn->lastInsertId();
            }
            return null; // Lỗi khi tạo giỏ hàng
        }
    }

    /**
     * Lấy giỏ hàng chi tiết từ SQL dựa trên User ID (hoặc 0 nếu chưa đăng nhập)
     * @param int $userId
     * @return array
     */
    public function getCartItemsByUserId($userId) {
        // 🚨 SỬA: Đã đổi tên bảng từ 'product_variants' sang 'product_variant'
        $query = "
            SELECT 
                cd.id, cd.quantity, 
                cd.productVariant_id AS variant_id,
                p.id AS product_id, p.name, p.img AS image, p.price, p.category_id,
                s.name AS size_name, c.name AS color_name
            FROM " . $this->cart_detail_table . " cd
            JOIN " . $this->cart_table . " cart ON cd.cart_id = cart.id
            JOIN product_variant pv ON cd.productVariant_id = pv.id  
            JOIN products p ON pv.product_id = p.id
            JOIN size s ON pv.size_id = s.id
            JOIN color c ON pv.color_id = c.id
            WHERE cart.user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm hoặc cập nhật một mặt hàng trong SQL
     */
    public function saveItem($userId, $variantId, $quantity) {
        $cartId = $this->getOrCreateCartId($userId); 
        
        if (!$cartId) return false;

        // 1. Kiểm tra mặt hàng đã tồn tại trong cartdetail chưa
        $check_query = "SELECT id, quantity FROM " . $this->cart_detail_table . " 
                        WHERE cart_id = :cart_id AND productVariant_id = :variant_id";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $check_stmt->bindParam(':variant_id', $variantId, PDO::PARAM_INT);
        $check_stmt->execute();
        $existing_item = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_item) {
            // 2. Cập nhật số lượng (cộng dồn)
            $new_quantity = $existing_item['quantity'] + $quantity;
            $update_query = "UPDATE " . $this->cart_detail_table . " SET quantity = :quantity WHERE id = :detail_id";
            $update_stmt = $this->conn->prepare($update_query);
            $update_stmt->bindParam(':quantity', $new_quantity, PDO::PARAM_INT);
            $update_stmt->bindParam(':detail_id', $existing_item['id'], PDO::PARAM_INT);
            return $update_stmt->execute();

        } else {
            // 3. Thêm mới vào cartdetail
            $insert_query = "INSERT INTO " . $this->cart_detail_table . " (cart_id, productVariant_id, quantity) 
                             VALUES (:cart_id, :variant_id, :quantity)";
            $insert_stmt = $this->conn->prepare($insert_query);
            $insert_stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
            $insert_stmt->bindParam(':variant_id', $variantId, PDO::PARAM_INT);
            $insert_stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            return $insert_stmt->execute();
        }
    }

    /**
     * Cập nhật số lượng tuyệt đối của một mặt hàng cụ thể trong SQL
     */
    public function updateQuantity($userId, $variantId, $newQuantity) {
        $cartId = $this->getOrCreateCartId($userId); 
        
        if (!$cartId) return false;

        $query = "UPDATE " . $this->cart_detail_table . " 
                  SET quantity = :quantity 
                  WHERE cart_id = :cart_id AND productVariant_id = :variant_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->bindParam(':variant_id', $variantId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Xóa một mặt hàng khỏi SQL
     */
    public function removeItem($userId, $variantId) {
        $cartId = $this->getOrCreateCartId($userId); 
        
        if (!$cartId) return false;

        $query = "DELETE FROM " . $this->cart_detail_table . " 
                  WHERE cart_id = :cart_id AND productVariant_id = :variant_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->bindParam(':variant_id', $variantId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}