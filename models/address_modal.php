<link rel="stylesheet" href="assets/css/address-modal.css">
<?php
// pages/address_modal.php
// Đã include sẵn CSS + JS + xử lý đầy đủ Thêm/Sửa/Xóa/Đặt mặc định

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    echo "<script>alert('Vui lòng đăng nhập!'); location.href='?page=login';</script>";
    exit;
}

require_once 'config/Database.php';
$db = (new Database())->getConnection();

// === LẤY DỮ LIỆU ĐỂ SỬA (nếu có) ===
$edit_addr = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $edit_id = (int)$_GET['id'];
    $stmt = $db->prepare("SELECT * FROM address WHERE id = ? AND user_id = ? LIMIT 1");
    $stmt->execute([$edit_id, $user_id]);
    $edit_addr = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>



<!-- MODAL THÊM / SỬA ĐỊA CHỈ -->
<div id="addressModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2><?= $edit_addr ? 'Sửa địa chỉ' : 'Thêm địa chỉ mới' ?></h2>
            <span class="close-btn">×</span>
        </div>

        <form method="POST" class="address-form">
            <input type="hidden" name="address_id" value="<?= $edit_addr['id'] ?? '' ?>">

            <div class="form-row">
                <input type="text" name="full_name" placeholder="Họ và tên" required 
                       value="<?= htmlspecialchars($edit_addr['full_name'] ?? '') ?>">
                <input type="tel" name="phone" placeholder="Số điện thoại" required 
                       value="<?= htmlspecialchars($edit_addr['phone'] ?? '') ?>">
            </div>

            <select name="province" required>
                <option value="">Tỉnh / Thành phố</option>
                <?php
                $provinces = ['TP. Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng'];  // Ví dụ, load thực từ API nếu cần
                foreach ($provinces as $prov) {
                    $selected = ($edit_addr && $edit_addr['province'] == $prov) ? 'selected' : '';
                    echo "<option value='$prov' $selected>$prov</option>";
                }
                ?>
            </select>

            <input type="text" name="address_detail" placeholder="Địa chỉ cụ thể (Số nhà, đường, phường/xã...)" required 
                   value="<?= htmlspecialchars($edit_addr['address'] ?? '') ?>">

            <div class="address-type">
                <label><input type="radio" name="type" value="home" <?= (!isset($edit_addr) || ($edit_addr['type'] ?? 'home') === 'home') ? 'checked' : '' ?>> Nhà riêng</label>
                <label><input type="radio" name="type" value="office" <?= ($edit_addr['type'] ?? '') === 'office' ? 'checked' : '' ?>> Văn phòng</label>
            </div>

            <div class="default-checkbox">
                <label>
                    <input type="checkbox" name="is_default" value="1" <?= ($edit_addr['is_default'] ?? 0) == 1 ? 'checked' : '' ?>>
                    Đặt làm địa chỉ mặc định
                </label>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel">Trở lại</button>
                <button type="submit" name="save_address" class="btn-complete">Hoàn thành</button>
            </div>
        </form>
    </div>
</div>

<!-- CSS riêng (được tách thành file address-modal.css rồi, nhưng vẫn giữ inline làm backup) -->


<!-- JavaScript xử lý mở/đóng modal mượt -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('addressModal');

    // Mở modal nếu có action=add hoặc edit
    <?php if (isset($_GET['action']) && in_array($_GET['action'], ['add', 'edit'])): ?>
        modal.classList.add('show');
    <?php endif; ?>

    // Đóng modal
    function closeModal() {
        modal.classList.remove('show');
        // Xóa URL parameter để tránh mở lại khi reload
        history.replaceState(null, null, '?page=user&tab=address');
    }

    document.querySelectorAll('.close-btn, .btn-cancel').forEach(el => {
        el.onclick = closeModal;
    });

    // Đóng khi click ngoài modal
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });
});
</script>

<?php
// ================== XỬ LÝ LƯU ĐỊA CHỈ (Thêm / Sửa) ==================
if (isset($_POST['save_address'])) {
    $full_name     = trim($_POST['full_name']);
    $phone         = trim($_POST['phone']);
    $province      = trim($_POST['province']);
    $address_detail= trim($_POST['address_detail']);
    $full_address  = $province . ($province && $address_detail ? ', ' : '') . $address_detail;
    $type          = $_POST['type'] ?? 'home';
    $is_default    = isset($_POST['is_default']) ? 1 : 0;

    // Nếu là mặc định → bỏ mặc định tất cả địa chỉ cũ
    if ($is_default) {
        $db->prepare("UPDATE address SET is_default = 0 WHERE user_id = ?")->execute([$user_id]);
    }

    if (!empty($_POST['address_id'])) {
        // CẬP NHẬT
        $id = (int)$_POST['address_id'];
        $sql = "UPDATE address SET full_name=?, phone=?, address=?, type=?, is_default=? WHERE id=? AND user_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$full_name, $phone, $full_address, $type, $is_default, $id, $user_id]);
    } else {
        // THÊM MỚI
        $sql = "INSERT INTO address (user_id, full_name, phone, address, type, is_default) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$user_id, $full_name, $phone, $full_address, $type, $is_default]);
    }

    echo "<script>alert('Lưu địa chỉ thành công!'); location.href='?page=user&tab=address';</script>";
    exit;
}

// ================== XỬ LÝ XÓA ==================
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $db->prepare("DELETE FROM address WHERE id = ? AND user_id = ?")->execute([$id, $user_id]);
    echo "<script>alert('Đã xóa địa chỉ!'); location.href='?page=user&tab=address';</script>";  // Xóa &user_id
    exit;
}

// ================== ĐẶT LÀM MẶC ĐỊNH ==================
if (isset($_GET['set_default'])) {
    $id = (int)$_GET['set_default'];
    $db->prepare("UPDATE address SET is_default = 0 WHERE user_id = ?")->execute([$user_id]);
    $db->prepare("UPDATE address SET is_default = 1 WHERE id = ? AND user_id = ?")->execute([$id, $user_id]);
    echo "<script>location.href='?page=user&tab=address';</script>";  // Xóa &user_id
    exit;
}
?>