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
  
  // Lấy tất cả giới tính
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
  
  // HÀM LỌC TỔNG QUÁT (Giữ nguyên)
  public function getFilteredProducts($filters) {
    // Giá trị mặc định
    $category_id = $filters['category_id'] ?? null;
    $gender_id = $filters['gender_id'] ?? null;
    $price_min = $filters['price_min'] ?? null;
    $price_max = $filters['price_max'] ?? null;

    $sql = "SELECT id, name, price, description, img AS image, category_id, gender_id 
        FROM products 
        WHERE 1=1"; // Bắt đầu bằng điều kiện luôn đúng
    
    $params = [];
    $types = '';

    if ($category_id !== null) {
      $sql .= " AND category_id = ?";
      $params[] = $category_id;
      $types .= 'i';
    }

    if ($gender_id !== null) {
      $sql .= " AND gender_id = ?";
      $params[] = $gender_id;
      $types .= 'i';
    }

    if ($price_min !== null && $price_max !== null) {
      // Lưu ý: Lọc giá dựa trên cột 'price' duy nhất
      $sql .= " AND price >= ? AND price <= ?";
      $params[] = $price_min;
      $params[] = $price_max;
      $types .= 'ii';
    }
    
    $sql .= " ORDER BY id DESC";

    $stmt = $this->conn->prepare($sql);

    if (!empty($params)) {
      $bind_params = array_merge([$types], $params);
      $refs = [];
      foreach($bind_params as $key => $value) {
        $refs[$key] = &$bind_params[$key];
      }
      call_user_func_array([$stmt, 'bind_param'], $refs);
    }
    
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
  
  // Các hàm lọc cũ giờ chỉ gọi hàm tổng quát để tránh trùng lặp code
  public function getProductsByCategory($category_id) {
    $filters = ['category_id' => $category_id];
    return $this->getFilteredProducts($filters);
  }
  
  public function getProductsByCategoryAndGender($category_id, $gender_id) {
    $filters = ['category_id' => $category_id, 'gender_id' => $gender_id];
    return $this->getFilteredProducts($filters);
  }
  
  public function getProductsByGender($gender_id) {
    $filters = ['gender_id' => $gender_id];
    return $this->getFilteredProducts($filters);
  }

  
  // ============== HÀM SỬA LỖI CHO TRANG CHI TIẾT SẢN PHẨM ==============
  
  // Hàm lấy chi tiết một sản phẩm (Đã loại bỏ các cột không tồn tại)
  public function getProductDetails($id) {
    $sql = "SELECT id, name, price, description, 
           img AS image, img_child AS image_child, category_id, gender_id 
        FROM products 
        WHERE id = ?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    // Xử lý thumbnails (sử dụng ảnh chính và ảnh con)
    if ($product) {
      // Giả định ảnh chính và ảnh con là 2 thumbnail
      $product['thumbnails'] = [$product['image'], $product['image_child'], $product['image']];
      
      // Do DB không có sale_price, description_full, chúng ta gán giá trị mặc định để tránh lỗi ở View
      $product['sale_price'] = $product['price']; // Tạm thời dùng giá gốc
      $product['description_full'] = $product['description']; // Dùng description làm full description
    }
    
    return $product;
  }

  // Hàm lấy sản phẩm liên quan (Giữ nguyên)
  public function getRelatedProducts($category_id, $current_product_id) {
    $sql = "SELECT id, name, price, img AS image 
        FROM products 
        WHERE category_id = ? AND id != ?
        ORDER BY id DESC
        LIMIT 4"; // Giới hạn 4 sản phẩm
        
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $category_id, $current_product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    if ($result) {
      while($row = $result->fetch_assoc()) {
        $products[] = $row;
      }
    }
    
    $stmt->close();
    return $products;
  }
  
    // HÀM MỚI ĐÃ THÊM: Lấy số lượng sản phẩm ngẫu nhiên 
    public function getFeaturedProductsRandom($limit = 10) {
        // Sắp xếp theo RAND() để lấy ngẫu nhiên, giới hạn $limit sản phẩm
        // Lấy category_id để xác định thư mục ảnh trong View
        $sql = "SELECT id, name, price, img AS image, category_id
                FROM products 
                ORDER BY RAND() 
                LIMIT ?"; 
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
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
  
  // =================================================================
  

  // Đóng kết nối khi Model không còn được sử dụng
  public function __destruct() {
    if ($this->conn) {
      $this->conn->close();
    }
  }
}
?>