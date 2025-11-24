<?php

require_once 'database.php'; // Đảm bảo đã import class Database

class ProductModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
    }

    public function getAllProducts() {
        $query = "SELECT id, ten_san_pham, gia, mo_ta FROM san_pham"; // Thay tên cột và bảng phù hợp
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        // Trả về tất cả kết quả dưới dạng mảng liên kết
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}