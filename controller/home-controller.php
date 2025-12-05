<?php
// File: controller/HomeController.php (Sửa lỗi session trong hàm login)

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
        // 1. Khởi tạo kết nối DB
        $this->db = (new Database())->getConnection(); 
        
        // 2. Khởi tạo đối tượng Model
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
        $userId = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 0;
        $cart_items = $this->cartModel->getCartItemsByUserId($userId);

        $grand_total = 0;
        foreach ($cart_items as $item) {
            $grand_total += $item['price'] * $item['quantity'];
        }

        include_once 'pages/thanhtoan.php'; 
    }
    public function cart_history() {
        $userId = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 0;
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
        // THÊM session_start() ở đầu hàm để tránh lỗi session
        session_start();

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
        
        // Dữ liệu giữ lại khi nhập sai
        $input_data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'dob' => $_POST['dob'] ?? '',
            'gender' => $_POST['gender'] ?? ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Lấy và làm sạch dữ liệu
            $name     = trim($input_data['name']);
            $email    = trim($input_data['email']);
            $phone    = trim($input_data['phone']);
            $dob      = $input_data['dob'];
            $gender   = $input_data['gender']; // 0 = Nữ, 1 = Nam
            $password = $_POST['password'] ?? '';

            // Validate
            if (empty($name) || empty($email) || empty($phone) || empty($password) || !isset($_POST['gender'])) {
                $error_message = "Vui lòng điền đầy đủ các thông tin bắt buộc.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = "Email không hợp lệ.";
            } elseif (strlen($password) < 6) {
                $error_message = "Mật khẩu phải có ít nhất 6 ký tự.";
            } elseif ($this->userModel->isEmailExist($email)) {
                $error_message = "Email này đã được sử dụng. Vui lòng đăng nhập.";
            } else {
                // Dữ liệu hợp lệ → lưu vào DB
                $data = [
                    'name'      => $name,
                    'email'     => $email,
                    'password'  => $password,        // Lưu plaintext (theo dữ liệu mẫu hiện tại)
                    'phone'     => $phone,
                    'dob'       => $dob,
                    'gender'    => $gender
                ];

                if ($this->userModel->registerUser($data)) {
                    // Đăng ký thành công → chuyển về trang login với thông báo
                    header("Location: index.php?page=login&register=success");
                    exit;
                } else {
                    $error_message = "Đăng ký thất bại. Vui lòng thử lại.";
                }
            }
        }

        // Hiển thị form đăng ký
        include_once 'pages/register.php';
    }
}