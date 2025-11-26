<main>
    <div class="sale-bannerfull">
        <img src="assets/images/img-banner/banner-chinh-4.jpg" alt="">
    </div>

    <div class="products-container-1 container-center">
        <div class="pro-section-1">
            
            <div class="pro-sec1-box1">
                <h2>Danh mục</h2>
                <div class="pro-sec1-box-checkbox">
                    
                    <?php 
                    // Lấy category hiện tại để giữ lại trong URL
                    $current_category = $_GET['category'] ?? ''; 
                    // Xây dựng tiền tố URL cơ bản: ?page=products&category=ao
                    $base_url = "?page=products" . (!empty($current_category) ? "&category=" . htmlspecialchars($current_category) : "");
                    ?>
                    
                    <div class="pro-sec1-box-check-label">
                        
                        <input 
                            id="gender-nam" 
                            style="width: 20px; height: 20px; border-radius: 50%;" 
                            type="radio" 
                            name="gender_filter" 
                            value="nam"
                            
                            onclick="window.location.href='<?php echo $base_url; ?>&gender=nam'"
                            
                            <?php echo (isset($_GET['gender']) && $_GET['gender'] === 'nam') ? 'checked' : ''; ?>
                        > 
                        <label for="gender-nam">Nam</label> 
                        
                    </div>
                    
                    <div class="pro-sec1-box-check-label">
                        
                        <input 
                            id="gender-nu" 
                            style="width: 20px; height: 20px; border-radius: 50%;" 
                            type="radio" 
                            name="gender_filter" 
                            value="nu"
                            
                            onclick="window.location.href='<?php echo $base_url; ?>&gender=nu'"
                            
                            <?php echo (isset($_GET['gender']) && $_GET['gender'] === 'nu') ? 'checked' : ''; ?>
                        >
                        <label for="gender-nu">Nữ</label>
                        
                    </div>
                    
                </div>
            </div>

            <div class="pro-sec1-box1">
                <h2>Màu sắc</h2>
                <div class="pro-sec1-box-checkbox">
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="den" type="checkbox"> <label for="">Đen</label> 
                    </div>
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="trang" type="checkbox"> <label for="">Trắng</label>
                    </div> 
                </div>
            </div>

            <div class="pro-sec1-box1">
                <h2>Giá</h2>

                <div class="pro-sec1-box-checkbox">
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="den" type="checkbox"> <label for="">100.000đ - 200.000đ</label> 
                    </div>
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="trang" type="checkbox"> <label for="">200.000đ - 300.000đ</label>
                    </div>
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="den" type="checkbox"> <label for="">300.000đ - 400.000đ</label> 
                    </div>
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="trang" type="checkbox"> <label for="">400.000đ - 500.000đ</label>
                    </div> 
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="den" type="checkbox"> <label for="">500.000đ - 600.000đ</label> 
                    </div>
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="trang" type="checkbox"> <label for="">600.000đ - 700.000đ</label>
                    </div> 
                </div>
            </div>

            <div class="pro-sec1-box1">
                <h2>Kích cỡ</h2>

                <div class="pro-sec1-box-checkbox">
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="S" type="checkbox"> <label for="">S</label> 
                    </div>
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="M" type="checkbox"> <label for="">M</label>
                    </div> 
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="L" type="checkbox"> <label for="">L</label> 
                    </div>
                    <div class="pro-sec1-box-check-label">
                        <input style="width: 20px; height: 20px; border-radius: 50%;" value="XL" type="checkbox"> <label for="">XL</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="pro-section-2">

            <div class="pro-section-2-box1">
                <p>Có 
                    <?php 
                    // Biến $products được truyền từ Controller
                    if (isset($products) && is_array($products)) {
                        echo count($products);
                    } else {
                        echo "0";
                    }
                    ?> sản phẩm
                </p>

                <select name="" id="">
                    <option value="">Mặc định</option>
                    <option value="">Giá: Thấp đến cao</option>
                    <option value="">Giá: Cao đến thấp</option>
                    <option value="">Tên: A đến Z</option>
                    <option value="">Tên: Z đến A</option>
                    <option value="">Hàng mới về</option>
                </select>
            </div>

            <div class="pro-section-2-box2">
                <?php 
                // Khởi tạo $imagePath nếu nó chưa được đặt (để tránh lỗi)
                if (!isset($imagePath)) {
                    $imagePath = 'assets/images/'; 
                }
                
                // Kiểm tra xem $products có tồn tại và là mảng không
                if (!empty($products) && is_array($products)): 
                    // Lặp qua từng sản phẩm trong mảng
                    foreach ($products as $product):
                        // Cấu trúc dữ liệu giả định: $product['id'], $product['name'], $product['price'], $product['image']
                ?>
                
                <a href="?page=products_Details&id=<?php echo htmlspecialchars($product['id']); ?>" class="pro-section-2-boxSP">
                    <img src="<?php echo htmlspecialchars($imagePath . $product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"> 

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
                <p>Xin lỗi, hiện tại không có sản phẩm nào phù hợp.</p>
                <?php endif; ?>
            </div>
            
        </div>
    </div>

    <div class="products-container-2">
        <img src="assets/images/img-logo/aura clothes xoa nen 1.png" alt="">
    </div>
</main>