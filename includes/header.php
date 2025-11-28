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
                    <a href="?page=cart_history"> <div class="hd-icon"><img src="assets/images/img-icon/clock.png" alt=""></div></a>
                    <a href="?page=login"> <div class="hd-icon"><img src="assets/images/img-icon/user.png" alt=""></div></a>
                    <a href="?page=cart"> <div class="hd-icon"><img src="assets/images/img-icon/grocery-store.png" alt=""></div></a>
                </div>
            </div>
            
        </div>
        <div class="hd-container2-bg">
            <div class="hd-container2-content container-center">
                <a class="hd-a-cate" href="?page=home">
                    <div class="hd-categories">
                        <p>Trang Chủ</p>
                    </div>
                </a>
                
                <!-- Áo với menu con -->
                <div class="hd-a-cate-wrapper">
                    <a class="hd-a-cate" href="?page=products&category_id=1">
                        <div class="hd-categories">
                            <p>Áo</p>
                            <img style="height: 10px; width: 10px; margin-top: 5px;" src="assets/images/img-icon/down-arrow.png" alt="">
                        </div>
                    </a>
                    
                </div>

                <!-- Quần với menu con -->
                <div class="hd-a-cate-wrapper">
                    <a class="hd-a-cate" href="?page=products&category_id=2">
                        <div class="hd-categories">
                            <p>Quần</p>
                            <img style="height: 10px; width: 10px; margin-top: 5px;" src="assets/images/img-icon/down-arrow.png" alt="">
                        </div>
                    </a>
                    
                </div>

                <!-- Phụ Kiện với menu con -->
                <div class="hd-a-cate-wrapper">
                    <a class="hd-a-cate" href="?page=products&category_id=12">
                        <div class="hd-categories">
                            <p>Phụ Kiện</p>
                            <img style="height: 10px; width: 10px; margin-top: 5px;" src="assets/images/img-icon/down-arrow.png" alt="">
                        </div>
                    </a>
                    
                </div>
                
                <a class="hd-a-cate" href="?page=sale">
                    <div class="hd-categories">
                        <p>Khuyến Mãi</p>
                    </div>
                </a>
                <a class="hd-a-cate" href="?page=shop">
                    <div class="hd-categories">
                        <p>Cửa Hàng</p>
                    </div>
                </a>
            </div>
        </div>
    </header>
