<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị - AuraAdmin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin-layout.css">
    
    <style>
        .sidebar .menu li.active a {
            background: #FDFACF !important; /* Màu vàng kem */
            color: #001F3E !important;      /* Màu xanh đậm */
            font-weight: bold;
            border-radius: 30px 0 0 30px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
    <div class="logo">
        <h2><i class="fa-solid fa-shirt"></i> AuraAdmin</h2>
    </div>
    
    <ul class="menu">
        
        <li class="<?php echo ($page == 'products') ? 'active' : ''; ?>">
            <a href="admin-index.php?admin=products"><i class="fa-solid fa-box-open"></i> <span>Sản Phẩm</span></a>
        </li>

        <li class="<?php echo ($page == 'categories') ? 'active' : ''; ?>">
            <a href="admin-index.php?admin=categories"><i class="fa-solid fa-list"></i> <span>Danh Mục</span></a>
        </li>

        <li class="<?php echo ($page == 'orders') ? 'active' : ''; ?>">
            <a href="admin-index.php?admin=orders"><i class="fa-solid fa-cart-shopping"></i> <span>Đơn Hàng</span></a>
        </li>

        <li class="<?php echo ($page == 'customers') ? 'active' : ''; ?>">
            <a href="admin-index.php?admin=customers"><i class="fa-solid fa-users"></i> <span>Người Dùng</span></a>
        </li>

        <li class="logout">
            <a href="index.php?page=home"><i class="fa-solid fa-right-from-bracket"></i> <span>Đăng Xuất</span></a>
        </li>
    </ul>
</div>