<?php
// === LOGIC CONTROLLER (Cần chạy trước khi hiển thị HTML) ===

// 1. Kết nối CSDL và khởi tạo Model
// Sử dụng __DIR__ để xác định đường dẫn tương đối từ thư mục admin/
if (!class_exists('Database')) {
    require_once __DIR__ . '/../config/Database.php'; 
}
if (!class_exists('BillModel')) {
    require_once __DIR__ . '/../models/BillModel.php'; 
}

$database = new Database();
$db = $database->getConnection();
$billModel = new BillModel($db);

// 2. Lấy trạng thái lọc từ URL và khởi tạo biến
$filter_status = $_GET['status'] ?? null; 

$status_map = [
    'pending' => 'Chờ xác nhận',
    'shipped' => 'Đã giao',
    'cancelled' => 'Đã hủy',
];

// Khởi tạo $current_status_text
$current_status_text = $status_map[$filter_status] ?? 'Tất cả';

// 3. Lấy dữ liệu 
$status_for_model = ($filter_status == 'all' || $filter_status == null) ? null : $filter_status;
$orders = $billModel->getAllBills($status_for_model);

// === KIỂM TRA REQUEST AJAX ===
// Nếu request là AJAX, chỉ hiển thị nội dung bảng rồi thoát.
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
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
        <div style="margin-bottom:1rem;">
            <?php 
// ...
// 3. Lấy dữ liệu 
$status_for_model = ($filter_status == 'all' || $filter_status == null) ? null : $filter_status;
$orders = $billModel->getAllBills($status_for_model);

// === Xác định Base URL linh hoạt ===
// Lấy đường dẫn URL hiện tại
$current_url = $_SERVER['REQUEST_URI'];

// Xóa tham số status hiện tại khỏi URL để tạo Base URL
$base_url = preg_replace('/&status=[^&]*/', '', $current_url);
$base_url = preg_replace('/\?status=[^&]*(&|$)/', '?', $base_url);
$base_url = rtrim($base_url, '?'); // Xóa dấu '?' thừa nếu không còn tham số nào

// Đảm bảo URL kết thúc bằng ? hoặc &
if (strpos($base_url, '?') === false) {
    $base_url .= '?'; // Bắt đầu chuỗi tham số
} else {
    $base_url .= '&'; // Thêm tham số tiếp theo
}
$base_url .= 'page=orders'; // Thêm lại tham số page=orders

// Loại bỏ tham số status nếu nó vẫn còn do lỗi logic trước đó
$base_url = preg_replace('/&status=[^&]*/', '', $base_url); 
$base_url = preg_replace('/\?status=[^&]*/', '?', $base_url);
$base_url = rtrim($base_url, '?');

// Bây giờ $base_url chỉ chứa đường dẫn chính (ví dụ: /local/admin/index.php?page=orders)
?>
            <a href="<?php echo $base_url; ?>" class="btn-filter <?php echo (empty($filter_status) || $filter_status == 'all') ? 'btn-primary' : 'btn-secondary'; ?>">Tất cả</a>
            <a href="<?php echo $base_url; ?>&status=pending" class="btn-filter <?php echo ($filter_status == 'pending') ? 'btn-primary' : 'btn-secondary'; ?>">Chờ xác nhận</a>
            <a href="<?php echo $base_url; ?>&status=shipped" class="btn-filter <?php echo ($filter_status == 'shipped') ? 'btn-primary' : 'btn-secondary'; ?>">Đã giao</a>
            <a href="<?php echo $base_url; ?>&status=cancelled" class="btn-filter <?php echo ($filter_status == 'cancelled') ? 'btn-primary' : 'btn-secondary'; ?>">Đã hủy</a>
        </div>
        
        <div class="card">
            <div class="card-header"><h3>Danh Sách Đơn</h3></div>
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
                    // Nếu lỗi HTTP (404, 500), response.text() sẽ lấy nội dung lỗi từ server
                    return response.text().then(text => { 
                        throw new Error(`Server returned HTTP ${response.status}: ${text.substring(0, 100)}...`);
                    });
                }
                return response.text(); 
            })
            .then(htmlContent => {
                // Thay thế nội dung bảng bằng HTML mới
                tableBody.innerHTML = htmlContent;
            })
            .catch(error => {
                console.error('Lỗi AJAX:', error);
                // Hiển thị thông báo lỗi chi tiết hơn (bao gồm lỗi PHP nếu có)
                tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: red; padding: 30px;">LỖI: Không thể tải đơn hàng. Vui lòng kiểm tra Console/Network Tab (F12) để xem chi tiết lỗi PHP hoặc lỗi mạng.</td></tr>';
            });
        });
    });
});
</script>