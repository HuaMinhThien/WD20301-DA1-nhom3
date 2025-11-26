<?php

// Đường dẫn này phải đúng, giả định models/ProductModel.php nằm ngang hàng với index.php
require_once('models/ProductModel.php'); 

class HomeController {
    // Thuộc tính để lưu đối tượng Model
    private $productModel;
    
    // Ánh xạ tên category trong URL thành ID và Tên thư mục ảnh
    private $categoryMap = [
        'ao' => [
            'id' => 1, 
            'folder' => 'ao' // Đường dẫn: assets/images/ao/
        ],
        'quan' => [
            'id' => 2, 
            'folder' => 'quan' // Đường dẫn: assets/images/quan/
        ],
        // Thêm các category khác nếu cần:
        // 'dobo' => ['id' => 3, 'folder' => 'dobo'], 
    ];

    // Ánh xạ tên giới tính trong URL thành ID trong CSDL (1: Nam, 2: Nữ)
    private $genderMap = [
        'nam' => 1, 
        'nu' => 2,
    ];

    // Hàm khởi tạo (Constructor) để tạo đối tượng Model 
    public function __construct() {
        // Khởi tạo đối tượng Model
        $this->productModel = new ProductModel(); 
    }

    // Phương thức đã sửa: Lấy dữ liệu Sản phẩm theo Category + Gender, Category, Gender, hoặc tất cả
    public function products() {
        $products = [];
        $category_name = $_GET['category'] ?? null; // Lấy 'category' từ URL
        $gender_name = $_GET['gender'] ?? null;     // Lấy 'gender' từ URL
        
        // Đường dẫn ảnh mặc định
        $imagePath = 'assets/images/'; 

        // 1. Lọc theo Category (Ưu tiên kiểm tra Category trước)
        if ($category_name && isset($this->categoryMap[$category_name])) {
            $category_config = $this->categoryMap[$category_name];
            $category_id = $category_config['id'];
            
            // Cập nhật đường dẫn thư mục ảnh theo category
            $imagePath .= $category_config['folder'] . '/'; 
            
            // 1a. Kiểm tra nếu có thêm điều kiện Giới tính
            if ($gender_name && isset($this->genderMap[$gender_name])) {
                $gender_id = $this->genderMap[$gender_name];
                
                // GỌI HÀM LỌC KÉP MỚI
                $products = $this->productModel->getProductsByCategoryAndGender($category_id, $gender_id);
            } else {
                // 1b. Chỉ lọc theo Category
                $products = $this->productModel->getProductsByCategory($category_id);
            }
        
        // 2. Lọc chỉ theo Giới tính (Trường hợp không có Category trong URL, nhưng có Gender)
        } elseif ($gender_name && isset($this->genderMap[$gender_name])) {
            $gender_id = $this->genderMap[$gender_name];
            
            // Controller gọi Model để lấy dữ liệu theo Gender ID
            $products = $this->productModel->getProductsByGender($gender_id);
            
            // $imagePath vẫn là 'assets/images/'
            
        } else {
            // 3. Trường hợp không lọc (Mặc định)
            $products = $this->productModel->getAllProducts();
        }

        // Nạp View (pages/products.php) và truyền cả $products và $imagePath
        include_once 'pages/products.php';
    }

    // Các phương thức khác giữ nguyên
    public function home() {
        include_once 'pages/home.php';
    }
    public function user() {
        include_once 'pages/user.php';
    }
    public function cart() {
        include_once 'pages/cart.php';
    }
    public function cart_history() {
        include_once 'pages/cart-history.php';
    }
    public function sale() {
        include_once 'pages/sale.php';
    }
    public function shop() {
        include_once 'pages/shop.php';
    }
    public function products_Details() {
        include_once 'pages/products_Details.php';
    }
}
?>