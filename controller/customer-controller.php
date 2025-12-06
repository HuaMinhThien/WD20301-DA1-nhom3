<?php
// File: controllers/UserController.php


require_once '../config/database.php'; 
require_once '../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        // Khởi tạo Model với kết nối DB được truyền vào
        $this->userModel = new UserModel($db);
    }

    public function index() {
        // Gọi hàm mới thêm để lấy dữ liệu
        $users = $this->userModel->getAllUsers();

        // Trả về view (Sửa đường dẫn tới file HTML view của bạn)
        include 'admin/customers.php'; 
    }

    @return array
     */
    public function getAllUsers() {
        // Lấy tất cả user, sắp xếp người mới nhất lên đầu
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>