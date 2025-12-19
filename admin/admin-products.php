<?php
require_once 'config/Database.php';
$db = new Database();
$conn = $db->getConnection();

// ==================== TÌM KIẾM & BỘ LỌC ====================
$search          = trim($_GET['search'] ?? '');
$category_filter = $_GET['category'] ?? '';
$gender_filter   = $_GET['gender'] ?? '';
$stock_filter    = $_GET['stock'] ?? 'all';

$sql = "
    SELECT p.*, c.name AS category_name, g.name AS gender_name,
           COALESCE((SELECT SUM(pv.quantity) FROM product_variant pv WHERE pv.product_id = p.id), 0) AS total_quantity
    FROM products p
    JOIN category c ON p.category_id = c.id
    JOIN gender g ON p.gender_id = g.id
    WHERE 1=1
    /* HIỂN THỊ TẤT CẢ SẢN PHẨM TRONG ADMIN → ĐÃ BỎ DÒNG NOT LIKE '[ẨN] %' */
";
$params = [];

if ($search !== '') {
    $sql .= " AND p.name LIKE ?";
    $params[] = "%$search%";
}
if ($category_filter !== '' && is_numeric($category_filter)) {
    $sql .= " AND p.category_id = ?";
    $params[] = $category_filter;
}
if ($gender_filter !== '' && is_numeric($gender_filter)) {
    $sql .= " AND p.gender_id = ?";
    $params[] = $gender_filter;
}
if ($stock_filter === 'in_stock') {
    $sql .= " HAVING total_quantity > 0";
} elseif ($stock_filter === 'out_of_stock') {
    $sql .= " HAVING total_quantity = 0";
}

