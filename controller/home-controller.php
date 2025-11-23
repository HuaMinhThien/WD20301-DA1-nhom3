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
    public function ao(){
        include_once 'pages/ao.php';
    }
    public function quan(){
        include_once 'pages/quan.php';
    }
    public function phukien(){
        include_once 'pages/phukien.php';
    }
    

}

?>