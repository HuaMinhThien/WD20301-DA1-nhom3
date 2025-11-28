<?php
// File: controller/HomeController.php (Đã sửa lỗi ArgumentCountError)

require_once('models/ProductModel.php'); 
require_once('config/Database.php'); // Cần nạp để lấy kết nối DB

class HomeController {
    private $productModel;
    private $db; // Thuộc tính để lưu kết nối DB

    public function __construct() {
        // 1. Khởi tạo kết nối DB (Sửa lỗi: Phải khởi tạo kết nối trước)
        // Giả định class Database tồn tại và có hàm getConnection() trả về PDO
        $this->db = (new Database())->getConnection(); 
        
        // 2. Khởi tạo đối tượng Model (Sửa lỗi: Truyền kết nối DB vào)
        $this->productModel = new ProductModel($this->db); 
    }

    // Trong class HomeController
    public function products() {
        $products = [];
        
        // LẤY DANH MỤC VÀ GIỚI TÍNH TỪ MODEL VÀ TRUYỀN SANG VIEW
        $categories = $this->productModel->getAllCategories();
        $genders = $this->productModel->getAllGenders();
        
        // Lấy Tham số Lọc từ URL
        $category_id = $_GET['category_id'] ?? null; 
        $gender_id = $_GET['gender_id'] ?? null; 
        $price_range = $_GET['price_range'] ?? null; 
        
        // Ép kiểu sang int nếu có
        $category_id = $category_id ? (int)$category_id : null;
        $gender_id = $gender_id ? (int)$gender_id : null;
        
        // =========================================================
        // LOGIC XỬ LÝ category_id = 12 và chuẩn bị filters
        // =========================================================
        $filter_category_ids = null;
        if ($category_id === 12) {
            // Nếu category_id là 12, đặt mảng các ID cần lọc
            $filter_category_ids = [3, 4, 5, 6, 7, 8, 9];
        } else {
            // Nếu không phải 12, vẫn sử dụng category_id bình thường
            $filter_category_ids = $category_id ? [$category_id] : null;
        }
        // =========================================================

        $price_min = null;
        $price_max = null;
        
        // XỬ LÝ KHOẢNG GIÁ
        if ($price_range) {
            $parts = explode('_', $price_range);
            if (count($parts) === 2) {
                $price_min = (int)$parts[0];
                $price_max = (int)$parts[1];
            }
        }
        
        // CHUẨN BỊ MẢNG THAM SỐ LỌC CHO MODEL
        $filters = [
            'category_ids' => $filter_category_ids, 
            'gender_id' => $gender_id,
            'price_min' => $price_min, 
            'price_max' => $price_max 
        ];
        
        // GỌI HÀM LỌC TỔNG QUÁT TRONG MODEL
        $products = $this->productModel->getFilteredProducts($filters);

        // Nạp View (pages/products.php)
        include_once 'pages/products.php';
    }
    
    // ---
    
    public function home() {
        // Lấy 20 sản phẩm ngẫu nhiên để hiển thị ở View home
        $random_products = $this->productModel->getFeaturedProductsRandom(20); 

        // Truyền $random_products sang View
        include_once 'pages/home.php';
    }
    
    // ---
    
    public function user() {
        include_once 'pages/user.php';
    }
    public function cart() {
        // Giả định CartController xử lý logic giỏ hàng
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
    
    // ---
    
    public function products_Details() {
        $product_id = $_GET['id'] ?? null;
        $product = null;
        $related_products = [];
        $imagePath = 'assets/images/'; // Đường dẫn ảnh mặc định

        if ($product_id) {
            $product_id = (int)$product_id;
            
            // 2. Gọi Model để lấy chi tiết sản phẩm
            $product = $this->productModel->getProductDetails($product_id);

            if ($product) {
                // Xác định thư mục ảnh
                if ($product['category_id'] == 1) {
                    $imagePath .= 'ao/';    
                } elseif ($product['category_id'] == 2) {
                    $imagePath .= 'quan/'; 
                }
                
                // 3. Gọi Model để lấy sản phẩm liên quan
                $related_products = $this->productModel->getRelatedProducts($product['category_id'], $product_id);
            }
        }
        
        // Truyền dữ liệu sang View
        include_once 'pages/products_Details.php';
    }
}