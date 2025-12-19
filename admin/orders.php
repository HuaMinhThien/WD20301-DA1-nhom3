<?php
// === 1. LOGIC CONTROLLER ===
if (!class_exists('Database')) { require_once __DIR__ . '/../config/Database.php'; }
if (!class_exists('BillModel')) { require_once __DIR__ . '/../models/BillModel.php'; }

$database = new Database();
$db = $database->getConnection();
$billModel = new BillModel($db);

// Cấu hình trạng thái
$status_map = [
    'pending' => 'Chờ xác nhận', 
    'confirmed' => 'Đã xác nhận',
    'shipped' => 'Đã giao', 
    'cancelled' => 'Đã hủy', 
    'all' => 'Tất cả'
];
$model_status_map = [
    'pending' => 'Chờ xác nhận', 
    'confirmed' => 'Đã xác nhận',
    'shipped' => 'Đã giao', 
    'cancelled' => 'Đã hủy'
];
$action_to_status = [
    'confirmed' => 'Đã xác nhận',
    'shipped' => 'Đã giao', 
    'cancelled' => 'Đã hủy', 
    'pending' => 'Chờ xác nhận'
];

// Lấy tham số từ URL
$action = $_GET['action'] ?? null;
$bill_id_to_update = $_GET['bill_id'] ?? null;
$filter_status = $_GET['status'] ?? null; 
$filter_payment = $_GET['payment'] ?? null; // Thêm lọc thanh toán

// === XỬ LÝ CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG ===
if ($action && $bill_id_to_update && isset($action_to_status[$action])) {
    $success = $billModel->adminUpdateStatus($bill_id_to_update, $action_to_status[$action]);
    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
    exit;
}

// === XỬ LÝ XÁC NHẬN THANH TOÁN ===
$payment_action = $_GET['payment_action'] ?? null;
if ($payment_action === 'paid' && $bill_id_to_update) {
    $success = $billModel->adminUpdatePaymentStatus($bill_id_to_update, 'Đã thanh toán');
    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
    exit;
}

// Lấy dữ liệu hiển thị
$current_status_text = $status_map[$filter_status] ?? 'Tất cả';
$status_for_model = ($filter_status == 'all' || $filter_status == null) ? null : ($model_status_map[$filter_status] ?? null);
$payment_for_model = ($filter_payment == 'all' || $filter_payment == null) ? null : $filter_payment;

// Gọi hàm getAllBills với cả hai tham số lọc
$orders = $billModel->getAllBills($status_for_model, $payment_for_model);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    include 'orders_table_content.php'; 
    exit;
}
?>

<div class="main-content">
    <header>
        <h1>Quản Lý Đơn Hàng - <?php echo htmlspecialchars($current_status_text); ?></h1>
        <div class="user-wrapper">
            <img src="https://via.placeholder.com/40" alt="Admin">
            <div><h4>Admin</h4><small>Super Admin</small></div>
        </div>
    </header>

    <main>
        <?php 
        $get_params = $_GET;
        unset($get_params['action'], $get_params['bill_id'], $get_params['payment_action']);
        $query_string = http_build_query($get_params);
        $base_url = strtok($_SERVER["REQUEST_URI"], '?') . ($query_string ? '?' . $query_string : '');
        $base_url .= (strpos($base_url, '?') !== false ? '&' : '?');
        ?>

