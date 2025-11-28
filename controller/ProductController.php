<?php
include_once 'config/db.php';
include_once 'models/ProductModel.php'; // Gọi file Model của bạn

class ProductController {
    private $model;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        // Khởi tạo Model với kết nối PDO
        $this->model = new ProductModel($db);
    }

    public function handleRequest() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $editProduct = null;

        switch ($action) {
            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $img = $this->handleImageUpload();
                    // Gọi hàm insertProduct có sẵn trong Model của bạn
                    $this->model->insertProduct(
                        $_POST['name'], 
                        $_POST['price'], 
                        $_POST['storage'], 
                        $_POST['description'], 
                        $img, 
                        $_POST['category_id'], // Cần thêm input này ở view
                        $_POST['gender_id']    // Cần thêm input này ở view
                    );
                    header("Location: admin-index.php");
                }
                break;
            
            case 'edit':
                if (isset($_GET['id'])) {
                    // Gọi hàm getProductDetails có sẵn trong Model của bạn
                    $editProduct = $this->model->getProductDetails($_GET['id']);
                }
                break;

            case 'update':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $img = $this->handleImageUpload();
                    // Gọi hàm updateProduct có sẵn trong Model của bạn
                    // Nếu $img null (không up ảnh mới), Model của bạn đã tự xử lý giữ ảnh cũ
                    $this->model->updateProduct(
                        $_POST['id'],
                        $_POST['name'],
                        $_POST['price'],
                        $_POST['storage'],
                        $_POST['description'],
                        $img,
                        $_POST['category_id'],
                        $_POST['id_gender']
                    );
                    header("Location: admin-index.php");
                }
                break;

            case 'delete':
                if (isset($_GET['id'])) {
                    // Gọi hàm deleteProduct có sẵn trong Model của bạn
                    $this->model->deleteProduct($_GET['id']);
                    header("Location: admin-index.php");
                }
                break;
        }

        // Lấy danh sách sản phẩm để hiển thị
        // LƯU Ý: Hàm getAllProducts của bạn chưa select cột 'storage', 
        // bạn nên sửa lại câu SQL trong Model: "SELECT id, name, price, storage, description, img AS image FROM products"
        $products = $this->model->getAllProducts();
        
        include 'admin/admin-products.php';
    }

    // Hàm phụ trợ để upload ảnh
    private function handleImageUpload() {
        if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
            $target_dir = "uploads/"; // Tạo thư mục uploads cùng cấp index.php
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            
            $target_file = $target_dir . basename($_FILES["img"]["name"]);
            move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
            return $target_file;
        }
        return null;
    }
}
?>