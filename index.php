<?php
// File: index.php - PHIÊN BẢN HOÀN CHỈNH & AN TOÀN

// 1. Bắt đầu session TRƯỚC MỌI OUTPUT
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. QUAN TRỌNG: KHÔNG ĐƯỢC INCLUDE HEADER NGAY ĐÂY!!!
// → Để dành cho controller tự include khi cần

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;

$controller_name = '';
$controller_file = '';
$method_to_call = $page;

switch ($page) {
    // Cart
    case 'cart':
    case 'add_to_cart':
    case 'remove_from_cart':
    case 'update_cart':
        $controller_name = 'CartController';
        $controller_file = 'controller/cart-controller.php';
        $method_to_call = 'handleRequest'; // CartController sẽ tự phân tuyến
        break;

    // HomeController - các trang thông thường
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

// Kiểm tra file controller tồn tại
if (!file_exists($controller_file)) {
    // Nếu không tìm thấy → fallback về home
    $controller_file = 'controller/home-controller.php';
    $method_to_call = 'home';
}

require_once $controller_file;

// Kiểm tra class tồn tại
if (!class_exists($controller_name)) {
    die("Lỗi hệ thống: Không tìm thấy controller $controller_name");
}

$controller = new $controller_name();

// Kiểm tra method tồn tại
if (!method_exists($controller, $method_to_call)) {
    // Nếu method không tồn tại → vẫn gọi home
    $controller = new HomeController();
    $controller->home();
    exit;
}

// === QUAN TRỌNG: GỌI CONTROLLER TRƯỚC KHI INCLUDE HEADER/FOOTER ===
ob_start(); // Bật buffer để phòng trường hợp còn sót header()

try {
    $controller->$method_to_call();
} catch (Exception $e) {
    echo "<h3>Lỗi hệ thống</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}

// Nếu controller đã redirect rồi → script đã dừng ở exit() → không chạy tới đây
// Nếu chưa redirect → nghĩa là cần hiển thị giao diện → lúc này mới include header/footer

// Kiểm tra xem có output nào chưa (từ controller)
if (!headers_sent()) {
    // Chỉ include header/footer nếu chưa có output nào bị gửi
    include_once 'includes/header.php';
    
    // Nếu controller chưa in gì (ví dụ chỉ redirect) → in nội dung từ buffer
    if (ob_get_length() > 0) {
        ob_end_flush();
    }
    
    include_once 'includes/footer.php';
} else {
    // Nếu header đã bị gửi (do lỗi đâu đó) → chỉ flush buffer
    ob_end_flush();
}