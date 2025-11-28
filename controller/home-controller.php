<?php
// File: controller/HomeController.php (Đã sửa lỗi ArgumentCountError)

require_once('models/ProductModel.php'); 
require_once('models/UserModel.php');
require_once('config/Database.php'); // Cần nạp để lấy kết nối DB

class HomeController {
    private $productModel;
    private $userModel;
    private $db; // Thuộc tính để lưu kết nối DB

    public function __construct() {
        // 1. Khởi tạo kết nối DB (Sửa lỗi: Phải khởi tạo kết nối trước)
        // Giả định class Database tồn tại và có hàm getConnection() trả về PDO
        $this->db = (new Database())->getConnection(); 
        
        // 2. Khởi tạo đối tượng Model (Sửa lỗi: Truyền kết nối DB vào)
        $this->productModel = new ProductModel($this->db); 
        $this->userModel = new UserModel($this->db);
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
    public function login() {
        // Biến để lưu thông báo lỗi
        $error_message = '';
        $success_message = '';

        // 1. Kiểm tra nếu form đã được POST (Người dùng nhấn nút Đăng nhập)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Loại bỏ khoảng trắng thừa
            $email = trim($email);
            $password = trim($password);

            // 2. Kiểm tra dữ liệu đầu vào cơ bản
            if (empty($email) || empty($password)) {
                $error_message = "Vui lòng nhập đầy đủ Email và Mật khẩu.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = "Địa chỉ Email không hợp lệ.";
            } else {
                // 3. Gọi Model để kiểm tra đăng nhập
                // Giả định loginUser() trả về đối tượng người dùng (hoặc mảng) nếu thành công, false nếu thất bại
                $user = $this->userModel->loginUser($email, $password);

                if ($user) {
                    // 4. Đăng nhập thành công: Lưu session, chuyển hướng
                    
                    // Khởi động session nếu chưa có
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    // Lưu thông tin người dùng vào session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'] ?? $user['email'];
                    $_SESSION['is_logged_in'] = true;
                    
                    // Thiết lập thông báo thành công và chuyển hướng đến trang chủ hoặc trang người dùng
                    // Chú ý: Cần exit sau header để ngăn chặn code phía sau tiếp tục chạy
                    header('Location: index.php?route=user'); 
                    exit;

                } else {
                    // 5. Đăng nhập thất bại
                    $error_message = "Email hoặc Mật khẩu không chính xác.";
                }
            }
        }
        
        // 6. Nạp View: Hiển thị form đăng nhập (hoặc hiển thị lại với lỗi)
        include_once 'pages/login.php';
    }
    // =========================================================
    // HÀM XỬ LÝ ĐĂNG KÝ (REGISTER)
    // =========================================================
    public function register() {
        $error_message = '';
        $success_message = '';
        
        // Dữ liệu người dùng nhập (được giữ lại khi form thất bại)
        $input_data = [
            'name' => '',
            'email' => '',
            'phone_number' => '',
            'dob' => '',
            'gender' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Lấy và làm sạch dữ liệu
            $input_data['name'] = trim($_POST['name'] ?? '');
            $input_data['email'] = trim($_POST['email'] ?? '');
            $input_data['phone_number'] = trim($_POST['phone_number'] ?? '');
            $input_data['dob'] = trim($_POST['dob'] ?? '');
            $input_data['gender'] = $_POST['gender'] ?? ''; // '0' (Nữ) hoặc '1' (Nam)
            $password = $_POST['password'] ?? '';
            
            // 2. Kiểm tra tính hợp lệ cơ bản
            if (empty($input_data['name']) || empty($input_data['email']) || empty($password)) {
                $error_message = "Vui lòng nhập đầy đủ các trường bắt buộc.";
            } elseif (!filter_var($input_data['email'], FILTER_VALIDATE_EMAIL)) {
                $error_message = "Địa chỉ Email không hợp lệ.";
            } elseif (strlen($password) < 6) {
                $error_message = "Mật khẩu phải có ít nhất 6 ký tự.";
            } elseif ($this->userModel->isEmailExist($input_data['email'])) { // Kiểm tra Email đã tồn tại
                $error_message = "Email này đã được đăng ký. Vui lòng đăng nhập.";
            } else {
                
                // 3. Hash mật khẩu và chuẩn bị dữ liệu cho Model
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $data = [
                    'name' => $input_data['name'],
                    'email' => $input_data['email'],
                    'password_hash' => $hashed_password,
                    'phone_number' => $input_data['phone_number'],
                    'dob' => $input_data['dob'],
                    'gender' => $input_data['gender']
                ];

                // 4. Gọi Model để lưu vào DB
                if ($this->userModel->registerUser($data)) {
                    $success_message = "Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.";
                    
                    // Chuyển hướng về trang đăng nhập sau khi đăng ký thành công
                    header('Location: index.php?route=login&status=success'); 
                    exit;
                    
                } else {
                    $error_message = "Đã xảy ra lỗi trong quá trình đăng ký tài khoản. Vui lòng thử lại.";
                }
            }
        }
        
        // Nạp View (Hiển thị form đăng ký với lỗi hoặc dữ liệu đã nhập)
        include_once 'pages/register.php';
    }
}
