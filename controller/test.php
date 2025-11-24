<?php
// Đảm bảo đường dẫn này đúng với vị trí của ProductModel.php
// Thường sẽ là 'Model/ProductModel.php' hoặc tương tự
require_once 'Model/ProductModel.php'; 

class HomeController {
    
    // Khởi tạo Model trong Controller để tiện sử dụng
    private $productModel;

    public function __construct() {
        // Khởi tạo đối tượng ProductModel khi HomeController được gọi
        $this->productModel = new ProductModel();
    }

    // Các hàm không cần dữ liệu
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

    // Hàm Hiển thị Trang Cửa Hàng (Shop) - Cần lấy dữ liệu sản phẩm
    public function shop(){
        
        // 1. GỌI MODEL: Lấy toàn bộ danh sách sản phẩm từ CSDL
        $products = $this->productModel->getAllProducts();
        
        // 2. TRUYỀN DỮ LIỆU CHO VIEW: Gói biến $products và include file View
        include_once 'pages/shop.php';
        
        // Lưu ý: Trong file 'pages/shop.php', bạn sẽ dùng vòng lặp foreach($products as $product)
        // để hiển thị từng sản phẩm.
    }
    
    // Hàm Hiển thị Trang Áo (Category) - Cần lấy dữ liệu sản phẩm theo danh mục
    public function ao(){
        
        // Ví dụ: Giả sử trong Model có hàm lấy sản phẩm theo danh mục
        $category_id = 1; // ID của danh mục 'Áo'
        $products_ao = $this->productModel->getProductsByCategory($category_id);
        
        // Chuyển dữ liệu đến View
        include_once 'pages/ao.php'; 
    }
    
    // Tương tự cho các danh mục khác
    public function quan(){
        // Logic lấy sản phẩm Quần...
        // include_once 'pages/quan.php';
    }
    public function phukien(){
        // Logic lấy sản phẩm Phụ Kiện...
        // include_once 'pages/phukien.php';
    }
    

}

?>