<div class="filter-controls order-filter-container" style="margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 10px;">
    <div class="order-filter-group">
        <strong>Trạng thái đơn:</strong>
        <a href="<?php echo $base_url; ?>status=all&payment=<?php echo $filter_payment ?? 'all'; ?>" class="order-filter-btn <?php echo ($filter_status == 'all' || $filter_status == null) ? 'order-filter-active' : 'order-filter-inactive'; ?>">Tất cả</a>
        <a href="<?php echo $base_url; ?>status=pending&payment=<?php echo $filter_payment ?? 'all'; ?>" class="order-filter-btn <?php echo ($filter_status == 'pending') ? 'order-filter-active' : 'order-filter-inactive'; ?>">Chờ xác nhận</a>
        <a href="<?php echo $base_url; ?>status=confirmed&payment=<?php echo $filter_payment ?? 'all'; ?>" class="order-filter-btn <?php echo ($filter_status == 'confirmed') ? 'order-filter-active' : 'order-filter-inactive'; ?>">Đã xác nhận</a>
        <a href="<?php echo $base_url; ?>status=shipped&payment=<?php echo $filter_payment ?? 'all'; ?>" class="order-filter-btn <?php echo ($filter_status == 'shipped') ? 'order-filter-active' : 'order-filter-inactive'; ?>">Đã giao</a>
        <a href="<?php echo $base_url; ?>status=cancelled&payment=<?php echo $filter_payment ?? 'all'; ?>" class="order-filter-btn <?php echo ($filter_status == 'cancelled') ? 'order-filter-active' : 'order-filter-inactive'; ?>">Đã hủy</a>
    </div>
    
    <div class="order-filter-group">
        <strong>Thanh toán:</strong>
        <a href="<?php echo $base_url; ?>status=<?php echo $filter_status ?? 'all'; ?>&payment=all" class="order-filter-btn <?php echo ($filter_payment == 'all' || $filter_payment == null) ? 'order-filter-active' : 'order-filter-inactive'; ?>">Tất cả</a>
        <a href="<?php echo $base_url; ?>status=<?php echo $filter_status ?? 'all'; ?>&payment=Chờ thanh toán" class="order-filter-btn <?php echo ($filter_payment == 'Chờ thanh toán') ? 'order-filter-active' : 'order-filter-inactive'; ?>">Chờ thanh toán</a>
        <a href="<?php echo $base_url; ?>status=<?php echo $filter_status ?? 'all'; ?>&payment=Đã thanh toán" class="order-filter-btn <?php echo ($filter_payment == 'Đã thanh toán') ? 'order-filter-active' : 'order-filter-inactive'; ?>">Đã thanh toán</a>
    </div>
</div>

<div class="card">
    <div class="card-header order-card-header"><h3>Danh Sách Đơn Hàng</h3></div>
    <div class="card-body order-card-body">
        <table width="100%" class="order-table">
            <thead>
                <tr>
                    <td>Mã</td>
                    <td>Khách</td>
                    <td>Ngày</td>
                    <td>Tổng tiền</td>
                    <td>Trạng thái ĐH</td>
                    <td>Thanh toán</td>
                    <td>Hành động</td>
                    <td>Xác nhận tiền</td>
                </tr>
            </thead>
            <tbody>
                <?php include 'orders_table_content.php'; ?>
            </tbody>
        </table>
    </div>
</div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('tbody');

    if (tableBody) {
        tableBody.addEventListener('click', function(e) {
            // Nhận diện cả nút hành động đơn hàng và nút thanh toán
            const target = e.target.closest('.order-action-btn, .order-payment-btn');
            if (!target) return;

            e.preventDefault();
            const billId = target.getAttribute('data-id');
            const action = target.getAttribute('data-action');
            const paymentAction = target.getAttribute('data-payment');
            
            // Cập nhật thông báo xác nhận
            const confirmMsg = paymentAction ? 
                "Xác nhận đã thu tiền cho đơn hàng này?" : 
                "Bạn có chắc chắn muốn thực hiện hành động này?";

            if (confirm(confirmMsg)) {
                const url = new URL(window.location.href);
                url.searchParams.set('bill_id', billId);
                
                if (paymentAction) {
                    url.searchParams.set('payment_action', paymentAction);
                } else if (action) {
                    url.searchParams.set('action', action);
                }

                fetch(url.href, { headers: { 'Accept': 'application/json' } })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload(); // Tải lại trang sau khi cập nhật thành công
                    } else {
                        alert('Cập nhật thất bại. Vui lòng kiểm tra lại Database!');
                    }
                })
                .catch(err => {
                    console.error(err);
                    window.location.reload();
                });
            }
        });
    }
});
</script>