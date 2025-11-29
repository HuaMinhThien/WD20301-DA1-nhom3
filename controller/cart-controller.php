<?php
// File: /controller/CartController.php (ĐÃ SỬA HOÀN CHỈNH + HIỂN THỊ user_id TRÊN URL)

$root_path = dirname(__DIR__);
require_once($root_path . '/models/ProductModel.php');
require_once($root_path . '/models/CartModels.php');
require_once($root_path . '/config/Database.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

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

        // ƯU TIÊN: GET > Session > Default = 2
        $this->userId = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2;
        $this->userId = (int)$this->userId;

        // Ghi log để debug dễ
        error_log("CartController - Current user_id: " . $this->userId);
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

        // Truyền user_id ra view để hiển thị trên URL
        include_once 'pages/cart.php';
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'index';

        switch ($action) {
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
                $this->index();
        }
    }

    public function add_to_cart() {
        $product_id = $_POST['product_id'] ?? null;
        $color_id   = $_POST['color_id'] ?? null;
        $size_id    = $_POST['size_id'] ?? null;
        $quantity   = max(1, (int)($_POST['quantity'] ?? 1));

        // Nếu không chọn màu/size → thử lấy mặc định = 1 (cho trang danh sách)
        if (!$color_id) $color_id = 1;
        if (!$size_id)  $size_id = 1;

        if (!$product_id || !is_numeric($product_id)) {
            $_SESSION['error_message'] = 'Lỗi: Không xác định được sản phẩm.';
            header('Location: ' . $_SERVER['HTTP_REFERER'] ?? 'index.php?page=products&user_id=' . $this->userId);
            exit;
        }

        // Lấy variant_id
        $variant_id = $this->productModel->getVariantId((int)$product_id, (int)$color_id, (int)$size_id);

        if (!$variant_id) {
            // Tự động thử tìm variant đầu tiên có sẵn của sản phẩm này (rất quan trọng!)
            $sql = "SELECT id FROM product_variant WHERE product_id = ? AND quantity > 0 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$product_id]);
            $variant_id = $stmt->fetchColumn();

            if (!$variant_id) {
                $_SESSION['error_message'] = 'Sản phẩm hiện hết hàng hoặc chưa có size/màu phù hợp.';
                header('Location: index.php?page=products_Details&id=' . $product_id . '&user_id=' . $this->userId);
                exit;
            }
        }

        // Kiểm tra số lượng tồn kho
        $variantDetail = $this->productModel->getVariantDetails($variant_id);
        if ($variantDetail && $variantDetail['quantity'] < $quantity) {
            $_SESSION['error_message'] = 'Số lượng vượt quá tồn kho (' . $variantDetail['quantity'] . ' sản phẩm có sẵn).';
            header('Location: ' . $_SERVER['HTTP_REFERER'] ?? 'index.php?page=cart&user_id=' . $this->userId);
            exit;
        }

        $result = $this->cartModel->saveItem($this->userId, $variant_id, $quantity);

        if ($result) {
            $_SESSION['success_message'] = 'Đã thêm vào giỏ hàng!';
        } else {
            $_SESSION['error_message'] = 'Lỗi hệ thống, không thể thêm vào giỏ hàng.';
        }

        // Luôn redirect kèm user_id để thấy rõ đang thao tác với user nào
        $redirect = $_GET['redirect'] ?? null;
        if ($redirect === 'checkout') {
            header('Location: index.php?page=checkout&user_id=' . $this->userId);
        } else {
            header('Location: index.php?page=cart&user_id=' . $this->userId);
        }
        exit;
    }

    public function remove() {
        $variant_id = $_GET['key'] ?? null;
        if ($variant_id && is_numeric($variant_id)) {
            $this->cartModel->removeItem($this->userId, (int)$variant_id);
            $_SESSION['success_message'] = 'Đã xóa sản phẩm khỏi giỏ hàng.';
        }
        header('Location: index.php?page=cart&user_id=' . $this->userId);
        exit;
    }

    public function update_quantity() {
        $variant_id = $_POST['variant_id'] ?? null;
        $new_qty = (int)($_POST['quantity'] ?? 1);

        if ($variant_id && $new_qty >= 1) {
            $this->cartModel->updateQuantity($this->userId, (int)$variant_id, $new_qty);
            $_SESSION['success_message'] = 'Đã cập nhật số lượng.';
        }
        header('Location: index.php?page=cart&user_id=' . $this->userId);
        exit;
    }
}