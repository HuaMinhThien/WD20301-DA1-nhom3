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
        
        // Lấy ID từ URL (đổi tên biến để phản ánh việc đang lấy ID)
        $category_id = $_GET['category_id'] ?? null; 
        $gender_id = $_GET['gender_id'] ?? null; 
        
        // Ép kiểu sang int nếu có
        $category_id = $category_id ? (int)$category_id : null;
        $gender_id = $gender_id ? (int)$gender_id : null;
        
        // Đường dẫn ảnh mặc định
        $imagePath = 'assets/images/'; 

        
        if ($category_id) {
            
            if ($category_id == 1) {
                 $imagePath .= 'ao/'; 
            } elseif ($category_id == 2) {
                 $imagePath .= 'quan/'; 
            } else {
                 $imagePath = 'assets/images/'; // Mặc định nếu không tìm thấy
            }
            
            // 1a. Kiểm tra nếu có thêm điều kiện Giới tính ID
            if ($gender_id) {
                // GỌI HÀM LỌC KÉP
                $products = $this->productModel->getProductsByCategoryAndGender($category_id, $gender_id);
            } else {
                // 1b. Chỉ lọc theo Category ID
                $products = $this->productModel->getProductsByCategory($category_id);
            }
        
        // 2. Lọc chỉ theo Giới tính ID (Trường hợp không có Category ID, nhưng có Gender ID)
        } elseif ($gender_id) {
            
            // Controller gọi Model để lấy dữ liệu theo Gender ID
            $products = $this->productModel->getProductsByGender($gender_id);
            
        } else {
            // 3. Trường hợp không lọc (Mặc định)
            $products = $this->productModel->getAllProducts();
        }

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