$sql .= " ORDER BY p.id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ==================== DỮ LIỆU CHO FORM ====================
$categories = $conn->query("SELECT * FROM category ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$genders    = $conn->query("SELECT * FROM gender ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$colors     = $conn->query("SELECT * FROM color ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$sizes      = $conn->query("SELECT * FROM size ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

// ==================== CHẾ ĐỘ SỬA ====================
$edit_product = null;
$edit_variants = [];
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $edit_product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Loại bỏ [ẨN] khi vào form sửa
    if (strpos($edit_product['name'], '[ẨN] ') === 0) {
        $edit_product['name'] = substr($edit_product['name'], 6);
    }

    $stmt = $conn->prepare("
        SELECT pv.*, c.name AS color_name, s.name AS size_name
        FROM product_variant pv
        JOIN color c ON pv.color_id = c.id
        JOIN size s ON pv.size_id = s.id
        WHERE pv.product_id = ?
    ");
    $stmt->execute([$id]);
    $edit_variants = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ==================== HÀM REDIRECT SẠCH (không lỗi vòng lặp) ====================
function redirect_clean() {
    $query = $_GET;
    unset($query['hide'], $query['show'], $query['id'], $query['action']);
    $url = "admin-index.php?admin=products";
    if (!empty($query)) $url .= "&" . http_build_query($query);
    header("Location: " . $url);
    exit;
}

// ==================== ẨN SẢN PHẨM ====================
if (isset($_GET['hide']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn->prepare("UPDATE products SET name = CONCAT('[ẨN] ', name) WHERE id = ? AND name NOT LIKE '[ẨN] %'")->execute([$id]);
    redirect_clean();
}

// ==================== HIỆN LẠI SẢN PHẨM ====================
if (isset($_GET['show']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn->prepare("UPDATE products SET name = REPLACE(name, '[ẨN] ', '') WHERE id = ?")->execute([$id]);
    redirect_clean();
}

// ==================== THÊM / SỬA SẢN PHẨM ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action      = $_POST['action'] ?? 'add';
    $name        = trim($_POST['name'] ?? '');
    $price       = (int)($_POST['price'] ?? 0);
    $description = $_POST['description'] ?? '';
    $category_id = (int)($_POST['category_id'] ?? 0);
    $gender_id   = (int)($_POST['gender_id'] ?? 0);

    $name = preg_replace('/^\[ẨN\] \s*/', '', $name);

    $img = $edit_product['img'] ?? '';
    if (!empty($_FILES['img']['name']) && $_FILES['img']['error'] == 0) {
        $img = 'uploads/' . time() . '_' . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], $img);
    }
    $img_child = $edit_product['img_child'] ?? '';
    if (!empty($_FILES['img_child']['name']) && $_FILES['img_child']['error'] == 0) {
        $img_child = 'uploads/' . time() . '_child_' . basename($_FILES['img_child']['name']);
        move_uploaded_file($_FILES['img_child']['tmp_name'], $img_child);
    }

    $colors     = $_POST['colors'] ?? [];
    $sizes      = $_POST['sizes'] ?? [];
    $quantities = $_POST['quantities'] ?? [];

    try {
        $conn->beginTransaction();

        if ($action === 'add') {
            $stmt = $conn->prepare("INSERT INTO products (name, price, img, img_child, description, category_id, gender_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $price, $img, $img_child, $description, $category_id, $gender_id]);
            $product_id = $conn->lastInsertId();
        } else {
            $id = (int)$_POST['id'];
            $stmt = $conn->prepare("UPDATE products SET name=?, price=?, img=?, img_child=?, description=?, category_id=?, gender_id=? WHERE id=?");
            $stmt->execute([$name, $price, $img, $img_child, $description, $category_id, $gender_id, $id]);
            $product_id = $id;
            $conn->prepare("DELETE FROM product_variant WHERE product_id = ?")->execute([$id]);
        }

        foreach ($colors as $i => $color_id) {
            if (!empty($color_id) && !empty($sizes[$i])) {
                $qty = (int)($quantities[$i] ?? 0);
                $stmt = $conn->prepare("INSERT INTO product_variant (product_id, color_id, size_id, quantity, category_id, gender_id) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$product_id, $color_id, $sizes[$i], $qty, $category_id, $gender_id]);
            }
        }

        $conn->commit();
        redirect_clean();
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Lỗi: " . $e->getMessage();
    }
}
?>

<div class="main-content">
    <header>
        <h1>Quản lý sản phẩm</h1><div class="user-wrapper">
            <img src="https://via.placeholder.com/40" alt="Admin">
            <div><h4>Admin</h4><small>Super Admin</small></div>
        </div>
    </header>
    

    <main>
        <div class="recent-grid">

            <!-- DANH SÁCH SẢN PHẨM (HIỂN THỊ TẤT CẢ, KỂ CẢ ĐÃ ẨN) -->
            <div class="card">
                <div class="card-header"><h3>Danh sách sản phẩm</h3></div>

                <!-- Tìm kiếm & lọc -->
                <div class="card-body" style="padding-bottom:0;">
                    <form method="GET" action="admin-index.php">
                        <input type="hidden" name="admin" value="products">
                        <div class="form-group-row" style="flex-wrap:wrap; gap:12px; margin-bottom:15px; align-items:end;">
                            <div class="form-group" style="flex:1; min-width:220px;">
                                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm tên sản phẩm..." style="width:100%;">
                            </div>
                            <div class="form-group">
                                <select name="category">
                                    <option value="">Tất cả danh mục</option>
                                    <?php foreach ($categories as $c): ?>
                                        <option value="<?php echo $c['id']; ?>" <?php echo $category_filter == $c['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="gender">
                                    <option value="">Tất cả giới tính</option>
                                    <?php foreach ($genders as $g): ?>
                                        <option value="<?php echo $g['id']; ?>" <?php echo $gender_filter == $g['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($g['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="stock">
                                    <option value="all" <?php echo $stock_filter === 'all' ? 'selected' : ''; ?>>Tất cả tồn kho</option>
                                    <option value="in_stock" <?php echo $stock_filter === 'in_stock' ? 'selected' : ''; ?>>Còn hàng</option>
                                    <option value="out_of_stock" <?php echo $stock_filter === 'out_of_stock' ? 'selected' : ''; ?>>Hết hàng</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-primary">Tìm kiếm</button>
                                <?php if ($search || $category_filter || $gender_filter || $stock_filter !== 'all'): ?>
                                    <a href="admin-index.php?admin=products" class="btn-secondary" style="margin-left:8px;">Xóa lọc</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body" style="padding-top:0;">
                    <div class="table-container">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <td width="50">#</td>
                                    <td width="80">Hình</td>
                                    <td>Tên sản phẩm</td>
                                    <td width="120">Giá</td>
                                    <td width="100">Tồn kho</td>
                                    <td width="120">Hành động</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $i => $p): 
                                    $is_hidden    = strpos($p['name'], '[ẨN] ') === 0;
                                    $display_name = $is_hidden ? substr($p['name'], 6) : $p['name'];
                                ?>
                                <tr <?php if ($is_hidden) echo 'style="opacity:0.75; background:#fff5f5;"'; ?>>
                                    <td class="product-index"><?php echo $i + 1; ?></td>
                                    <td class="product-image-cell">
                                        <img src="assets/images/sanpham/<?php echo htmlspecialchars($p['img'] ?: 'https://via.placeholder.com/60'); ?>" class="product-img" alt="">
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($display_name); ?>
                                        <?php if ($is_hidden): ?>
                                            <span style="color:#e74c3c; font-weight:600; font-size:0.9em;"> (đã ẩn)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo number_format($p['price']); ?>đ</td>
                                    <td>
                                        <strong <?php echo ($p['total_quantity'] > 0 ? 'style="color:var(--main-color)"' : 'style="color:var(--danger)"'); ?>>
                                            <?php echo $p['total_quantity']; ?>
                                        </strong>
                                    </td>
                                    <td class="action-cell">
                                        <!-- NÚT SỬA ĐÃ ĐƯỢC FIX HOÀN TOÀN -->
                                        <a href="<?php 
                                            $link = $_GET;
                                            unset($link['action'], $link['hide'], $link['show'], $link['id']);
                                            $link['action'] = 'edit';
                                            $link['id'] = $p['id'];
                                            echo 'admin-index.php?' . http_build_query($link);
                                        ?>" class="action-btn edit" title="Sửa">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <?php if (!$is_hidden): ?>
                                            <a href="<?php 
                                                $link = $_GET;
                                                unset($link['action'], $link['hide'], $link['show'], $link['id']);
                                                $link['hide'] = 1;
                                                $link['id'] = $p['id'];
                                                echo 'admin-index.php?' . http_build_query($link);
                                            ?>" class="action-btn hide" title="Ẩn sản phẩm" 
                                               onclick="return confirm('Ẩn sản phẩm này khỏi khách hàng?')">
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php 
                                                $link = $_GET;
                                                unset($link['action'], $link['hide'], $link['show'], $link['id']);
                                                $link['show'] = 1;
                                                $link['id'] = $p['id'];
                                                echo 'admin-index.php?' . http_build_query($link);
                                            ?>" style="color:#27ae60; font-size:1.4rem;" title="Hiện lại sản phẩm">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($products)): ?>
                                <tr><td colspan="6" style="text-align:center; padding:3rem; color:#888;">Không có sản phẩm nào</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- FORM THÊM/SỬA SẢN PHẨM (giữ nguyên như cũ) -->
            <div class="card">
                <div class="card-header">
                    <h3><?php echo $edit_product ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới'; ?></h3>
                </div>
                <div class="card-body">
                    <form class="admin-form" method="POST" enctype="multipart/form-data" id="productForm">
                        <input type="hidden" name="action" value="<?php echo $edit_product ? 'edit' : 'add'; ?>">
                        <?php if ($edit_product): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Tên sản phẩm <span style="color:red;">*</span></label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($edit_product['name'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group-row">
                            <div class="form-group">
                                <label>Giá bán <span style="color:red;">*</span></label>
                                <input type="number" name="price" value="<?php echo $edit_product['price'] ?? ''; ?>" min="1000" required>
                            </div>
                            <div class="form-group">
                                <label>Danh mục <span style="color:red;">*</span></label>
                                <select name="category_id" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($categories as $c): ?>
                                        <option value="<?php echo $c['id']; ?>" <?php echo ($edit_product && $edit_product['category_id'] == $c['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($c['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Giới tính <span style="color:red;">*</span></label>
                            <select name="gender_id" required>
                                <option value="">-- Chọn giới tính --</option>
                                <?php foreach ($genders as $g): ?>
                                    <option value="<?php echo $g['id']; ?>" <?php echo ($edit_product && $edit_product['gender_id'] == $g['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($g['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Hình ảnh chính <span style="color:red;">*</span></label>
                            <input type="file" name="img" accept="image/*" <?php echo !$edit_product ? 'required' : ''; ?>>
                            <?php if ($edit_product && $edit_product['img']): ?>
                                <div style="margin-top:8px;">
                                    <img src="assets/images/sanpham/<?php echo htmlspecialchars($edit_product['img']); ?>" width="100" style="border-radius:6px; border:1px solid #ddd;">
                                    <small style="color:#27ae60; display:block;">Đã có ảnh (có thể thay đổi)</small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Hình ảnh phụ</label>
                            <input type="file" name="img_child" accept="image/*">
                            <?php if ($edit_product && $edit_product['img_child']): ?>
                                <div style="margin-top:8px;">
                                    <img src="assets/images/sanpham/<?php echo htmlspecialchars($edit_product['img_child']); ?>" width="80" style="border-radius:6px;">
                                    <small>Hiện tại</small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Mô tả sản phẩm <span style="color:red;">*</span></label>
                            <textarea name="description" rows="4" required><?php echo htmlspecialchars($edit_product['description'] ?? ''); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Biến thể (Màu + Size + Số lượng) <span style="color:red;">*</span></label>
                            <div id="variants">
                                <?php if ($edit_variants): ?>
                                    <?php foreach ($edit_variants as $v): ?>
                                        <div class="form-group-row variant-row" style="margin-bottom:12px; padding:10px; background:#f9f9f9; border-radius:8px; position:relative; border:1px dashed #ddd;">
                                            <div class="form-group">
                                                <select name="colors[]" required>
                                                    <option value="">Màu</option>
                                                    <?php foreach ($colors as $c): ?>
                                                        <option value="<?php echo $c['id']; ?>" <?php echo $v['color_id'] == $c['id'] ? 'selected' : ''; ?>><?php echo $c['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select name="sizes[]" required>
                                                    <option value="">Size</option>
                                                    <?php foreach ($sizes as $s): ?>
                                                        <option value="<?php echo $s['id']; ?>" <?php echo $v['size_id'] == $s['id'] ? 'selected' : ''; ?>><?php echo $s['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" name="quantities[]" value="<?php echo $v['quantity']; ?>" min="0" required placeholder="SL">
                                            </div>
                                            <button type="button" class="btn-delete-variant" onclick="this.parentElement.remove()" title="Xóa biến thể">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="form-group-row variant-row" style="margin-bottom:12px; padding:10px; background:#f9f9f9; border-radius:8px; position:relative; border:1px dashed #ddd;">
                                        <div class="form-group">
                                            <select name="colors[]" required>
                                                <option value="">Màu</option>
                                                <?php foreach ($colors as $c): ?>
                                                    <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="sizes[]" required>
                                                <option value="">Size</option>
                                                <?php foreach ($sizes as $s): ?>
                                                    <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="quantities[]" min="0" required placeholder="Số lượng">
                                        </div>
                                        <button type="button" class="btn-delete-variant" onclick="this.parentElement.remove()" title="Xóa">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="btn-secondary" onclick="addVariant()" style="margin-top:10px;">+ Thêm biến thể</button>
                        </div>

                        <button type="submit" class="btn-primary" style="margin-top:25px; padding:12px 30px; font-size:16px;">
                            <?php echo $edit_product ? 'Cập nhật sản phẩm' : 'Thêm sản phẩm mới'; ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function addVariant() {
    const container = document.getElementById('variants');
    const row = document.createElement('div');
    row.className = 'form-group-row variant-row';
    row.style.cssText = 'margin-bottom:12px; padding:10px; background:#f9f9f9; border-radius:8px; position:relative; border:1px dashed #ddd;';

    row.innerHTML = `
        <div class="form-group">
            <select name="colors[]" required>
                <option value="">Màu</option>
                <?php foreach ($colors as $c): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <select name="sizes[]" required>
                <option value="">Size</option>
                <?php foreach ($sizes as $s): ?>
                    <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <input type="number" name="quantities[]" min="0" required placeholder="Số lượng">
        </div>
        <button type="button" class="btn-delete-variant" onclick="this.parentElement.remove()" title="Xóa biến thể">
            <i class="fa-solid fa-trash"></i>
        </button>
    `;
    container.appendChild(row);
}

document.getElementById('productForm').addEventListener('submit', function(e) {
    const rows = document.querySelectorAll('#variants .variant-row');
    if (rows.length === 0) {
        e.preventDefault();
        alert('Vui lòng thêm ít nhất 1 biến thể sản phẩm!');
    }
});
</script>

<style>
.btn-delete-variant {
    position: absolute;
    top: 92px;
    right: 12px;
    background: #e74c3c;
    color: white;
    border: none;
    border-radius: 6px;
    width: 32px;
    height: 32px;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-delete-variant:hover { background: #c0392b; }

.action-btn.hide { color: var(--main-color); }
.action-btn.hide:hover { color: var(--danger); }

.table-container { 
    max-height: 65vh; 
    overflow-y: auto; 
    border: 1px solid #e0e0e0; 
    border-top: none; 
    border-radius: 0 0 8px 8px; 
}
.table-container thead { 
    position: sticky; 
    top: 0; 
    background: var(--main-color); 
    z-index: 10; 
}
.table-container thead td { 
    color: #FDFACF !important; 
    font-weight: 600; 
    padding: 1rem !important; 
}
.table-container tbody tr:hover { background-color: #f8f9fa; }
</style>