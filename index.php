<?php
// File: index.php - ĐÃ SỬA HOÀN HẢO CHO DỰ ÁN CỦA BẠN
// Chỉ cần thay thế file này → đăng nhập + redirect hoạt động ngon lành!

// 1. BẮT BUỘC: Bắt đầu session TRƯỚC MỌI OUTPUT
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}
// 2. Bật output buffering để đảm bảo header() luôn hoạt động
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

// QUAN TRỌNG NHẤT: GỌI CONTROLLER TRƯỚC (để header("Location: ...") hoạt động)
$controller->$method_to_call();

// SAU KHI CONTROLLER XỬ LÝ XONG:
// - Nếu đăng nhập thành công → đã redirect → không chạy tới đây
// - Nếu chưa redirect (hiển thị trang) → lúc này mới được in header + footer


// Xuất nội dung từ buffer (nếu có)
ob_end_flush();

include_once 'includes/footer.php';
?>