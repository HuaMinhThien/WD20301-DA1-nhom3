<?php 
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?route=login');
    exit;
}

    require 'controller/admin-controller.php';

    // BƯỚC 1: Lấy tham số trang TRƯỚC (Đặt dòng này lên đầu)
    $page = isset($_GET['admin']) ? $_GET['admin'] : 'thongke';

    // BƯỚC 2: Gọi Header SAU (Lúc này Header mới biết $page là gì để active)
    include_once 'includes/admin-header.php';

    // BƯỚC 3: Xử lý logic hiển thị nội dung chính
    $controller = new AdminController();

    if($page == 'thongke'){
        include_once "admin/thongke.php";
    } else {
        // ... code gọi controller của bạn ...
        $controller->$page();
    }
?>