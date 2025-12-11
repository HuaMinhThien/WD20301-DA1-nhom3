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

// Ánh xạ ngược từ action (tiếng Anh) sang trạng thái CSDL (tiếng Việt)
$action_to_status = [
    'shipped' => 'Đã giao',
    'cancelled' => 'Đã hủy',
    // Nếu muốn cho phép chuyển lại về Chờ xác nhận (pending)
    'pending' => 'Chờ xác nhận', 
];

// === XỬ LÝ HÀNH ĐỘNG CẬP NHẬT TRẠNG THÁI BẰNG AJAX (POST/GET) ===
$action = $_GET['action'] ?? null;
$bill_id_to_update = $_GET['bill_id'] ?? null;

if ($action && $bill_id_to_update && isset($action_to_status[$action])) {
    // Chỉ xử lý nếu có ID và action hợp lệ
    $new_status = $action_to_status[$action];
    $success = $billModel->adminUpdateStatus($bill_id_to_update, $new_status);

    header('Content-Type: application/json');
    if ($success) {
        // Cập nhật thành công, trả về trạng thái mới
        echo json_encode(['success' => true, 'new_status_text' => $new_status]);
    } else {
        http_response_code(500); // Lỗi máy chủ hoặc cập nhật thất bại
        echo json_encode(['success' => false, 'message' => 'Lỗi: Không thể cập nhật trạng thái đơn hàng. Có thể do ID không tồn tại hoặc trạng thái không hợp lệ.']);
    }
    exit;
}
// === END XỬ LÝ HÀNH ĐỘNG ===


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

// === KIỂM TRA REQUEST AJAX (Lấy nội dung bảng) ===
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
        
        <?php 
        // === Xây dựng Base URL linh hoạt và chính xác ===
        $get_params = $_GET;
        // Loại bỏ tham số 'status' và 'action', 'bill_id' khỏi chuỗi query để xây dựng URL mới
        if (isset($get_params['status'])) {
            unset($get_params['status']);
        }
        if (isset($get_params['action'])) {
            unset($get_params['action']);
        }
        if (isset($get_params['bill_id'])) {
            unset($get_params['bill_id']);
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
    const cardBody = document.querySelector('.card-body');
    const tableBody = cardBody ? cardBody.querySelector('tbody') : null;
    const statusLinks = document.querySelectorAll('.btn-filter');
    const cardHeaderH1 = document.querySelector('header h1');
    const baseH1Text = 'Quản Lý Đơn Hàng'; 

    if (!tableBody || statusLinks.length === 0) {
        return;
    }

    // === 1. Xử lý Lọc bằng AJAX ===
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

            // Hiển thị thông báo đang tải
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
                console.error('Lỗi AJAX Lọc:', error);
                tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: red; padding: 30px;">LỖI: Không thể tải đơn hàng. Vui lòng kiểm tra Console/Network Tab (F12) để xem chi tiết lỗi PHP hoặc lỗi mạng.</td></tr>';
            });
        });
    });
    
    // === 2. Xử lý sự kiện Duyệt/Hủy (AJAX) ===
    tableBody.addEventListener('click', function(e) {
        const target = e.target;
        // Kiểm tra xem nút được click có class 'action-btn' không
        if (target.classList.contains('action-btn')) {
            e.preventDefault();
            
            const billId = target.getAttribute('data-id');
            const action = target.getAttribute('data-action'); // 'shipped' hoặc 'cancelled'
            const actionText = target.textContent.trim(); // "Duyệt" hoặc "Hủy"
            
            if (!confirm(`Bạn có chắc chắn muốn thực hiện hành động "${actionText}" cho đơn hàng #${billId}?`)) {
                return;
            }

            // Lấy Base URL hiện tại (loại bỏ action/bill_id nếu có)
            const currentUrl = window.location.href.split('?')[0];
            const currentQuery = window.location.search.substring(1).split('&').filter(param => 
                !param.startsWith('action=') && !param.startsWith('bill_id=')
            ).join('&');
            
            // Xây dựng URL để gọi logic cập nhật ở phía PHP
            const separator = currentQuery ? '&' : '?';
            const updateUrl = currentUrl + (currentQuery ? '?' + currentQuery : '') + 
                              separator + `action=${action}&bill_id=${billId}`;

            fetch(updateUrl, {
                method: 'GET', 
                headers: {
                    'Accept': 'application/json', // Báo cho server biết mong muốn nhận JSON
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Cố gắng đọc JSON lỗi
                    return response.json().catch(() => {
                        // Nếu không phải JSON, trả về lỗi text
                        return response.text().then(text => ({ success: false, message: `Server returned error (${response.status}): ${text.substring(0, 50)}...` }));
                    }).then(errorData => {
                         throw new Error(`Cập nhật thất bại: ${errorData.message || 'Lỗi không xác định'}`);
                    });
                }
                return response.json(); 
            })
            .then(data => {
                if (data.success) {
                    alert(`Đã cập nhật trạng thái đơn hàng #${billId} thành: ${data.new_status_text}`);
                    
                    // Sau khi cập nhật thành công, reload lại nội dung bảng
                    // Tìm link filter đang active (btn-primary) và click vào nó
                    const currentFilterLink = document.querySelector('.btn-filter.btn-primary');
                    if (currentFilterLink) {
                        currentFilterLink.click();
                    }
                } else {
                    alert(data.message || 'Cập nhật thất bại.');
                }
            })
            .catch(error => {
                console.error('Lỗi AJAX Cập nhật Status:', error);
                alert('LỖI: Không thể cập nhật trạng thái. Vui lòng kiểm tra Console/Network Tab (F12).');
            });
        }
        
        // Xử lý nút Chi tiết (Chỉ là placeholder)
        if (target.classList.contains('detail-btn')) {
            const billId = target.getAttribute('data-id');
            alert(`Chức năng xem chi tiết đơn hàng #${billId} sẽ được triển khai tại đây.`);
        }
    });
});
</script>