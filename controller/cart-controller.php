<?php
// File: /controller/CartController.php

// 🚨 ĐÃ SỬA LỖI ĐƯỜNG DẪN BẰNG dirname(__DIR__)
$root_path = dirname(__DIR__); 

require_once($root_path . '/models/ProductModel.php'); 
require_once($root_path . '/models/CartModels.php'); // Dùng tên file CartModels.php
require_once($root_path . '/config/Database.php'); 

class CartController {
    private $productModel;
    private $cartModel; 
    private $db;
    private $userId; // ID người dùng hiện tại

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->db = (new Database())->getConnection(); 
        $this->productModel = new ProductModel($this->db);
        $this->cartModel = new CartModel($this->db); // Tên Class là CartModel

        // 🚨 XÁC ĐỊNH USER ID: Lấy từ Session (nếu đăng nhập) hoặc đặt là 0
        $this->userId = $_SESSION['user_id'] ?? 0; 
    }

    /**
     * Hiển thị trang giỏ hàng (pages/cart.php)
     */
    public function index() {
        // Giữ nguyên việc lấy thông báo để hiển thị trên trang giỏ hàng nếu cần
        $success_message = $_SESSION['success_message'] ?? null;
        $error_message = $_SESSION['error_message'] ?? null;
        // KHÔNG unset ở đây nếu muốn Toast hiển thị. Đã unset trong header.php.
        // unset($_SESSION['success_message']); 
        // unset($_SESSION['error_message']); 
        
        // 🚨 LẤY GIỎ HÀNG TỪ SQL
        $cart_items = $this->cartModel->getCartItemsByUserId($this->userId);
        
        // LẤY SẢN PHẨM GỢI Ý
        $suggested_products = $this->productModel->getFeaturedProductsRandom(4);

        include_once 'pages/cart.php';
    }

    /**
     * Xử lý hành động Thêm vào Giỏ (Add to Cart)
     */
    public function add() {
        // 1. Lấy dữ liệu từ POST
        $product_id = $_POST['product_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);
        $size_id = $_POST['size_id'] ?? null; 
        $color_id = $_POST['color_id'] ?? null; 
        $action_type = $_POST['action'] ?? 'add_to_cart';
        
        // Lấy trang trước đó để chuyển hướng
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=products';
        
        // Kiểm tra tính hợp lệ cơ bản
        if (!is_numeric($product_id) || !is_numeric($size_id) || !is_numeric($color_id) || $quantity <= 0) {
            $_SESSION['error_message'] = 'Lỗi: Thông tin sản phẩm không hợp lệ.';
            header('Location: ' . $referer); 
            exit();
        }

        // 2. Lấy thông tin sản phẩm và Variant ID
        $product_details = $this->productModel->getProductDetails((int)$product_id);
        $variant_id = $this->productModel->getVariantId((int)$product_id, (int)$color_id, (int)$size_id);
        $variant_details = $this->productModel->getVariantDetails($variant_id);

        if (!$product_details || !$variant_id || !$variant_details) {
            $_SESSION['error_message'] = 'Lỗi: Sản phẩm hoặc biến thể (Size/Color) không tồn tại.';
            header('Location: ' . $referer); 
            exit();
        }

        $size_name = $variant_details['size_name'];
        $color_name = $variant_details['color_name'];
        
        // 🚨 LƯU VÀO SQL
        $save_result = $this->cartModel->saveItem($this->userId, $variant_id, $quantity);
        
        if (!$save_result) {
            $_SESSION['error_message'] = 'Lỗi: Không thể thêm sản phẩm vào giỏ hàng (Lỗi SQL/Model).';
            header('Location: ' . $referer); 
            exit();
        }
        
        // 4. Thiết lập thông báo thành công
        $_SESSION['success_message'] = '🎉 Đã thêm sản phẩm "' . $product_details['name'] . ' - Màu: ' . $color_name . ' - Size: ' . $size_name . '" vào giỏ hàng thành công!';

        // 5. Chuyển hướng sau khi xử lý
        if ($action_type === 'buy_now') {
            header('Location: index.php?page=checkout'); 
        } else {
            // 🚨 SỬA: Chuyển hướng quay lại trang cũ để hiển thị Toast
            header('Location: ' . $referer); 
        }
        exit();
    }
    
    /**
     * Xóa mặt hàng khỏi SQL
     */
    public function remove() {
        $variant_id = $_GET['key'] ?? null; 
        
        // Lấy trang trước đó để chuyển hướng (thường là trang giỏ hàng)
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=cart';
        
        if (!is_numeric($variant_id) || $variant_id <= 0) {
            $_SESSION['error_message'] = 'Lỗi: Sản phẩm cần xóa không hợp lệ.';
            header('Location: ' . $referer);
            exit();
        }

        // 🚨 XÓA TỪ SQL
        $remove_result = $this->cartModel->removeItem($this->userId, (int)$variant_id);

        if ($remove_result) {
            $_SESSION['success_message'] = '✅ Đã xóa sản phẩm khỏi giỏ hàng.';
        } else {
            $_SESSION['error_message'] = 'Lỗi: Không thể xóa sản phẩm khỏi giỏ hàng (Lỗi SQL).';
        }

        // 🚨 SỬA: Chuyển hướng quay lại trang cũ (cart)
        header('Location: ' . $referer);
        exit();
    }

    /**
     * Cập nhật số lượng trong SQL
     */
    public function update_quantity() {
        $variant_id = $_POST['variant_id'] ?? null;
        $new_quantity = (int)($_POST['quantity'] ?? 1); 
        
        // Lấy trang trước đó để chuyển hướng (thường là trang giỏ hàng)
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=cart';

        if (!is_numeric($variant_id) || $new_quantity <= 0) {
            $_SESSION['error_message'] = 'Lỗi: Thông tin cập nhật không hợp lệ.';
            header('Location: ' . $referer);
            exit();
        }

        // 🚨 CẬP NHẬT TRONG SQL
        $update_result = $this->cartModel->updateQuantity($this->userId, (int)$variant_id, $new_quantity);

        if ($update_result) {
            $_SESSION['success_message'] = '🔄 Đã cập nhật số lượng sản phẩm.';
        } else {
            $_SESSION['error_message'] = 'Lỗi: Không thể cập nhật số lượng (Lỗi SQL).';
        }

        // 🚨 SỬA: Chuyển hướng quay lại trang cũ (cart)
        header('Location: ' . $referer);
        exit();
    }
}