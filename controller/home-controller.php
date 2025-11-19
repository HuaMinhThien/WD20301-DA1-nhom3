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
}

?>