<?php


class HomeController {
    public function home(){
        include_once 'pages/home.php';
    }
    public function user(){
        include_once 'pages/user.php';
    }
    public function cart(){
        include_once 'pages/cart.php';
    }
    public function cart_history(){
        include_once 'pages/cart-history.php';
    }
    public function sale(){
        include_once 'pages/sale.php';
    }
    public function shop(){
        include_once 'pages/shop.php';
    }
    public function products(){
        include_once 'pages/products.php';
    }
    public function products_Details(){
        include_once 'pages/products_Details.php';
    }
    

}

?>