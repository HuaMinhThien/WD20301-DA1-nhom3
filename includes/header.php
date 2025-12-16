<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/header-footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<?php
$user_id = $_SESSION['user_id'] ?? ($_GET['user_id'] ?? 0);
$user_id = is_numeric($user_id) ? (int)$user_id : 0;

require_once 'config/Database.php';  
require_once 'models/ProductModel.php';  

$show_ao   = false;
$show_quan = false;
$ten_ao    = 'Áo';
$ten_quan  = 'Quần';

try {
    $db = (new Database())->getConnection();
    $stmt = $db->prepare("SELECT id, name FROM category WHERE id IN (1,2)");
    $stmt->execute();
    $cats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // key = id, value = name

    // Kiểm tra Áo (id=1)
    if (isset($cats[1]) && strpos($cats[1], '[ẨN]') !== 0) {
        $show_ao = true;
        $ten_ao  = $cats[1];
    }

    // Kiểm tra Quần (id=2)
    if (isset($cats[2]) && strpos($cats[2], '[ẨN]') !== 0) {
        $show_quan = true;
        $ten_quan  = $cats[2];
    }
} catch (Exception $e) {
    // Nếu lỗi DB → vẫn hiện Áo và Quần (an toàn)
    $show_ao = $show_quan = true;
}


?>

<header>
    <div class="hd-container1-bg">
        <div class="hd-container1-content container-center">
            <a href="?page=home">
                <div class="hd-logo">
                    <img src="assets/images/img-logo/logo.jpg" alt="">
                </div>
            </a>

            <div class="hd-search">
                <input type="text" placeholder="Tìm kiếm sản phẩm...">
                <div class="hd-search-icon">
                    <img src="assets/images/img-icon/search.png" alt="">
                </div>
            </div>
            
            <div class="hd-container-icon">
                <a href="?page=cart_history">
                    <div class="hd-icon"><img src="assets/images/img-icon/clock.png" alt=""></div>
                </a>
                
                <?php if ($user_id != 0): ?>
                    <a href="?page=user">
                        <div class="hd-icon"><img src="assets/images/img-icon/green-user.png" alt=""></div>
                    </a>
                <?php else: ?>
                    <a href="?page=login">
                        <div class="hd-icon"><img src="assets/images/img-icon/user.png" alt=""></div>
                    </a>
                <?php endif; ?>
                
                <a href="?page=cart">
                    <div class="hd-icon"><img src="assets/images/img-icon/grocery-store.png" alt=""></div>
                </a>
            </div>
        </div>
    </div>

    <div class="hd-container2-bg">
        <div class="hd-container2-content container-center">
            <a class="hd-a-cate" href="?page=home">
                <div class="hd-categories"><p>Trang Chủ</p></div>
            </a>
            
            <?php if ($show_ao): ?>
            <div class="hd-a-cate-wrapper">
                <a class="hd-a-cate" href="?page=products&category_id=1">
                    <div class="hd-categories">
                        <p><?= htmlspecialchars($ten_ao) ?></p>
                    </div>
                </a>
            </div>
            <?php endif; ?>

            <?php if ($show_quan): ?>
            <div class="hd-a-cate-wrapper">
                <a class="hd-a-cate" href="?page=products&category_id=2">
                    <div class="hd-categories">
                        <p><?= htmlspecialchars($ten_quan) ?></p>
                    </div>
                </a>
            </div>
            <?php endif; ?>

            <div class="hd-a-cate-wrapper">
                <a class="hd-a-cate" href="?page=products&category_id=0">
                    <div class="hd-categories">
                        <p>Phụ Kiện</p>
                    </div>
                </a>
            </div>
            
            <a class="hd-a-cate" href="?page=sale">
                <div class="hd-categories"><p>Khuyến Mãi</p></div>
            </a>
            <a class="hd-a-cate" href="?page=shop">
                <div class="hd-categories"><p>Cửa Hàng</p></div>
            </a>
        </div>
    </div>
</header>