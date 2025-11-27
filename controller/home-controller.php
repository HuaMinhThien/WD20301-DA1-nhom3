<?php

require_once('models/ProductModel.php'); 

class HomeController {
    private $productModel;
    
    public function __construct() {
        // Khởi tạo đối tượng Model
        $this->productModel = new ProductModel(); 
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
            // Không đặt $category_id về null, mà sử dụng nó cho View (nếu cần hiển thị trạng thái lọc 12)
        } else {
            // Nếu không phải 12, vẫn sử dụng category_id bình thường
            $filter_category_ids = $category_id ? [$category_id] : null;
        }
        // =========================================================

        $price_min = null;
        $price_max = null;
        
        // XỬ LÝ KHOẢNG GIÁ (Giữ nguyên)
        if ($price_range) {
            $parts = explode('_', $price_range);
            if (count($parts) === 2) {
                $price_min = (int)$parts[0];
                $price_max = (int)$parts[1];
            }
        }
        
        // ✨ ĐÃ XÓA: Loại bỏ $imagePath cố định ở đây. View sẽ tự xác định.
        // Đường dẫn ảnh mặc định: $imagePath = 'assets/images/'; 

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
    // ... (Các hàm khác giữ nguyên)

    public function home() {
        // Lấy 10 sản phẩm ngẫu nhiên để hiển thị ở Section 3
        $random_products = $this->productModel->getFeaturedProductsRandom(10); 

        // Truyền $random_products sang View
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
    // Trong class HomeController
    public function products_Details() {
        // 1. Lấy ID sản phẩm từ URL (ví dụ: ?page=products_Details&id=123)
        $product_id = $_GET['id'] ?? null;
        $product = null;
        $related_products = [];
        $imagePath = 'assets/images/'; // Đường dẫn ảnh mặc định

        if ($product_id) {
            $product_id = (int)$product_id;
            
            // 2. Gọi Model để lấy chi tiết sản phẩm
            $product = $this->productModel->getProductDetails($product_id);

            if ($product) {
                // Xác định thư mục ảnh (Tương tự như logic ở trang products, dựa trên category_id)
                if ($product['category_id'] == 1) {
                    $imagePath .= 'ao/'; 
                } elseif ($product['category_id'] == 2) {
                    $imagePath .= 'quan/'; 
                }
                
                // 3. Gọi Model để lấy sản phẩm liên quan (cùng category và loại trừ chính nó)
                $related_products = $this->productModel->getRelatedProducts($product['category_id'], $product_id);
            }
        }
        
        // Truyền dữ liệu sang View
        include_once 'pages/products_Details.php';
    }
}
?>