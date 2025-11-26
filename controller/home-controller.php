<?php

require_once('models/ProductModel.php'); 

class HomeController {
    private $productModel;
    
    public function __construct() {
        // Khởi tạo đối tượng Model
        $this->productModel = new ProductModel(); 
    }

    public function products() {
        $products = [];
        
        // LẤY DANH MỤC VÀ GIỚI TÍNH TỪ MODEL VÀ TRUYỀN SANG VIEW
        $categories = $this->productModel->getAllCategories();
        $genders = $this->productModel->getAllGenders();
        
        // Lấy Tham số Lọc từ URL
        $category_id = $_GET['category_id'] ?? null; 
        $gender_id = $_GET['gender_id'] ?? null; 
        $price_range = $_GET['price_range'] ?? null; // THAM SỐ LỌC GIÁ MỚI
        
        // Ép kiểu sang int nếu có
        $category_id = $category_id ? (int)$category_id : null;
        $gender_id = $gender_id ? (int)$gender_id : null;
        
        $price_min = null;
        $price_max = null;
        
        // XỬ LÝ KHOẢNG GIÁ (Tách chuỗi "min_max" thành min và max)
        if ($price_range) {
            $parts = explode('_', $price_range);
            if (count($parts) === 2) {
                $price_min = (int)$parts[0];
                $price_max = (int)$parts[1];
            }
        }
        
        // Đường dẫn ảnh mặc định
        $imagePath = 'assets/images/'; 

        // 1. CẬP NHẬT ĐƯỜNG DẪN ẢNH (Dựa trên logic của bạn)
        if ($category_id) {
            if ($category_id == 1) {
                $imagePath .= 'ao/'; 
            } elseif ($category_id == 2) {
                $imagePath .= 'quan/'; 
            } // Thêm các điều kiện khác nếu cần
        } 
        
        // 2. CHUẨN BỊ MẢNG THAM SỐ LỌC CHO MODEL
        $filters = [
            'category_id' => $category_id,
            'gender_id' => $gender_id,
            'price_min' => $price_min, // Thêm min
            'price_max' => $price_max  // Thêm max
        ];
        
        // 3. GỌI HÀM LỌC TỔNG QUÁT TRONG MODEL
        // Hàm này sẽ xử lý kết hợp tất cả các bộ lọc (Category, Gender, Price)
        $products = $this->productModel->getFilteredProducts($filters);

        // Nạp View (pages/products.php) và truyền $products, $imagePath, $categories VÀ $genders
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