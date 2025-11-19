<?php
    require 'controller/home-controller.php';
        include_once 'includes/header.html';

        //main
        $controller = new HomeController();

        if(!isset($_GET['page'])) {
            include_once "pages/home.php";
        }
        else{
            $page = $_GET['page'];
            $controller->$page();
        }

        include_once 'includes/footer.html';
?>