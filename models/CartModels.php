<?php
// File: models/CartModel.php - PHIÊN BẢN HOÀN CHỈNH, KHÔNG LỖI NỮA

class CartModel {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    private function getCartId($userId) {
        if ($userId === 2) {  // Guest: Không dùng DB
            return null;  // Hoặc xử lý riêng
        }
        $stmt = $this->db->prepare("SELECT id FROM cart WHERE user_id = ? LIMIT 1");
        $stmt->execute([$userId]);
        $cartId = $stmt->fetchColumn();

        if (!$cartId) {
            $stmt = $this->db->prepare("INSERT INTO cart (user_id, date_create) VALUES (?, NOW())");
            $stmt->execute([$userId]);
            return $this->db->lastInsertId();
        }
        return $cartId;
    }

    // Lưu item vào giỏ (nếu đã có → cộng dồn số lượng)
    public function saveItem($userId, $variantId, $quantity = 1) {
        if ($userId === 2) {  // Guest: Lưu vào session
            if (!isset($_SESSION['guest_cart'])) {
                $_SESSION['guest_cart'] = [];
            }
            if (isset($_SESSION['guest_cart'][$variantId])) {
                $_SESSION['guest_cart'][$variantId]['quantity'] += $quantity;
            } else {
                $_SESSION['guest_cart'][$variantId] = ['quantity' => $quantity];  // Có thể thêm details khác
            }
            return true;
        }

        $cartId = $this->getCartId($userId);

        // DÙNG BIẾN RIÊNG CHO MỖI CÂU LỆNH - QUAN TRỌNG NHẤT!
        $checkStmt = $this->db->prepare("SELECT id, quantity FROM cartdetail WHERE cart_id = ? AND productVariant_id = ?");
        $checkStmt->execute([$cartId, $variantId]);
        $exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            // Cập nhật số lượng
            $newQty = $exists['quantity'] + $quantity;
            $updateStmt = $this->db->prepare("UPDATE cartdetail SET quantity = ? WHERE id = ?");
            $updateStmt->execute([$newQty, $exists['id']]);
        } else {
            // Thêm mới
            $insertStmt = $this->db->prepare("INSERT INTO cartdetail (cart_id, productVariant_id, quantity) VALUES (?, ?, ?)");
            $insertStmt->execute([$cartId, $variantId, $quantity]);
        }
        return true;
    }

    // LẤY GIỎ HÀNG - ĐÂY LÀ CHỖ QUAN TRỌNG NHẤT (phải JOIN đúng)
    public function getCartItemsByUserId($userId) {
        if ($userId === 2) {  // Guest: Lấy từ session
            if (!isset($_SESSION['guest_cart'])) {
                return [];
            }
            // Giả sử cần fetch details từ DB cho variant (nếu cần, thêm logic join với variant/product)
            $items = [];
            foreach ($_SESSION['guest_cart'] as $variantId => $data) {
                // Fetch details từ DB (ví dụ)
                $sql = "SELECT 
                            pv.product_id, p.name, p.img AS image, p.price,
                            c.name AS color_name, s.name AS size_name
                        FROM product_variant pv
                        JOIN products p ON pv.product_id = p.id
                        JOIN color c ON pv.color_id = c.id
                        JOIN size s ON pv.size_id = s.id
                        WHERE pv.id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$variantId]);
                $details = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($details) {
                    $details['quantity'] = $data['quantity'];
                    $details['variant_id'] = $variantId;
                    $items[] = $details;
                }
            }
            return $items;
        }

        $cartId = $this->getCartId($userId);

        $sql = "SELECT 
                    cd.quantity,
                    cd.productVariant_id AS variant_id,
                    pv.product_id,
                    p.name,
                    p.img AS image,
                    p.price,
                    c.name AS color_name,
                    s.name AS size_name
                FROM cartdetail cd
                JOIN product_variant pv ON cd.productVariant_id = pv.id
                JOIN products p ON pv.product_id = p.id
                JOIN color c ON pv.color_id = c.id
                JOIN size s ON pv.size_id = s.id
                WHERE cd.cart_id = ?
                ORDER BY cd.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cartId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeItem($userId, $variantId) {
        if ($userId === 2) {  // Guest
            unset($_SESSION['guest_cart'][$variantId]);
            return;
        }
        $cartId = $this->getCartId($userId);
        $stmt = $this->db->prepare("DELETE FROM cartdetail WHERE cart_id = ? AND productVariant_id = ?");
        $stmt->execute([$cartId, $variantId]);
    }

    public function updateQuantity($userId, $variantId, $quantity) {
        if ($quantity < 1) $quantity = 1;
        if ($userId === 2) {  // Guest
            if (isset($_SESSION['guest_cart'][$variantId])) {
                $_SESSION['guest_cart'][$variantId]['quantity'] = $quantity;
            }
            return;
        }
        $cartId = $this->getCartId($userId);
        $stmt = $this->db->prepare("UPDATE cartdetail SET quantity = ? WHERE cart_id = ? AND productVariant_id = ?");
        $stmt->execute([$quantity, $cartId, $variantId]);
    }

    public function clearCart($userId) {
        if ($userId === 2) {  // Guest
            unset($_SESSION['guest_cart']);
            return;
        }
        $cartId = $this->getCartId($userId);
        $stmt = $this->db->prepare("DELETE FROM cartdetail WHERE cart_id = ?");
        $stmt->execute([$cartId]);
    }
}