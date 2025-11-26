<?php
// THÔNG TIN KẾT NỐI (Bạn có thể giữ phần này trong file riêng biệt hoặc đặt ở đây)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "duan_1"; // Đảm bảo đúng tên database

// Hàm kết nối DB (ĐƯỢC GIỮ LẠI BÊN NGOÀI LỚP)
function connect_db() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Kết nối database thất bại: " . $conn->connect_error);
    }
    $conn->set_charset("utf8"); 
    return $conn;
}

// LỚP MODEL CHỨA CÁC PHƯƠNG THỨC LẤY DỮ LIỆU SẢN PHẨM
class ProductModel {
    private $conn;

    public function __construct() {
        // Tự động kết nối khi tạo Model
        $this->conn = connect_db();
    }

    // Lấy tất cả danh mục
    public function getAllCategories() {
        $sql = "SELECT id, name FROM category ORDER BY id ASC"; 
        $result = $this->conn->query($sql);
        
        $categories = [];
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        
        return $categories;
    }
    
    // START: HÀM MỚI - Lấy tất cả giới tính
    public function getAllGenders() {
        $sql = "SELECT id, name FROM gender ORDER BY id ASC"; 
        $result = $this->conn->query($sql);
        
        $genders = [];
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $genders[] = $row;
            }
        }
        
        return $genders;
    }
    // END: HÀM MỚI

    // Hàm lấy tất cả sản phẩm
    public function getAllProducts() {
        // img AS image để khớp với $product['image'] trong View
        $sql = "SELECT id, name, price, description, img AS image FROM products"; 
        $result = $this->conn->query($sql);
        
        $products = [];
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        return $products;
    }
    
    // HÀM LỌC THEO CATEGORY (ID)
    public function getProductsByCategory($category_id) {
        $category_id = (int)$category_id;
        
        $sql = "SELECT id, name, price, description, img AS image, category_id 
                FROM products 
                WHERE category_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        $stmt->close();
        return $products;
    }
    
    // HÀM LỌC KẾT HỢP CATEGORY (ID) VÀ GENDER (ID)
    public function getProductsByCategoryAndGender($category_id, $gender_id) {
        $category_id = (int)$category_id;
        $gender_id = (int)$gender_id;
        
        $sql = "SELECT id, name, price, description, img AS image, category_id, gender_id 
                FROM products 
                WHERE category_id = ? AND gender_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $category_id, $gender_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        $stmt->close();
        return $products;
    }
    
    // HÀM LỌC CHỈ THEO GENDER (ID)
    public function getProductsByGender($gender_id) {
        $gender_id = (int)$gender_id;
        
        $sql = "SELECT id, name, price, description, img AS image, gender_id 
                FROM products 
                WHERE gender_id = ?"; 
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $gender_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        $stmt->close();
        return $products;
    }

    // Đóng kết nối khi Model không còn được sử dụng
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>