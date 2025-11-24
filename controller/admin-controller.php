<?php


class AdminController {
    public function categories(){
        include_once 'admin/categories.php';
    }
    public function customers(){
        include_once 'admin/customers.php';
    }
    public function orders(){
        include_once 'admin/orders.php';
    }
    public function products(){
        include_once 'admin/admin-products.php';
    }
    public function thongke(){
        include_once 'admin/thongke.php';
    }
    
}

?>