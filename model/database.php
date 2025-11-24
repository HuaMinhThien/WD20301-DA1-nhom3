<?php
// File: Model/Database.php

class Database {
    private $host = "localhost";
    private $user = "thien";
    private $pass = ""; // Thay bằng mật khẩu CSDL của bạn
    private $dbname = "ten_csdl_cua_ban"; // Thay bằng tên CSDL
    public $conn;

    public function __construct() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->user, $this->pass);
            // Thiết lập chế độ báo lỗi để dễ debug hơn
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Lỗi kết nối CSDL: " . $exception->getMessage();
        }
    }
}