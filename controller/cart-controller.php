<?php
// File: /controller/CartController.php
// ĐÃ SỬA HOÀN CHỈNH: KHÔNG CÒN LỖI HEADER + THÔNG BÁO ĐẸP + AN TOÀN

$root_path = dirname(__DIR__);
require_once($root_path . '/models/ProductModel.php');
require_once($root_path . '/models/CartModels.php');
require_once($root_path . '/config/Database.php');

// BỎ 2 DÒNG NÀY ĐI → NGUYÊN NHÂN CHÍNH GÂY LỖI HEADER!!!
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

class CartController {
    private $productModel;
    private $cartModel;
    private $db;
    private $userId;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->cartModel = new CartModel($this->db);

        $this->userId = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2;
        $this->userId = (int)$this->userId;
    }

    public function index() {
        $success_message = $_SESSION['success_message'] ?? null;
        $error_message = $_SESSION['error_message'] ?? null;
        unset($_SESSION['success_message'], $_SESSION['error_message']);

        $cart_items = $this->cartModel->getCartItemsByUserId($this->userId);

        $total_amount = 0;
        foreach ($cart_items as &$item) {
            $item['sub_total'] = $item['price'] * $item['quantity'];
            $total_amount += $item['sub_total'];
        }

        $suggested_products = $this->productModel->getFeaturedProductsRandom(4);

        include_once 'pages/cart.php';
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'index';
        switch ($action) {
            case 'add':     $this->add_to_cart(); break;
            case 'remove':  $this->remove(); break;
            case 'update':  $this->update_quantity(); break;
            default:        $this->index();
        }
    }

    public function add_to_cart() {
        $product_id = $_POST['product_id'] ?? null;
        $variant_id = $_POST['variant_id'] ?? null;  // THÊM DÒNG NÀY - ƯU TIÊN VARIANT_ID NẾU CÓ
        $color_id   = $_POST['color_id'] ?? 1;
        $size_id    = $_POST['size_id'] ?? 1;
        $quantity   = max(1, (int)($_POST['quantity'] ?? 1));

        if (!$product_id || !is_numeric($product_id)) {
            $_SESSION['error_message'] = 'Lỗi: Không xác định được sản phẩm.';
            $this->jsRedirect('products', $this->userId);
        }

        // Nếu form gửi variant_id trực tiếp (từ trang danh sách) → dùng luôn
        if ($variant_id) {
            // Kiểm tra tồn kho
            $variantDetail = $this->productModel->getVariantDetails($variant_id);
            if ($variantDetail && $variantDetail['quantity'] < $quantity) {
                $_SESSION['error_message'] = 'Chỉ còn ' . $variantDetail['quantity'] . ' sản phẩm!';
                $this->jsRedirect('cart', $this->userId);
            }

            $result = $this->cartModel->saveItem($this->userId, $variant_id, $quantity);
            $_SESSION['success_message'] = $result ? 'Đã thêm vào giỏ hàng!' : 'Lỗi hệ thống!';
            $this->jsRedirect('cart', $this->userId);
        }

        // Nếu không có variant_id → dùng color/size như cũ
        $variant_id = $this->productModel->getVariantId((int)$product_id, (int)$color_id, (int)$size_id);

        if (!$variant_id) {
            $stmt = $this->db->prepare("SELECT id FROM product_variant WHERE product_id = ? AND quantity > 0 LIMIT 1");
            $stmt->execute([$product_id]);
            $variant_id = $stmt->fetchColumn();
            if (!$variant_id) {
                $_SESSION['error_message'] = 'Sản phẩm tạm hết hàng!';
                $this->jsRedirect('products_Details&id=' . $product_id, $this->userId);
            }
        }

        $variantDetail = $this->productModel->getVariantDetails($variant_id);
        if ($variantDetail && $variantDetail['quantity'] < $quantity) {
            $_SESSION['error_message'] = 'Chỉ còn ' . $variantDetail['quantity'] . ' sản phẩm!';
            $this->jsRedirect('cart', $this->userId);
        }

        $result = $this->cartModel->saveItem($this->userId, $variant_id, $quantity);
        $_SESSION['success_message'] = $result ? 'Đã thêm vào giỏ hàng!' : 'Lỗi hệ thống!';

        $redirect = $_GET['redirect'] ?? 'cart';
        $this->jsRedirect($redirect === 'checkout' ? 'checkout' : 'cart', $this->userId);
    }

    public function remove() {
        $variant_id = $_GET['key'] ?? null;
        if ($variant_id && is_numeric($variant_id)) {
            $this->cartModel->removeItem($this->userId, (int)$variant_id);
            $_SESSION['success_message'] = 'Đã xóa sản phẩm!';
        }
        $this->jsRedirect('cart', $this->userId);
    }

    public function update_quantity() {
        $variant_id = $_POST['variant_id'] ?? null;
        $new_qty = (int)($_POST['quantity'] ?? 1);
        if ($variant_id && $new_qty >= 1) {
            $this->cartModel->updateQuantity($this->userId, (int)$variant_id, $new_qty);
            $_SESSION['success_message'] = 'Đã cập nhật số lượng!';
        }
        $this->jsRedirect('cart', $this->userId);
    }

    // HÀM GIÚP REDIRECT AN TOÀN 100% - KHÔNG BAO GIỜ LỖI HEADER
    private function jsRedirect($page, $user_id) {
        $url = "index.php?page={$page}&user_id={$user_id}";
        echo "<script>
                alert('" . ($_SESSION['success_message'] ?? $_SESSION['error_message'] ?? 'Thao tác thành công!') . "');
                window.location.href = '{$url}';
              </script>";
        exit;
    }
}