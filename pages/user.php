<?php

// Bắt buộc có session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu chưa đăng nhập → đẩy về trang login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

$user_id = $_SESSION['user_id'];

// Kết nối DB
require_once 'config/Database.php';
$database = new Database();
$db = $database->getConnection();

// Lấy thông tin người dùng từ bảng user
$query = "SELECT name, email, phone, dob, gender FROM user WHERE id = :id LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Nếu không tìm thấy user (hiếm xảy ra) → đăng xuất
if (!$user) {
    session_destroy();
    header('Location: index.php?page=login');
    exit;
}

// Xử lý giới tính hiển thị tiếng Việt
$gender_text = ($user['gender'] == 1) ? 'Nam' : 'Nữ';
$gender_value = $user['gender']; // giữ nguyên 0 hoặc 1 để checked radio đúng

// Lấy danh sách địa chỉ
$query_addr = "SELECT * FROM address WHERE user_id = :user_id ORDER BY id DESC";
$stmt_addr = $db->prepare($query_addr);
$stmt_addr->bindParam(':user_id', $user_id);
$stmt_addr->execute();
$addresses = $stmt_addr->fetchAll(PDO::FETCH_ASSOC);

// Xác định tab hiện tại
$active_tab = $_GET['tab'] ?? 'info'; // info | address | history
?>

<link rel="stylesheet" href="assets/css/user.css">

<main class="user-page-main">
    <div class="container-user">
        <h1 class="page-title">TÀI KHOẢN CỦA BẠN</h1>

        <div class="user-content-wrapper">

            <!-- SIDEBAR TRÁI -->
            <div class="user-sidebar-box">
                <div class="sidebar-header">
                    <img src="assets/images/img-logo/logo.jpg" alt="Logo" style="width: 300px; height: 100px;">
                    <p class="user-email"><?= htmlspecialchars($user['email']) ?></p>
                </div>

                <div class="loyalty-points">
                    <p class="points-label">Điểm tích lũy:</p>
                    <p class="points-value">3107 điểm</p>
                </div>

                <nav class="user-menu">
                    <ul class="sidebar-menu">
                        <li class="menu-item <?= $active_tab === 'info' ? 'active' : '' ?>">
                            <a href="?page=user&tab=info">Thông tin cá nhân</a>
                        </li>
                        <li class="menu-item <?= $active_tab === 'address' ? 'active' : '' ?>">
                            <a href="?page=user&tab=address">Địa chỉ</a>
                        </li>
                        <li class="menu-item <?= $active_tab === 'history' ? 'active' : '' ?>">
                            <a href="?page=cart_history>Lịch sử đặt hàng"</a>
                        </li>
                        <li class="menu-item logout">
                            <a href="?page=logout">Đăng xuất</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- NỘI DUNG CHÍNH -->
            <div class="user-main-content-box">

                <!-- TAB: THÔNG TIN CÁ NHÂN -->
                <?php if ($active_tab === 'info'): ?>
                    <h2 class="content-title">THÔNG TIN TÀI KHOẢN</h2>
                    <form class="personal-info-form" method="POST" action="?page=user&tab=info">
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" class="input-field">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" readonly class="input-field readonly">
                        </div>

                        <div class="form-row">
                            <div class="form-group form-half">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" class="input-field">
                            </div>
                            <div class="form-group form-half">
                                <label for="dob">Ngày sinh</label>
                                <input type="date" name="dob" id="dob" value="<?= htmlspecialchars($user['dob'] ?? '') ?>" class="input-field">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Giới tính</label>
                            <div class="gender-options">
                                <label><input type="radio" name="gender" value="1" <?= $user['gender'] == 1 ? 'checked' : '' ?>> Nam</label>
                                <label><input type="radio" name="gender" value="0" <?= $user['gender'] == 0 ? 'checked' : '' ?>> Nữ</label>
                            </div>
                        </div>

                        <button type="submit" name="update_info" class="btn-update">CẬP NHẬT THÔNG TIN</button>
                    </form>

                    <?php
                    // Xử lý cập nhật thông tin (đơn giản)
                    if (isset($_POST['update_info'])) {
                        $name  = trim($_POST['name']);
                        $phone = trim($_POST['phone']);
                        $dob   = $_POST['dob'] ?: null;
                        $gender = $_POST['gender'] == 1 ? 1 : 0;

                        $update = "UPDATE user SET name = :name, phone = :phone, dob = :dob, gender = :gender WHERE id = :id";
                        $stmt_up = $db->prepare($update);
                        $stmt_up->execute([
                            ':name' => $name,
                            ':phone' => $phone,
                            ':dob' => $dob,
                            ':gender' => $gender,
                            ':id' => $user_id
                        ]);

                        echo '<div style="color:green;margin-top:15px;">Cập nhật thông tin thành công!</div>';
                        // Refresh lại trang để hiển thị dữ liệu mới
                        echo '<script>setTimeout(() => location.reload(), 1000);</script>';
                    }
                    ?>

                <!-- TAB: ĐỊA CHỈ -->
                <?php elseif ($active_tab === 'address'): ?>
                    <?php include 'address_tab.php'; // bạn có thể tách riêng nếu muốn, hoặc để nguyên dưới đây ?>
                    <?php include 'pages/address_modal.php'; ?>
                    <div class="address-section">
                        <div class="address-section-header">
                            <h2 class="content-title">ĐỊA CHỈ NHẬN HÀNG</h2>
                            <a href="?page=user&tab=address&action=add" class="btn-add-address">+ Thêm địa chỉ mới</a>
                        </div>

                        <?php if (empty($addresses)): ?>
                            <div class="no-address-box">
                                <p>Chưa có địa chỉ nào. Vui lòng thêm địa chỉ để đặt hàng nhanh hơn!</p>
                            </div>
                        <?php else: ?>
                            <div class="address-list">
                                <?php foreach ($addresses as $addr): ?>
                                    <div class="address-item">
                                        <div class="address-info">
                                            <p class="address-receiver"><strong><?= htmlspecialchars($addr['address']) ?></strong></p>
                                            <p class="address-phone">Điện thoại: <?= htmlspecialchars($addr['phone']) ?></p>
                                        </div>
                                        <div class="address-actions">
                                            <a href="?page=user&tab=address&action=edit&id=<?= $addr['id'] ?>" class="edit-btn">Sửa</a>
                                            <a href="?page=user&tab=address&action=delete&id=<?= $addr['id'] ?>" 
                                               onclick="return confirm('Xóa địa chỉ này?')" 
                                               style="color:red;margin-left:10px;">Xóa</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                <!-- TAB: LỊCH SỬ ĐẶT HÀNG -->
                <?php else: ?>
                    <?php include_once 'pages/cart-history.php'; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>