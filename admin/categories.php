<div class="main-content">
    <header>
        <h1>Quản Lý Danh Mục</h1>
        <div class="user-wrapper">
            <img src="https://via.placeholder.com/40" alt="Admin">
            <div><h4>Admin</h4><small>Super Admin</small></div>
        </div>
    </header>

    <main>
        <div class="recent-grid">
            <!-- BẢNG DANH SÁCH -->
            <div class="card">
                <div class="card-header"><h3>Danh sách danh mục</h3></div>
                <div class="card-body">
                    <table width="100%">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Tên danh mục</td>
                                <td>Số lượng SP</td>
                                <td>Hành động</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            global $conn;
                            if (!isset($conn)) {
                                $conn = mysqli_connect("localhost", "root", "", "duan_1");
                                mysqli_set_charset($conn, "utf8mb4");
                            }

                            $sql = "SELECT c.id, c.name, COUNT(p.id) as sl_sp 
                                    FROM category c 
                                    LEFT JOIN products p ON c.id = p.category_id 
                                    GROUP BY c.id ORDER BY c.id";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $is_hidden = strpos($row['name'], '[ẨN]') === 0;
                                $display_name = $is_hidden ? substr($row['name'], 6) : $row['name'];
                            ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($display_name); ?>
                                        <?php if ($is_hidden): ?>
                                            <span style="color:#e74c3c; font-size:0.9em;"> (đã ẩn)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $row['sl_sp']; ?></td>
                                    <td>
                                        <a href="?admin=categories&edit=<?php echo $row['id']; ?>" class="action-btn edit" title="Sửa">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <?php if (!$is_hidden): ?>
                                            <a href="?admin=categories&hide=<?php echo $row['id']; ?>" 
                                               class="action-btn delete" title="Ẩn danh mục"
                                               onclick="return confirm('Ẩn danh mục này? Sản phẩm sẽ không hiển thị ở frontend.')">
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="?admin=categories&show=<?php echo $row['id']; ?>" 
                                               style="color:#2ecc71; font-size:1.2rem;" title="Hiện lại">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FORM THÊM / SỬA -->
            <div class="card">
                <div class="card-header">
                    <h3><?php echo isset($_GET['edit']) ? 'Sửa danh mục' : 'Thêm danh mục mới'; ?></h3>
                </div>
                <div class="card-body">
                    <?php
                    $edit_id = $edit_name = '';
                    if (isset($_GET['edit'])) {
                        $id = (int)$_GET['edit'];
                        $q = mysqli_query($conn, "SELECT name FROM category WHERE id = $id");
                        if ($r = mysqli_fetch_assoc($q)) {
                            $edit_name = strpos($r['name'], '[ẨN]') === 0 ? substr($r['name'], 6) : $r['name'];
                            $edit_id = $id;
                        }
                    }
                    ?>
                    <form method="POST">
                        <input type="hidden" name="category_id" value="<?php echo $edit_id; ?>">
                        <div class="form-group">
                            <label>Tên danh mục</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($edit_name); ?>" required class="form-control">
                        </div>
                        <button type="submit" name="save_category" class="btn-primary">
                            <?php echo isset($_GET['edit']) ? 'Cập nhật' : 'Thêm mới'; ?>
                        </button>
                        <?php if (isset($_GET['edit'])): ?>
                            <a href="?admin=categories" class="btn-secondary" style="margin-left:10px; padding:0.6rem 1rem; text-decoration:none;">
                                Hủy
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
// XỬ LÝ THÊM - SỬA - ẨN - HIỆN
if (isset($_POST['save_category'])) {
    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    if (!empty($_POST['category_id'])) {
        $id = (int)$_POST['category_id'];
        mysqli_query($conn, "UPDATE category SET name = '$name' WHERE id = $id");
    } else {
        mysqli_query($conn, "INSERT INTO category (name) VALUES ('$name')");
    }
    echo '<script>window.location="?admin=categories"</script>';
    exit;
}

if (isset($_GET['hide'])) {
    $id = (int)$_GET['hide'];
    mysqli_query($conn, "UPDATE category SET name = CONCAT('[ẨN] ', name) WHERE id = $id AND name NOT LIKE '[ẨN] %'");
    echo '<script>window.location="?admin=categories"</script>';
    exit;
}

if (isset($_GET['show'])) {
    $id = (int)$_GET['show'];
    mysqli_query($conn, "UPDATE category SET name = TRIM(REPLACE(name, '[ẨN] ', '')) WHERE id = $id");
    echo '<script>window.location="?admin=categories"</script>';
    exit;
}
?>