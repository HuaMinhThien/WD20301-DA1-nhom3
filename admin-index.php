<?php

    require 'controller/admin-controller.php';

    include_once 'includes/admin-header.php';

    $controller = new AdminController();

    if(!isset($_GET['admin'])) {
        include_once "admin/thongke.php";
    }
    else{
        $page = $_GET['admin'];
        $controller->$page();
    }

?>