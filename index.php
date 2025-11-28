<?php

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
    case 'cart':
    case 'remove':
    case 'update_quantity':
    case 'add': 
        $controller_name = 'CartController';
        $controller_file = 'controller/cart-controller.php'; 
        // SỬA LỖI: Phương thức mặc định cho CartController là 'index'
        $method_to_call = $action ?? 'index'; 
        break;
        
    case 'products':
    case 'products_Details':
    case 'home':
    default:
        $controller_name = 'HomeController';
        $controller_file = 'controller/home-controller.php';
        
        if ($page === 'products' || $page === 'products_Details') {
            $method_to_call = $page;
        } else {
            $method_to_call = 'home';
        }
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
    // Gọi home() cho HomeController và index() cho CartController
    if ($controller_name === 'CartController') {
        $controller->index();
    } else {
        $controller->home();
    }
}

include_once 'includes/footer.php';
?>