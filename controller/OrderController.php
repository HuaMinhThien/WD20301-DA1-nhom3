<?php
// Ví dụ OrderController.php (hoặc logic xử lý request)

// 1. Kết nối CSDL
require_once 'config/Database.php';
require_once 'models/BillModel.php'; 

$database = new Database();
$db = $database->getConnection();
$billModel = new BillModel($db);

// 2. Lấy trạng thái lọc từ URL
$filter_status = $_GET['status'] ?? null; 

// Chuyển đổi trạng thái hiển thị (Dùng cho H1 và button)
$status_map = [
    'pending' => 'Chờ xác nhận',
    'shipped' => 'Đã giao',
    'cancelled' => 'Đã hủy',
];
// Nếu không có status trên URL, mặc định là 'Tất cả'
$current_status_text = $status_map[$filter_status] ?? 'Tất cả';

// 3. Lấy dữ liệu hóa đơn
$status_for_model = ($filter_status == 'all' || $filter_status == null) ? null : $filter_status;
// Đảm bảo hàm getAllBills đã được thêm vào BillModel.php
$orders = $billModel->getAllBills($status_for_model);

// 4. Load View
require 'orders.php'; // File này sẽ thấy $orders, $filter_status, $current_status_text
?>