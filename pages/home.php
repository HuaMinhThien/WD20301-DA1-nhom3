<link rel="stylesheet" href="assets/css/home.css">
<main class="container-center">
    <div class="main-container-banner">
        <div class="slides">
            <div class="slide active" style="background-image: url('assets/images/img-banner/banner-chinh-1.png');"></div>
            <div class="slide" style="background-image: url('assets/images/img-banner/banner-chinh-2.jpg');"></div>
            <div class="slide" style="background-image: url('assets/images/img-banner/banner-chinh-3.jpg');"></div>
            <div class="slide" style="background-image: url('assets/images/img-banner/banner-chinh-4.jpg');"></div>
            <div class="slide" style="background-image: url('assets/images/img-banner/banner-chinh-5.png');"></div>
        </div>

        <div class="prev">&#10094;</div>
        <div class="next">&#10095;</div>

        <div class="dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>

    <div class="main-container-1">
        <div class="main-ctn1">
            <img src="assets/images/img-icon/delivery-truck 2.png" alt="">
            <div class="main-ctn1-box1">
                <h2>MIỄN PHÍ VẬN CHUYỂN</h2>
                <p>Trong bán kính 10km với mọi đơn</p>
            </div>
        </div>
        <div class="main-ctn1">
            <img src="assets/images/img-icon/reload 1.png" alt="">
            <div class="main-ctn1-box1">
                <h2>ĐỔI TRẢ MIỄN PHÍ</h2>
                <p>Đổi trả hàng nhanh trong 15 ngày</p>
            </div>
        </div>
        <div class="main-ctn1">
            <img src="assets/images/img-icon/headphones 1.png" alt="">
            <div class="main-ctn1-box1">
                <h2>HỔ TRỢ MIỄN PHÍ</h2>
                <p>Gọi 0912312312 để được tư vấn</p>
            </div>
        </div>
    </div>

    <div class="main-container-2">
    <div class="main-ctn2-promo-grid-4x3">

            <div class="main-ctn2-grid-item main-ctn2-item-bag">
                <img src="assets/images/img-banner/banner-con-1.png" alt="Túi xách">
                <div class="main-ctn2-content">
                    <h3>Túi xách</h3>
                    <p>MUA 2 SẢN PHẨM GIẢM 50%</p>
                    <a href="#" class="main-ctn2-btn">Mua ngay</a>
                </div>
            </div>

        <div class="main-ctn2-grid-item main-ctn2-item-man">
                <img src="assets/images/img-banner/banner-con-2.png" alt="Thời trang nam">
                <div class="main-ctn2-content">
                    <h3>Thời trang nam</h3>
                    <p>XU HƯỚNG MỚI NHẤT<br>MÙA HÈ NÀY</p>
                    <a href="?page=products&category_id=1&gender_id=1" class="main-ctn2-btn">Mua ngay</a>
                </div>
            </div>

        <div class="main-ctn2-grid-item main-ctn2-item-woman">
                <img src="assets/images/img-banner/banner-con-3.png" alt="Thời trang nữ">
                <div class="main-ctn2-content">
                    <h3>Thời trang nữ</h3>
                    <p>BỘ SƯU TẬP HÈ<br>MỚI NHẤT</p>
                    <a href="?page=products&category_id=1&gender_id=2" class="main-ctn2-btn">Mua ngay</a>
                </div>
            </div>
            <div class="main-ctn2-grid-item main-ctn2-item-kid">
                    <img src="assets/images/img-banner/banner-con-4.png" alt="Cho bé">
                    <div class="main-ctn2-content">
                        <h3>Cho bé</h3>
                        <p>THIẾT KẾ MỚI NHẤT<br>MÙA HÈ 2025</p>
                        <a href="#" class="main-ctn2-btn">Mua ngayy</a>
                    </div>
            </div>

        </div>
    </div>
    
    <section class="product-grid-section">
    <h2 class="section-title-highlight">🔥 SẢN PHẨM NỔI BẬT NGẪU NHIÊN (10 SP)</h2>
    <div class="pro-section-2-box2" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px;">
        <?php 
        // Giả định $random_products được lấy từ Controller (phải chứa 10 sản phẩm ngẫu nhiên)
        // Cần đảm bảo rằng $random_products đã được fetch và có dữ liệu: ['id'], ['name'], ['price'], ['image'], ['category_id']
        // Tái tạo lại logic xác định $imagePath
        $imagePath = 'assets/images/'; 
        
        if (!empty($random_products) && is_array($random_products)): 
            foreach (array_slice($random_products, 0, 10) as $product): // Đảm bảo chỉ lấy tối đa 10 sản phẩm
                // Xác định thư mục ảnh chính xác nếu cần (giữ lại logic cũ)
                $productImagePath = $imagePath;
                if (isset($product['category_id'])) {
                    if ($product['category_id'] == 1) {
                        $productImagePath .= 'ao/'; 
                    } elseif ($product['category_id'] == 2) {
                        $productImagePath .= 'quan/'; 
                    } 
                }
        ?>
        
        <a href="?page=products_Details&id=<?php echo htmlspecialchars($product['id']); ?>" class="pro-section-2-boxSP" style="width: 100%; height: auto;">
            <img src="<?php echo htmlspecialchars($productImagePath . $product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"> 

            <p class="pro-sec2-boxSP-name">
                <?php echo htmlspecialchars($product['name']); ?>
            </p>
            
            <div class="pro-sec2-boxSP-miniBox">
                <p>
                    <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                </p>

                <div class="pro-sec2-boxSP-icon">
                    <img src="assets/images/img-icon/heart.png" alt="Yêu thích">
                    <img src="assets/images/img-icon/online-shopping.png" alt="Thêm vào giỏ">
                </div>
            </div>
        </a>

        <?php 
            endforeach; 
        else: 
        ?>
        <p style="grid-column: 1 / -1; text-align: center;">Xin lỗi, hiện tại không có sản phẩm nào để hiển thị.</p>
        <?php endif; ?>
    </div>
    </section>
    </main>

<script src="assets/js/banner.js"></script>