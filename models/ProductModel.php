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
    
    // HÀM LỌC THEO CATEGORY
    public function getProductsByCategory($category_id) {
        $category_id = (int)$category_id;
        
        // Lọc theo category_id và vẫn đổi tên cột img AS image
        $sql = "SELECT id, name, price, description, img AS image, category_id 
                FROM products 
                WHERE category_id = ?"; 
        
        $stmt = $this->conn->prepare($sql);
        
        // Bind tham số
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
    
    // START: HÀM MỚI ĐỂ LỌC KẾT HỢP CATEGORY VÀ GENDER
    /**
     * Lấy sản phẩm dựa trên Category ID VÀ Gender ID.
     */
    public function getProductsByCategoryAndGender($category_id, $gender_id) {
        $category_id = (int)$category_id;
        $gender_id = (int)$gender_id;
        
        // Truy vấn lọc theo cả hai điều kiện
        $sql = "SELECT id, name, price, description, img AS image, category_id, gender_id 
                FROM products 
                WHERE category_id = ? AND gender_id = ?"; 
        
        $stmt = $this->conn->prepare($sql);
        
        // Bind 2 tham số (ii: 2 integer)
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
    // END: HÀM MỚI
    
    // Đóng kết nối khi Model không còn được sử dụng
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>