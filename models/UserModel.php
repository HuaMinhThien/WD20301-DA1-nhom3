<?php
// File: models/UserModel.php (Đã sửa để khớp với bảng `user` trong SQL dump và sử dụng password plaintext)

class UserModel {
    private $conn;
    private $table_name = "user"; // Sửa tên bảng từ "users" thành "user" để khớp với SQL dump

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Xác thực người dùng và trả về thông tin người dùng nếu thành công.
     * @param string $email
     * @param string $password (password thô)
     * @return array|false 
     */
    public function loginUser(string $email, string $password) {
    $query = "SELECT id, name, email, password, role FROM user WHERE email = :email LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // So sánh mật khẩu plaintext (vì dữ liệu mẫu lưu plaintext)
        if ($password === $row['password']) {
            unset($row['password']); // Không trả về mật khẩu
            return $row; // Trả về mảng có: id, name, email, role
        }
    }

    return false;
}
    
    // ------------------------------------------------------------------
    // HÀM BỔ SUNG CHO CHỨC NĂNG ĐĂNG KÝ
    // ------------------------------------------------------------------

    /**
     * Kiểm tra xem email đã tồn tại trong DB chưa.
     * @param string $email
     * @return bool
     */
    public function isEmailExist(string $email): bool {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Trả về true nếu COUNT > 0 (tức là email đã tồn tại)
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Lưu thông tin người dùng mới vào DB.
     * @param array $data Mảng chứa name, email, password, phone_number, dob, gender
     * @return bool
     */
    public function registerUser(array $data): bool {
        // Sửa cột từ password_hash thành password, và sử dụng plaintext để khớp với SQL dump
        // Chú ý: Đảm bảo các cột này tồn tại trong bảng user của bạn
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, phone, login_day) 
                  VALUES (:name, :email, :password, :phone, NOW())"; // Sửa: phone thay vì phone_number, và thêm login_day mặc định

        $stmt = $this->conn->prepare($query);

        // Bind dữ liệu (không hash password để khớp với dữ liệu mẫu plaintext)
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']); // Lưu plaintext
        $stmt->bindParam(':phone', $data['phone']); // Sửa: phone thay vì phone_number trong SQL dump

        try {
            // Thực thi và trả về kết quả (true/false)
            return $stmt->execute();
        } catch (PDOException $e) {
            // Xử lý lỗi DB, ví dụ: ghi log
            // error_log("Registration error: " . $e->getMessage()); 
            return false;
        }
    }
}