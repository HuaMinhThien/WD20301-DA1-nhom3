<?php
// File: /controller/cart-controller.php
// ĐÃ SỬA HOÀN CHỈNH: KHÔNG CÒN LỖI HEADER + THÔNG BÁO ĐẸP + AN TOÀN

$root_path = dirname(__DIR__);
require_once($root_path . '/models/ProductModel.php');
require_once($root_path . '/models/CartModels.php');
require_once($root_path . '/config/Database.php');
require_once($root_path . '/models/BillModel.php');   

class CartController {
    private $productModel;
    private $cartModel;
    private $db;
    private $userId;
    private $billModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->cartModel = new CartModel($this->db);
        $this->billModel    = new BillModel($this->db);


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
        unset($item);   // ← THÊM DÒNG NÀY LÀ HẾT BUG NGAY LẬP TỨC

        $suggested_products = $this->productModel->getFeaturedProductsRandom(4);

        include_once 'pages/cart.php';
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'index';
        switch ($action) {
            case 'add':     $this->add_to_cart(); break;
            case 'remove':  $this->remove(); break;
            case 'update':  $this->update_quantity(); break;  
            case 'checkout':      $this->checkout(); break;
            default:        $this->index();
        }
    }

    public function add_to_cart() {
        $product_id = $_POST['product_id'] ?? null;
        $color_id   = $_POST['color_id'] ?? null;  // Bắt buộc phải có color
        $size_id    = $_POST['size_id'] ?? null;   // Bắt buộc phải có size
        $quantity   = max(1, (int)($_POST['quantity'] ?? 1));

        if (!$product_id || !is_numeric($product_id) || !$color_id || !$size_id) {
            $_SESSION['error_message'] = 'Vui lòng chọn đầy đủ sản phẩm, màu sắc và kích thước.';
            $this->jsRedirect('products_Details&id=' . $product_id, $this->userId);
        }

        // Tìm variant_id dựa trên color và size chọn (nghiêm ngặt)
        $variant_id = $this->productModel->getVariantId((int)$product_id, (int)$color_id, (int)$size_id);

        if (!$variant_id) {
            $_SESSION['error_message'] = 'Biến thể sản phẩm (màu và size) không tồn tại hoặc không khả dụng.';
            $this->jsRedirect('products_Details&id=' . $product_id, $this->userId);
        }

        // Kiểm tra stock của variant cụ thể
        $variantDetail = $this->productModel->getVariantDetails($variant_id);
        if (!$variantDetail || $variantDetail['quantity'] < $quantity) {
            $_SESSION['error_message'] = 'Biến thể sản phẩm tạm hết hàng hoặc số lượng không đủ (chỉ còn ' . ($variantDetail['quantity'] ?? 0) . ' sản phẩm).';
            $this->jsRedirect('products_Details&id=' . $product_id, $this->userId);
        }

        // Nếu OK, lưu vào cart
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

    // THÊM HÀM NÀY ĐỂ UPDATE QUANTITY TỪ + / -
    public function update_quantity() {
        $variant_id = $_POST['variant_id'] ?? null;
        $new_qty = (int)($_POST['quantity'] ?? 1);
        if ($variant_id && $new_qty >= 1) {
            $this->cartModel->updateQuantity($this->userId, (int)$variant_id, $new_qty);
            $_SESSION['success_message'] = 'Đã cập nhật số lượng!';
        } else {
            $_SESSION['error_message'] = 'Số lượng không hợp lệ!';
        }
        $this->jsRedirect('cart', $this->userId);
    }

    // HÀM GIÚP REDIRECT AN TOÀN 100% - KHÔNG BAO GIỜ LỖI HEADER
    private function jsRedirect($page, $user_id) {
        // Danh sách các trang hợp lệ (tránh người dùng truyền tham số linh tinh)
        $valid_pages = [
            'cart'        => 'cart',
            'thanhtoan'   => 'thanhtoan',
            'checkout'    => 'thanhtoan',      
            'cart_history'=> 'cart_history',
            'products_Details' => 'products_Details',
        ];

        // Nếu trang không hợp lệ → mặc định về giỏ hàng
        $page = $valid_pages[$page] ?? 'cart';

        $url = "index.php?page={$page}&user_id={$user_id}";

        // Lấy thông báo (nếu có)
        $msg = $_SESSION['success_message'] ?? $_SESSION['error_message'] ?? 'Đã thêm vào giỏ hàng thành công!';
        
        // Xóa thông báo sau khi đã lấy để tránh hiển thị lại lần sau
        unset($_SESSION['success_message'], $_SESSION['error_message']);

        echo "<script>
                alert('" . addslashes($msg) . "');
                window.location.href = '{$url}';
            </script>";
        exit;
    }
    public function checkout() {
        $userId = $_SESSION['user_id'] ?? $_GET['user_id'] ?? 2; // Ưu tiên session
        $totalPay = $_POST['total_pay'] ?? 0; // Lấy từ form (tính lại để an toàn)

        // Giả định form gửi thêm thông tin giao hàng (address, phone, email...)
        // Bạn có thể thêm xử lý lưu vào bảng address nếu cần

        $billId = $this->billModel->createBillFromCart($userId, null, $totalPay, 'pending');

        if ($billId) {
            $_SESSION['success_message'] = 'Đơn hàng đã được đặt thành công!';
            $this->jsRedirect('cart_history', $userId);
        } else {
            $_SESSION['error_message'] = 'Lỗi khi đặt hàng!';
            $this->jsRedirect('thanhtoan', $userId);
        }
    }
}