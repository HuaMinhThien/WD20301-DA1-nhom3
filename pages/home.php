<link rel="stylesheet" href="assets/css/home.css">
<main class="container-center">

<?php 
// GIẢ ĐỊNH: Biến $random_products đã được Controller truyền sang và chứa TẤT CẢ các sản phẩm ngẫu nhiên (>= 20 SP)

// Kiểm tra và đảm bảo rằng $random_products tồn tại, là mảng và có ít nhất 20 sản phẩm
if (!empty($random_products) && is_array($random_products)) {
    
    // Tách 10 sản phẩm đầu tiên cho Section 1
    $section1_products = array_slice($random_products, 0, 10);
    
    // Tách 10 sản phẩm tiếp theo cho Section 2
    // Bắt đầu từ index 10, lấy 10 phần tử
    $section2_products = array_slice($random_products, 10, 10);
    
} else {
    // Nếu không có sản phẩm nào hoặc không phải là mảng
    $section1_products = [];
    $section2_products = [];
}

// Đường dẫn cơ sở cho tất cả ảnh sản phẩm
$imagePath = 'assets/images/sanpham/'; 
?>

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

                <a href="?page=products&category_id=5&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>" class="main-ctn2-btn">Mua ngay</a>

            </div>

        </div>



        <div class="main-ctn2-grid-item main-ctn2-item-man">

            <img src="assets/images/img-banner/banner-con-2.png" alt="Thời trang nam">

            <div class="main-ctn2-content">

                <h3>Thời trang nam</h3>

                <p>XU HƯỚNG MỚI NHẤT<br>MÙA HÈ NÀY</p>

                <a href="?page=products&category_id=1&gender_id=1&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>" class="main-ctn2-btn">Mua ngay</a>

            </div>

        </div>



        <div class="main-ctn2-grid-item main-ctn2-item-woman">

            <img src="assets/images/img-banner/banner-con-3.png" alt="Thời trang nữ">

            <div class="main-ctn2-content">

                <h3>Thời trang nữ</h3>

                <p>BỘ SƯU TẬP HÈ<br>MỚI NHẤT</p>

                <a href="?page=products&category_id=1&gender_id=2&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>" class="main-ctn2-btn">Mua ngay</a>

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
        // SỬ DỤNG $section1_products
        if (!empty($section1_products) && is_array($section1_products)): 
            foreach ($section1_products as $product): // Lặp qua 10 sản phẩm Section 1
                // Đã xóa logic thêm đường dẫn 'ao/' hoặc 'quan/' theo yêu cầu.
                // Đường dẫn ảnh sản phẩm giờ chỉ là $imagePath + $product['image']
                $productImagePath = $imagePath; 
        ?>
        
        <div class="pro-section-2-boxSP" style="width: 100%; height: auto;">
             <a href="?page=products_Details&id=<?php echo htmlspecialchars($product['id']); ?>&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>" class="product-link">
                 <div class="product-image-wrapper">
                    <img src="<?php echo htmlspecialchars($productImagePath . $product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"> 
                    
                     <div class="product-overlay">
                         <span class="overlay-text">XEM CHI TIẾT</span>
                     </div>
                 </div>
                 <p class="pro-sec2-boxSP-name">
                     <?php echo htmlspecialchars($product['name']); ?>
                 </p>
             </a>
            
            <div class="pro-sec2-boxSP-miniBox">
                <p>
                    <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                </p>

                <div class="pro-sec2-boxSP-icon">
                    <img src="assets/images/img-icon/heart.png" alt="Yêu thích">
                    
                    <form action="index.php?page=cart&action=add" method="POST" style="display: inline;">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <input type="hidden" name="quantity" value="1">
                        
                        <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                            <img src="assets/images/img-icon/online-shopping.png" alt="Thêm vào giỏ">
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php 
            endforeach; 
        else: 
        ?>
        <p style="grid-column: 1 / -1; text-align: center;">Xin lỗi, hiện tại không có sản phẩm nào để hiển thị.</p>
        <?php endif; ?>
    </div>
    </section>

    <div class="section-banner-full-mid">
        <img src="assets/images/img-banner/banner-home-sec.png" alt="">
    </div>

    <section class="product-grid-section">
    <h2 class="section-title-highlight">⭐ XU HƯỚNG MỚI (10 SP KHÁC)</h2>
    <div class="pro-section-2-box2" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px;">
        <?php 
        // SỬ DỤNG $section2_products
        if (!empty($section2_products) && is_array($section2_products)): 
            foreach ($section2_products as $product): // Lặp qua 10 sản phẩm Section 2
                // Đã xóa logic thêm đường dẫn 'ao/' hoặc 'quan/' theo yêu cầu.
                // Đường dẫn ảnh sản phẩm giờ chỉ là $imagePath + $product['image']
                $productImagePath = $imagePath; 
        ?>
        
        <div class="pro-section-2-boxSP" style="width: 100%; height: auto;">
             <a href="?page=products_Details&id=<?php echo htmlspecialchars($product['id']); ?>&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>" class="product-link">
                 <div class="product-image-wrapper">
                    <img src="<?php echo htmlspecialchars($productImagePath . $product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"> 
                    
                     <div class="product-overlay">
                         <span class="overlay-text">XEM CHI TIẾT</span>
                     </div>
                 </div>
                 <p class="pro-sec2-boxSP-name">
                     <?php echo htmlspecialchars($product['name']); ?>
                 </p>
             </a>
            
            <div class="pro-sec2-boxSP-miniBox">
                <p>
                    <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                </p>

                <div class="pro-sec2-boxSP-icon">
                    <img src="assets/images/img-icon/heart.png" alt="Yêu thích">
                    
                    <form action="index.php?page=cart&action=add" method="POST" style="display: inline;">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <input type="hidden" name="quantity" value="1">
                        
                        <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                            <img src="assets/images/img-icon/online-shopping.png" alt="Thêm vào giỏ">
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php 
            endforeach; 
        else: 
        ?>
        <p style="grid-column: 1 / -1; text-align: center;">Xin lỗi, hiện tại không có sản phẩm nào để hiển thị.</p>
        <?php endif; ?>
    </div>
    </section>


    <section class="danhmuc-sec-home">
           <h2 class="section-title-highlight">Danh Mục Sản Phẩm</h2>

        <div class="div-cate-home-box">
            <a class="cate-home-img" href="?page=products&category_id=1&gender_id=1&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>">
                <img src="assets/images/img-banner/banner-cate-nam.png" alt="">
            </a>
            <a class="cate-home-img" href="?page=products&category_id=1&gender_id=2&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>">
                <img src="assets/images/img-banner/banner-cate-phukien.png" alt="">
            </a>
            <a class="cate-home-img" href="?page=products&category_id=12&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>">
                <img src="assets/images/img-banner/banner-cate-nu.png" alt="">
            </a>
        </div>


    </section>

    
</main>

<div class="products-container-2">
        <img src="assets/images/img-logo/aura clothes xoa nen 1.png" alt="">
    </div>


<script src="assets/js/banner.js"></script>