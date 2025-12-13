<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// === XỬ LÝ ĐẶT HÀNG THÀNH CÔNG TRƯỚC KHI ROUTING ===
if (isset($_GET['page']) && $_GET['page'] === 'cart' && isset($_GET['action']) && $_GET['action'] === 'checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Lấy dữ liệu từ form thanh toán
    $full_name      = trim($_POST['full_name'] ?? '');
    $phone          = trim($_POST['phone'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $address        = trim($_POST['address'] ?? '');
    $province_name  = trim($_POST['province_name'] ?? '');
    $district_name  = trim($_POST['district_name'] ?? '');
    $total_pay      = (int)($_POST['total_pay'] ?? 0);
    $user_id        = (int)($_POST['user_id'] ?? $_SESSION['user_id'] ?? 0);

    // Validate cơ bản
    if (empty($full_name) || empty($phone) || empty($province_name) || empty($district_name) || $total_pay <= 0 || $user_id <= 0) {
        $_SESSION['checkout_error'] = 'Vui lòng điền đầy đủ thông tin giao hàng.';
        header('Location: index.php?page=thanhtoan');
        exit;
    }

    // Kết nối DB và tạo bill
    require_once 'config/Database.php';
    require_once 'models/BillModel.php';
    
    $database = new Database();
    $db = $database->getConnection();
    $billModel = new BillModel($db);

    $bill_id = $billModel->createBillFromCart($user_id, $total_pay);

    if ($bill_id) {
        // Lưu thông tin đơn hàng vào session để hiển thị ở trang thành công
        $_SESSION['order_success'] = [
            'bill_id'    => $bill_id,
            'full_name'  => $full_name,
            'phone'      => $phone,
            'total_pay'  => $total_pay,
            'email'      => $email,
            'address'    => $address . ', ' . $district_name . ', ' . $province_name
        ];

        // Chuyển hướng đến trang thành công
        header('Location: index.php?page=successthanhtoan');
        exit;
    } else {
        $_SESSION['checkout_error'] = 'Đặt hàng thất bại. Vui lòng thử lại.';
        header('Location: index.php?page=thanhtoan');
        exit;
    }
}

// === XỬ LÝ LOGOUT ===
if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

ob_start();
include_once 'includes/header.php';

$page = $_GET['page'] ?? 'home';

$controller_name = '';
$controller_file = '';
$method_to_call = $page;

switch ($page) {
    // Cart Controller
    case 'cart':
    case 'add_to_cart':
    case 'remove_from_cart':
    case 'update_cart':
        $controller_name = 'CartController';
        $controller_file = 'controller/cart-controller.php';
        $method_to_call = 'handleRequest';
        break;

    // HomeController - Các trang chính
    case 'products':
    case 'products_Details':
    case 'home':
    case 'login':
    case 'register':
    case 'user':
    case 'cart_history':
    case 'sale':
    case 'shop':
    case 'thanhtoan':
    case 'successthanhtoan':
        $controller_name = 'HomeController';
        $controller_file = 'controller/home-controller.php';
        $method_to_call = $page;
        break;

    // Trang mặc định
    default:
        $controller_name = 'HomeController';
        $controller_file = 'controller/home-controller.php';
        $method_to_call = 'home';
        break;
}

// Nếu file controller không tồn tại → fallback về home
if (!file_exists($controller_file)) {
    $controller_file = 'controller/home-controller.php';
    $method_to_call = 'home';
}

require_once $controller_file;

// Kiểm tra class controller có tồn tại không
if (!class_exists($controller_name)) {
    die("Lỗi hệ thống: Controller '$controller_name' không tồn tại!");
}

$controller = new $controller_name();

// Nếu method không tồn tại → về trang chủ
if (!method_exists($controller, $method_to_call)) {
    $controller = new HomeController();
    $controller->home();
    exit;
}

// Gọi method tương ứng
$controller->$method_to_call();

ob_end_flush();

include_once 'includes/footer.php';
?>