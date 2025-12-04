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
        $query = "INSERT INTO user 
                (name, email, password, phone, dob, gender, login_day, role) 
                VALUES 
                (:name, :email, :password, :phone, :dob, :gender, NOW(), 'user')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']); // plaintext như dữ liệu mẫu
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':dob', $data['dob']);
        $stmt->bindParam(':gender', $data['gender']);

        return $stmt->execute();
   }
    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}