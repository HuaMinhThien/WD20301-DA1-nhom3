<?php
// File: View/product_list.php
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Sản phẩm</title>
</head>
<body>
    <h1>Danh sách Sản phẩm</h1>
    <?php if (isset($products) && !empty($products)): ?>
        <ul>
            <?php foreach ($products as $product): ?>
                <li>
                    <h2><?php echo htmlspecialchars($product['ten_san_pham']); ?></h2>
                    <p>Giá: <?php echo number_format($product['gia']); ?> VNĐ</p>
                    <p><?php echo htmlspecialchars($product['mo_ta']); ?></p>
                    <hr>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Không có sản phẩm nào để hiển thị.</p>
    <?php endif; ?>
</body>
</html>