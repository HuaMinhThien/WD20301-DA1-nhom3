<?php
// File: controller/HomeController.php (Đã sửa lỗi ArgumentCountError)

require_once('models/ProductModel.php'); 
require_once('models/UserModel.php');
require_once('models/CartModels.php'); 
require_once('models/BillModel.php');  
require_once('config/Database.php');

class HomeController {
    private $productModel;
    private $userModel;
    private $db;
    private $cartModel;
    private $billModel;

    public function __construct() {
        // 1. Khởi tạo kết nối DB (Sửa lỗi: Phải khởi tạo kết nối trước)
        // Giả định class Database tồn tại và có hàm getConnection() trả về PDO
        $this->db = (new Database())->getConnection(); 
        
        // 2. Khởi tạo đối tượng Model (Sửa lỗi: Truyền kết nối DB vào)
        $this->productModel = new ProductModel($this->db); 
        $this->userModel = new UserModel($this->db);
        $this->cartModel = new CartModel($this->db); 
        $this->billModel = new BillModel($this->db); 
    }

    public function products() {
        $categories = $this->productModel->getAllCategories();
        $genders    = $this->productModel->getAllGenders();

        // Lấy tham số từ URL
        $category_id = $_GET['category_id'] ?? null;
        $gender_id   = $_GET['gender_id']   ?? null;
        $price_range = $_GET['price_range'] ?? null;
        $color_id    = $_GET['color_id'] ?? null;
        $size_id     = $_GET['size_id']     ?? null;

        // Ép kiểu an toàn
        $category_id = $category_id ? (int)$category_id : null;
        $gender_id   = $gender_id   ? (int)$gender_id   : null;
        $color_id    = $color_id    ? (int)$color_id    : null;
        $size_id     = $size_id     ? (int)$size_id     : null;

        // =========================================================
        // XỬ LÝ category_id = 12 → hiện toàn bộ phụ kiện
        // =========================================================
        $filter_category_ids = null;
        if ($category_id === 12) {
            $filter_category_ids = [3, 4, 5, 6, 7, 8]; // Thắt lưng, Kính, Túi, Vớ, Balo, Ví
        } elseif ($category_id !== null) {
            $filter_category_ids = [$category_id];
        }
        // Nếu không có category_id → để null = hiện hết (tùy bạn muốn)

        // =========================================================
        // XỬ LÝ KHOẢNG GIÁ
        // =========================================================
        $price_min = null;
        $price_max = null;
        if ($price_range) {
            $parts = explode('_', $price_range);
            if (count($parts) === 2) {
                $price_min = (int)$parts[0];
                $price_max = (int)$parts[1];
            }
        }

        // =========================================================
        // GOM THAM SỐ GỬI QUA MODEL
        // =========================================================
        $filters = [
            'category_ids' => $filter_category_ids,   // mảng hoặc null
            'gender_id'    => $gender_id,           // 1 = Nam, 2 = Nữ, null = cả hai
            'price_min'    => $price_min,
            'price_max'    => $price_max,
            'color_id'     => $color_id,
            'size_id'      => $size_id
        ];

        // GỌI MODEL – BÂY GIỜ DÙNG pv.category_id và pv.gender_id
        $products = $this->productModel->getFilteredProducts($filters);

        // Truyền ra view
        include_once 'pages/products.php';
    }
        
    public function home() {
        // Lấy 20 sản phẩm ngẫu nhiên để hiển thị ở View home
        $random_products = $this->productModel->getFeaturedProductsRandom(20); 

        // Truyền $random_products sang View
        include_once 'pages/home.php';
    }
    
    public function user() {
        include_once 'pages/user.php';
    }
    public function cart() {
        // Giả định CartController xử lý logic giỏ hàng
        include_once 'pages/cart.php';
    }

    public function thanhtoan() {
        $userId = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2;
        $cart_items = $this->cartModel->getCartItemsByUserId($userId);

        $grand_total = 0;
        foreach ($cart_items as $item) {
            $grand_total += $item['price'] * $item['quantity'];
        }

        include_once 'pages/thanhtoan.php'; 
    }
    public function cart_history() {
        $userId = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2;
        $bills = $this->billModel->getBillsByUserId($userId); 

        include_once 'pages/cart-history.php'; 
    }
    public function sale() {
        include_once 'pages/sale.php';
    }
    public function shop() {
        include_once 'pages/shop.php';
    }

    public function products_Details() {
        $id = $_GET['id'] ?? null;
        if (!$id || !is_numeric($id)) {
            echo "<h3 style='text-align:center;padding:50px;'>Sản phẩm không tồn tại!</h3>";
            return;
        }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "<h3 style='text-align:center;padding:50px;'>Không tìm thấy sản phẩm!</h3>";
            return;
        }

        // THÊM ĐOẠN NÀY ĐỂ LẤY COLOR/SIZE TỪ VARIANT
        $variants = $this->productModel->getProductVariants($id);
        $available_colors = [];
        $available_sizes = [];
        foreach ($variants as $v) {
            $available_colors[$v['color_id']] = $v['color_name'];
            $available_sizes[$v['size_id']] = $v['size_name'];
        }
        $available_colors = array_unique($available_colors);
        $available_sizes = array_unique($available_sizes);

        $related_products = $this->productModel->getRelatedProducts($product['category_id'], $id, 8);

        $imagePath = 'assets/images/sanpham/'; 

        include_once 'pages/products_Details.php';
    }
    public function login() {
        // ============ CHỈ XỬ LÝ KHI NGƯỜI DÙNG NHẤN ĐĂNG NHẬP (POST) ============
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Kiểm tra đầu vào cơ bản
            if (empty($email) || empty($password)) {
                $_SESSION['login_error'] = 'Vui lòng nhập đầy đủ Email và Mật khẩu.';
                header('Location: index.php?page=login');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['login_error'] = 'Địa chỉ Email không hợp lệ.';
                header('Location: index.php?page=login');
                exit;
            }

            // Gọi model để kiểm tra đăng nhập
            $user = $this->userModel->loginUser($email, $password);

            if ($user) {
                // Đăng nhập thành công → lưu session
                session_start();
                $_SESSION['user_id']      = $user['id'];
                $_SESSION['user_name']    = $user['name'] ?? $user['email'];
                $_SESSION['user_role']    = $user['role'];
                $_SESSION['is_logged_in'] = true;

                // Chuyển hướng theo role
                if ($user['role'] === 'admin') {
                    header('Location: admin-index.php');
                } else {
                    header('Location: index.php?page=user&user_id=' . $user['id']);
                }
                exit;
            } else {
                // Sai tài khoản/mật khẩu
                $_SESSION['login_error'] = 'Email hoặc Mật khẩu không chính xác.';
                header('Location: index.php?page=login');
                exit;
            }
        }

        // ============ CHỈ CHẠY KHI TRUY CẬP TRỰC TIẾP TRANG ĐĂNG NHẬP (GET) ============
        // Lấy lỗi từ session (nếu có) rồi xóa đi
        $error_message = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);

        // Giữ lại email đã nhập (nếu có lỗi)
        $old_email = $_POST['email'] ?? '';

        // Bây giờ mới được include view (vì không có redirect nào nữa)
        include_once 'pages/login.php';
    }


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
