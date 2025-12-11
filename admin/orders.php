<?php
// === LOGIC CONTROLLER (Cần chạy trước khi hiển thị HTML) ===

// 1. Kết nối CSDL và khởi tạo Model
if (!class_exists('Database')) {
    require_once __DIR__ . '/../config/Database.php'; 
}
if (!class_exists('BillModel')) {
    require_once __DIR__ . '/../models/BillModel.php'; 
}

$database = new Database();
$db = $database->getConnection();
$billModel = new BillModel($db);

// 2. Định nghĩa Ánh xạ Trạng thái
$status_map = [
    'pending' => 'Chờ xác nhận',
    'shipped' => 'Đã giao',
    'cancelled' => 'Đã hủy',
    'all' => 'Tất cả', 
];

// Ánh xạ ngược: Dùng để chuyển trạng thái từ URL (tiếng Anh) thành giá trị trong CSDL (tiếng Việt)
$model_status_map = [
    'pending' => 'Chờ xác nhận',
    'shipped' => 'Đã giao',
    'cancelled' => 'Đã hủy',
];

$filter_status = $_GET['status'] ?? null; 
$current_status_text = $status_map[$filter_status] ?? 'Tất cả';

// 3. Lấy dữ liệu (Điều chỉnh logic ánh xạ)
if ($filter_status == 'all' || $filter_status == null) {
    // Nếu là 'Tất cả' hoặc không có tham số, truyền null để lấy tất cả
    $status_for_model = null;
} else {
    // Ánh xạ trạng thái tiếng Anh (pending) sang tiếng Việt (Chờ xác nhận)
    $status_for_model = $model_status_map[$filter_status] ?? null;
}

$orders = $billModel->getAllBills($status_for_model);

// === KIỂM TRA REQUEST AJAX ===
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Để gỡ lỗi (DEBUG) dễ dàng, ta có thể tạm thời hiển thị biến ở đây trước khi include
    // Ví dụ: echo $status_for_model; exit; // (Tắt khi code chạy chính thức)
    include 'orders_table_content.php'; 
    exit;
}
// === END KIỂM TRA AJAX ===
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
        // === Xây dựng Base URL linh hoạt và chính xác (ĐÃ SỬA LỖI URL) ===
        $get_params = $_GET;
        if (isset($get_params['status'])) {
            unset($get_params['status']);
        }
        if (!isset($get_params['page']) && basename($_SERVER['PHP_SELF']) == 'index.php') {
            $get_params['page'] = 'orders'; 
        }

        $query_string = http_build_query($get_params);
        $path = strtok($_SERVER["REQUEST_URI"], '?');
        $base_url = $path . ($query_string ? '?' . $query_string : '');
        $base_url .= ($query_string ? '&' : '?');
        ?>

        <div class="filter-controls" style="margin-bottom: 1.5rem; display: flex; gap: 10px;">
            <a href="<?php echo $base_url; ?>status=all" class="btn-filter <?php echo ($filter_status == 'all' || $filter_status == null) ? 'btn-primary' : 'btn-secondary'; ?>">Tất cả</a>
            <a href="<?php echo $base_url; ?>status=pending" class="btn-filter <?php echo ($filter_status == 'pending') ? 'btn-primary' : 'btn-secondary'; ?>">Chờ xác nhận</a>
            <a href="<?php echo $base_url; ?>status=shipped" class="btn-filter <?php echo ($filter_status == 'shipped') ? 'btn-primary' : 'btn-secondary'; ?>">Đã giao</a>
            <a href="<?php echo $base_url; ?>status=cancelled" class="btn-filter <?php echo ($filter_status == 'cancelled') ? 'btn-primary' : 'btn-secondary'; ?>">Đã hủy</a>
        </div>
        
        <div class="card">
            <div class="card-header"><h3>Danh Sách Đơn Hàng</h3></div>
            <div class="card-body">
                <table width="100%">
                    <thead>
                        <tr>
                            <td>Mã</td>
                            <td>Khách</td>
                            <td>Ngày</td>
                            <td>Tổng tiền</td>
                            <td>TT</td>
                            <td>Hành động</td>
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
    const tableBody = document.querySelector('.card-body tbody');
    const statusLinks = document.querySelectorAll('.btn-filter');
    const cardHeaderH1 = document.querySelector('header h1');
    const baseH1Text = 'Quản Lý Đơn Hàng'; 

    if (!tableBody || statusLinks.length === 0) {
        return;
    }

    statusLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); 

            const url = this.href;
            
            // Cập nhật class active cho nút
            statusLinks.forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-secondary');
            });
            this.classList.remove('btn-secondary');
            this.classList.add('btn-primary');

            // Cập nhật tiêu đề H1
            let statusText = this.textContent.trim();
            cardHeaderH1.textContent = `${baseH1Text} - ${statusText}`;

            // Hiển thị thông báo đang tải (Tùy chọn)
            tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 30px; color: #007bff;">Đang tải dữ liệu...</td></tr>';


            // Thực hiện AJAX
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' 
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { 
                        throw new Error(`Server returned HTTP ${response.status}: ${text.substring(0, 100)}...`);
                    });
                }
                return response.text(); 
            })
            .then(htmlContent => {
                tableBody.innerHTML = htmlContent;
            })
            .catch(error => {
                console.error('Lỗi AJAX:', error);
                tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: red; padding: 30px;">LỖI: Không thể tải đơn hàng. Vui lòng kiểm tra Console/Network Tab (F12) để xem chi tiết lỗi PHP hoặc lỗi mạng.</td></tr>';
            });
        });
    });
});
</script>