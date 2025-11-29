<?php
// File: /controller/CartController.php

$root_path = dirname(__DIR__); 

// SỬ DỤNG $root_path ĐỂ INCLUDE CÁC FILE KHÁC
require_once($root_path . '/models/ProductModel.php'); 
require_once($root_path . '/models/CartModels.php'); // Dùng tên file CartModels.php
require_once($root_path . '/config/Database.php'); // Giả định file config nằm trong /config/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

        $this->userId = $_SESSION['user_id'] ?? 2; 
        
        // DEBUG: Hiển thị thông tin user
        error_log("DEBUG CartController: User ID = " . $this->userId);
    }

    /**
     * Hiển thị trang giỏ hàng (pages/cart.php)
     */
    public function index() {
        // DEBUG: Bắt đầu index
        error_log("DEBUG: CartController::index() called");
        
        // Giữ nguyên việc lấy thông báo để hiển thị trên trang giỏ hàng nếu cần
        $success_message = $_SESSION['success_message'] ?? null;
        $error_message = $_SESSION['error_message'] ?? null;
        
        unset($_SESSION['success_message'], $_SESSION['error_message']); 
        
        // DEBUG: Trước khi lấy cart items
        error_log("DEBUG: Before getCartItemsByUserId, user_id = " . $this->userId);
        
        // 2. LẤY DỮ LIỆU GIỎ HÀNG DỰA TRÊN USER ID
        $cart_items = $this->cartModel->getCartItemsByUserId($this->userId);
        
        // DEBUG: Sau khi lấy cart items
        error_log("DEBUG: After getCartItemsByUserId, count = " . count($cart_items));
        if (count($cart_items) > 0) {
            error_log("DEBUG: Cart items: " . print_r($cart_items, true));
        }
        
        // 3. Tính toán tổng tiền
        $total_amount = 0;
        foreach ($cart_items as $item) {
            // Lưu ý: p.price là giá gốc của sản phẩm, cần tính thành tiền
            $total_amount += $item['price'] * $item['quantity'];
            
            // Thêm trường 'sub_total' cho View dễ sử dụng
            $item['sub_total'] = $item['price'] * $item['quantity'];
        }

        // DEBUG: Tổng tiền
        error_log("DEBUG: Total amount = " . $total_amount);

        // LẤY SẢN PHẨM GỢI Ý
        $suggested_products = $this->productModel->getFeaturedProductsRandom(4);

        include_once 'pages/cart.php';
        return ['cart_items' => $cart_items, 'total_amount' => $total_amount, 'user_id' => $this->userId, 'success_message' => $success_message, 'error_message' => $error_message];
    }

    /**
     * Xử lý hành động Thêm vào Giỏ (Add to Cart)
     */
    public function handleRequest() {
        $action = $_GET['action'] ?? 'index';
        
        // DEBUG: Action được gọi
        error_log("DEBUG: CartController::handleRequest() - action = " . $action);

        switch ($action) {
            case 'index':
                return $this->index(); // Trả về dữ liệu để router tải View
            case 'add':
                $this->add_to_cart();
                break;
            case 'remove':
                $this->remove();
                break;
            case 'update':
                $this->update_quantity();
                break;
            default:
                // Xử lý lỗi hoặc gọi index
                return $this->index(); 
        }
        return []; // Tránh lỗi nếu các action chuyển hướng
    }
    
    public function add_to_cart() {
        // DEBUG: Bắt đầu add_to_cart
        error_log("DEBUG: CartController::add_to_cart() called");
        
        // 1. Lấy dữ liệu từ POST
        $product_id = $_POST['product_id'] ?? null;
        $color_id = $_POST['color_id'] ?? 1; // Mặc định color_id=1 nếu không chọn
        $size_id = $_POST['size_id'] ?? 1;   // Mặc định size_id=1 nếu không chọn
        $quantity = (int)($_POST['quantity'] ?? 1); 

        // DEBUG: Dữ liệu POST
        error_log("DEBUG: POST data - product_id=$product_id, color_id=$color_id, size_id=$size_id, quantity=$quantity");
        error_log("DEBUG: Full POST: " . print_r($_POST, true));

        // Lấy trang trước đó để chuyển hướng
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=products';

        if (!is_numeric($product_id) || $quantity <= 0) {
            $_SESSION['error_message'] = 'Lỗi: Thông tin sản phẩm không hợp lệ.';
            error_log("ERROR: Invalid product data - product_id=$product_id, quantity=$quantity");
            header('Location: ' . $referer);
            exit();
        }

        // 2. Tìm Variant ID (ID của phiên bản sản phẩm)
        // Đây là bước quan trọng để biết chính xác biến thể nào được mua
        error_log("DEBUG: Before getVariantId - product_id=$product_id, color_id=$color_id, size_id=$size_id");
        $variant_id = $this->productModel->getVariantId(
            (int)$product_id, 
            (int)$color_id, 
            (int)$size_id
        );
        error_log("DEBUG: After getVariantId - variant_id=$variant_id");

        if (!$variant_id) {
            $_SESSION['error_message'] = 'Lỗi: Không tìm thấy biến thể sản phẩm này trong kho.';
            error_log("ERROR: Variant not found for product_id=$product_id, color_id=$color_id, size_id=$size_id");
            header('Location: ' . $referer);
            exit();
        }

        // 3. Thêm/Cập nhật sản phẩm vào giỏ hàng qua CartModel
        error_log("DEBUG: Before saveItem - user_id=" . $this->userId . ", variant_id=$variant_id, quantity=$quantity");
        $add_result = $this->cartModel->saveItem($this->userId, (int)$variant_id, $quantity);
        error_log("DEBUG: After saveItem - result=" . ($add_result ? 'true' : 'false'));

        if ($add_result) {
            $_SESSION['success_message'] = '✅ Đã thêm sản phẩm vào giỏ hàng thành công.';
            error_log("SUCCESS: Item added to cart successfully");
        } else {
            $_SESSION['error_message'] = 'Lỗi: Không thể thêm sản phẩm vào giỏ hàng (Lỗi SQL).';
            error_log("ERROR: Failed to add item to cart");
        }

        // 4. Chuyển hướng về trang giỏ hàng
        error_log("DEBUG: Redirecting to cart page");
        header('Location: index.php?page=cart');
        exit();
    }
    
    /**
     * Xóa mặt hàng khỏi SQL
     */
    public function remove() {
        $variant_id = $_GET['key'] ?? null; 
        
        // DEBUG: Remove action
        error_log("DEBUG: CartController::remove() called - variant_id=$variant_id");
        
        // Lấy trang trước đó để chuyển hướng (thường là trang giỏ hàng)
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=cart';
        
        if (!is_numeric($variant_id) || $variant_id <= 0) {
            $_SESSION['error_message'] = 'Lỗi: Sản phẩm cần xóa không hợp lệ.';
            error_log("ERROR: Invalid variant_id for removal - variant_id=$variant_id");
            header('Location: ' . $referer);
            exit();
        }

        // 🚨 XÓA TỪ SQL
        error_log("DEBUG: Before removeItem - user_id=" . $this->userId . ", variant_id=$variant_id");
        $remove_result = $this->cartModel->removeItem($this->userId, (int)$variant_id);
        error_log("DEBUG: After removeItem - result=" . ($remove_result ? 'true' : 'false'));

        if ($remove_result) {
            $_SESSION['success_message'] = '✅ Đã xóa sản phẩm khỏi giỏ hàng.';
            error_log("SUCCESS: Item removed from cart");
        } else {
            $_SESSION['error_message'] = 'Lỗi: Không thể xóa sản phẩm khỏi giỏ hàng (Lỗi SQL).';
            error_log("ERROR: Failed to remove item from cart");
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
        
        // DEBUG: Update quantity action
        error_log("DEBUG: CartController::update_quantity() called - variant_id=$variant_id, new_quantity=$new_quantity");
        
        // Lấy trang trước đó để chuyển hướng (thường là trang giỏ hàng)
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=cart';

        if (!is_numeric($variant_id) || $new_quantity <= 0) {
            $_SESSION['error_message'] = 'Lỗi: Thông tin cập nhật không hợp lệ.';
            error_log("ERROR: Invalid update data - variant_id=$variant_id, new_quantity=$new_quantity");
            header('Location: ' . $referer);
            exit();
        }

        // 🚨 CẬP NHẬT TRONG SQL
        error_log("DEBUG: Before updateQuantity - user_id=" . $this->userId . ", variant_id=$variant_id, new_quantity=$new_quantity");
        $update_result = $this->cartModel->updateQuantity($this->userId, (int)$variant_id, $new_quantity);
        error_log("DEBUG: After updateQuantity - result=" . ($update_result ? 'true' : 'false'));

        if ($update_result) {
            $_SESSION['success_message'] = '🔄 Đã cập nhật số lượng sản phẩm.';
            error_log("SUCCESS: Quantity updated successfully");
        } else {
            $_SESSION['error_message'] = 'Lỗi: Không thể cập nhật số lượng (Lỗi SQL).';
            error_log("ERROR: Failed to update quantity");
        }

        // 🚨 SỬA: Chuyển hướng quay lại trang cũ (cart)
        header('Location: ' . $referer);
        exit();
    }
}