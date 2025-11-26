<?php
    // Bỏ require 'controller/home-controller.php' ở đây
    // index.php
    
    // Kéo header vào trước
    include_once 'includes/header.php';

    // KÉO VÀO SAU KHI CÓ HEADER
    require 'controller/home-controller.php';
    
    // Tạo đối tượng Controller
    $controller = new HomeController();

    // Lấy tên trang (page)
    $page = $_GET['page'] ?? 'home'; // Dùng toán tử null coalescing (PHP 7+) hoặc ternary operator

    // Gọi phương thức tương ứng
    if (method_exists($controller, $page)) {
        $controller->$page();
    } else {
        // Xử lý trang 404 hoặc trang mặc định (home)
        $controller->home(); 
    }

    // Kéo footer vào
    include_once 'includes/footer.php';
?>