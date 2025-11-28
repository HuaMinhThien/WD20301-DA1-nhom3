<?php
// File: index.php (Đã sửa lỗi định tuyến cho login/register)

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
    case 'remove':
    case 'update_quantity':
    case 'add': 
        $controller_name = 'CartController';
        $controller_file = 'controller/cart-controller.php'; 
        // Phương thức mặc định cho CartController là 'index'
        $method_to_call = $action ?? 'index'; 
        break;
        
    // --- 2. ĐỊNH TUYẾN CHO HOMECONTROLLER ---
    // Gộp tất cả các trang HomeController vào một case
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
        // Phương thức gọi sẽ là tên trang (ví dụ: 'login' gọi login())
        $method_to_call = $page; 
        break;
        
    // --- 3. XỬ LÝ TRANG KHÔNG TỒN TẠI (404) ---
    default:
        $controller_name = 'HomeController';
        $controller_file = 'controller/home-controller.php';
        $method_to_call = 'home'; // Chuyển hướng về trang chủ
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
$controller = new $controller_name(); 

if ($controller && method_exists($controller, $method_to_call)) {
    $controller->$method_to_call();
} else {
    // Nếu phương thức không tồn tại, gọi home (hoặc index cho CartController)
    if ($controller_name === 'CartController') {
        $controller->index();
    } else {
        $controller->home();
    }
}

include_once 'includes/footer.php';
?>