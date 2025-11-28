<?php
// File: models/UserModel.php

class UserModel {
    private $conn;
    private $table_name = "users"; // Giả định tên bảng người dùng

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
        $query = "SELECT id, name, email, password_hash FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Kiểm tra mật khẩu (Giả định mật khẩu được hash bằng password_hash() khi đăng ký)
            if (password_verify($password, $row['password_hash'])) {
                // Đăng nhập thành công, loại bỏ hash mật khẩu trước khi trả về
                unset($row['password_hash']);
                return $row;
            }
        }

        return false; // Email không tồn tại hoặc mật khẩu sai
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
     * @param array $data Mảng chứa name, email, password_hash, phone_number, dob, gender
     * @return bool
     */
    public function registerUser(array $data): bool {
        // Chú ý: Đảm bảo các cột này tồn tại trong bảng users của bạn
        $query = "INSERT INTO " . $this->table_name . " (name, email, password_hash, phone_number, dob, gender) 
                  VALUES (:name, :email, :password_hash, :phone_number, :dob, :gender)";

        $stmt = $this->conn->prepare($query);

        // Bind dữ liệu
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password_hash', $data['password_hash']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':dob', $data['dob']);
        $stmt->bindParam(':gender', $data['gender']);

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