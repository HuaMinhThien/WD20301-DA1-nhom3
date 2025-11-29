<?php
// File: index.php (ĐÃ SỬA)

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once 'includes/header.php';

$page = $_GET['page'] ?? 'home'; 
$action = $_GET['action'] ?? null; 

$controller_name = '';
$controller_file = '';
$method_to_call = $page; 

switch ($page) {
    // --- 1. ĐỊNH TUYẾN CHO CARTCONTROLLER ---
    case 'cart':
        $controller_name = 'CartController';
        $controller_file = 'controller/cart-controller.php'; 
        // 🚨 SỬA: Gọi handleRequest() thay vì gọi method trực tiếp
        $method_to_call = 'handleRequest';
        break;
        
    // --- 2. ĐỊNH TUYẾN CHO HOMECONTROLLER ---
    case 'products':
    case 'products_Details':
    case 'home':
    case 'login':       
    case 'register':    
    case 'user':        
    case 'cart_history': 
    case 'sale':        
    case 'shop':        
        $controller_name = 'HomeController';
        $controller_file = 'controller/home-controller.php';
        $method_to_call = $page; 
        break;
        
    // --- 3. XỬ LÝ TRANG KHÔNG TỒN TẠI (404) ---
    default:
        $controller_name = 'HomeController';
        $controller_file = 'controller/home-controller.php';
        $method_to_call = 'home';
        break;
}

$is_file_found = file_exists($controller_file);

if (!$is_file_found) {
    $controller_name = 'HomeController';
    $controller_file = 'controller/home-controller.php'; 
    $method_to_call = 'home';
    
    if (!file_exists($controller_file)) {
         die("Lỗi nghiêm trọng: Không tìm thấy file Controller mặc định: " . $controller_file);
    }
}

require_once $controller_file; 

// 🚨 SỬA: Kiểm tra class tồn tại trước khi khởi tạo
if (!class_exists($controller_name)) {
    die("Lỗi: Không tìm thấy class $controller_name");
}

$controller = new $controller_name(); 

if ($controller && method_exists($controller, $method_to_call)) {
    $controller->$method_to_call();
} else {
    // 🚨 SỬA: Xử lý lỗi tốt hơn
    echo "<div style='text-align: center; padding: 50px;'>";
    echo "<h3>Lỗi 404 - Trang không tồn tại</h3>";
    echo "<p>Phương thức <strong>$method_to_call</strong> không tồn tại trong <strong>$controller_name</strong></p>";
    echo "<a href='index.php'>Quay về trang chủ</a>";
    echo "</div>";
}

include_once 'includes/footer.php';
?>