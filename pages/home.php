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
        <h2 class="section-title-highlight">🔥 SẢN PHẨM NỔI BẬT KHUYẾN MÃI</h2>
        <div class="product-grid-10-items">
            <?php 
            // $random_products được lấy từ HomeController::home()
            if (isset($random_products) && !empty($random_products)):
                foreach ($random_products as $product):
                    // Xác định thư mục ảnh dựa trên category_id
                    $imageFolder = 'assets/images/';
                    if ($product['category_id'] == 1) {
                        $imageFolder .= 'ao/'; 
                    } elseif ($product['category_id'] == 2) {
                        $imageFolder .= 'quan/'; 
                    } 
                    
                    $original_price = number_format($product['price'], 0, ',', '.');
                    // Giả định giảm giá 10% (Tùy chỉnh nếu có cột giảm giá trong DB)
                    $sale_price = number_format($product['price'] * 0.9, 0, ',', '.'); 
            ?>
            <div class="product-item">
                <a href="?page=products_Details&id=<?= $product['id'] ?>" class="product-link">
                    <img src="<?= $imageFolder . $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-img">
                    <div class="product-details">
                        <p class="product-name-short"><?= $product['name'] ?></p>
                        <div class="product-price-box">
                            <span class="product-sale-price"><?= $sale_price ?>đ</span>
                            <span class="product-original-price"><?= $original_price ?>đ</span>
                        </div>
                    </div>
                </a>
                <div class="product-action-icons">
                    <a href="?page=products_Details&id=<?= $product['id'] ?>" class="icon-link"><img src="assets/images/img-icon/eye.png" alt="Chi tiết"></a>
                    <a href="#" class="icon-link add-to-cart"><img src="assets/images/img-icon/shopping-cart.png" alt="Thêm giỏ hàng"></a>
                </div>
            </div>
            <?php 
                endforeach;
            else:
            ?>
            <p>Không có sản phẩm nào để hiển thị.</p>
            <?php
            endif;
            ?>
        </div>
    </section>
    </main>

<script src="assets/js/banner.js"></script>