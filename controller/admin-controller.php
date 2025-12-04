<?php
// FILE: controller/admin-controller.php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';

class AdminController {

    public function categories(){
        // Đảm bảo có kết nối DB trước khi include view
        global $conn;
        if (!isset($conn)) {
            $conn = mysqli_connect("localhost", "root", "", "duan_1");
            if (!$conn) {
                die("Lỗi kết nối CSDL: " . mysqli_connect_error());
            }
            mysqli_set_charset($conn, "utf8mb4");
        }

        // Đường dẫn đúng 100% với cấu trúc thư mục của bạn
        include_once 'admin/categories.php';
    }

    public function customers() {
        // 1. Kết nối Database (Thường biến $db đã có sẵn trong controller này hoặc cần khởi tạo lại)
        $database = new Database();
        $db = $database->getConnection();

        // 2. Gọi Model để lấy dữ liệu
        $userModel = new UserModel($db);
        $users = $userModel->getAllUsers(); // Lấy danh sách user

        // 3. Nhúng View và truyền biến $users sang
        // Lưu ý: Đường dẫn tính từ thư mục gốc (nơi chứa admin-index.php)
        include 'admin/customers.php'; 
    }

    public function orders(){
        include_once 'admin/orders.php';
    }

    public function products(){
        global $conn;
        if (!isset($conn)) {
            $conn = mysqli_connect("localhost", "root", "", "duan_1");
            mysqli_set_charset($conn, "utf8mb4");
        }
        include_once 'admin/admin-products.php';
    }

    public function thongke(){
        include_once 'admin/thongke.php';
    }

    // Các hàm mock giữ nguyên (xóa khi dùng Model thật)
    private function getMockProducts() {
        return [
            ['id' => 1, 'name' => 'Áo Polo KS25FH47C-SCWK', 'price' => 350000, 'category_name' => 'Áo', 'gender_name' => 'Nam', 'category_id' => 1, 'gender_id' => 1,
             'img' => 'ao-nam-Áo Polo KS25FH47C-SCWK-hình19.jpg', 'img_child' => 'ao-nam-Áo Polo KS25FH47C-SCWK-hình20.jpg',
             'description' => 'Mẫu áo Polo nam với chất liệu vải thoáng mát...', 'variants' => [
                 ['color_name' => 'Đen', 'size_name' => 'S', 'quantity' => 50],
                 ['color_name' => 'Trắng', 'size_name' => 'M', 'quantity' => 45],
                 ['color_name' => 'Xám', 'size_name' => 'L', 'quantity' => 30],
             ]],
            ['id' => 2, 'name' => 'Quần Tây Nam Form Ôm Vừa', 'price' => 480000, 'category_name' => 'Quần', 'gender_name' => 'Nam', 'category_id' => 2, 'gender_id' => 1,
             'img' => 'quan-tay-nam.jpg', 'img_child' => 'quan-tay-nam-2.jpg', 'description' => 'Quần tây công sở form ôm vừa, hiện đại.', 'variants' => [
                 ['color_name' => 'Xanh dương', 'size_name' => 'M', 'quantity' => 55],
                 ['color_name' => 'Đen', 'size_name' => 'L', 'quantity' => 40],
             ]],
        ];
    }
    private function getMockCategories() { return [['id' => 1, 'name' => 'Áo'], ['id' => 2, 'name' => 'Quần']]; }
    private function getMockGenders() { return [['id' => 1, 'name' => 'Nam'], ['id' => 2, 'name' => 'Nữ']]; }
    private function getMockColors() { return [['id' => 4, 'name' => 'Đen'], ['id' => 5, 'name' => 'Trắng']]; }
    private function getMockSizes() { return [['id' => 1, 'name' => 'S'], ['id' => 2, 'name' => 'M'], ['id' => 3, 'name' => 'L']]; }
}
?>