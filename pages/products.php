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
                    // Lấy ID hiện tại từ URL (đã được Controller truyền từ $_GET)
                    $current_category_id = $_GET['category_id'] ?? null; 
                    $current_gender_id = $_GET['gender_id'] ?? null;
                    
                    // --- PHẦN LỌC THEO GIỚI TÍNH (SỬ DỤNG ID) ---
                    
                    // URL cơ bản cho lọc Giới tính (giữ lại category ID nếu có)
                    $base_url_gender = "?page=products";
                    if ($current_category_id) {
                        $base_url_gender .= "&category_id=" . htmlspecialchars($current_category_id);
                    }
                    
                    ?>
                    
                    <h3>Giới tính</h3>
                    <?php 
                    // Lặp qua danh sách $genders được truyền từ Controller
                    if (isset($genders) && is_array($genders)) {
                        foreach ($genders as $gender) {
                            $gender_id = (int)$gender['id'];
                            $gender_name = htmlspecialchars($gender['name']);
                            
                            // URL đích: ?page=products[&category_id=X]&gender_id=Y
                            $gender_url = $base_url_gender . "&gender_id=" . $gender_id;
                            
                            // Kiểm tra trạng thái checked
                            $is_checked = ($current_gender_id == $gender_id);
                            ?>
                            <div class="pro-sec1-box-check-label">
                                <input 
                                    id="gender-<?php echo $gender_id; ?>" 
                                    style="width: 20px; height: 20px; border-radius: 50%;" 
                                    type="radio" 
                                    name="gender_filter" 
                                    value="<?php echo $gender_id; ?>"
                                    
                                    onclick="window.location.href='<?php echo $gender_url; ?>'"
                                    
                                    <?php echo $is_checked ? 'checked' : ''; ?>
                                > 
                                <label for="gender-<?php echo $gender_id; ?>"><?php echo $gender_name; ?></label> 
                            </div>
                            <?php
                        }
                    }
                    ?>
                    
                    <hr>

                    <h3>Loại sản phẩm</h3>
                    <?php 
                    // URL cơ bản cho lọc Category (giữ lại gender ID nếu có)
                    $base_url_category = "?page=products";
                    if ($current_gender_id) {
                        $base_url_category .= "&gender_id=" . htmlspecialchars($current_gender_id);
                    }
                    
                    // Lặp qua danh sách $categories được truyền từ Controller
                    if (isset($categories) && is_array($categories)) {
                        foreach ($categories as $category) {
                            $category_id = (int)$category['id'];
                            $category_name = htmlspecialchars($category['name']);
                            
                            // URL đích: ?page=products[&gender_id=Y]&category_id=X
                            $category_url = $base_url_category . "&category_id=" . $category_id;
                            
                            // Kiểm tra trạng thái checked
                            $is_checked = ($current_category_id == $category_id);
                            
                            ?>
                            <div class="pro-sec1-box-check-label">
                                <input 
                                    id="category-<?php echo $category_id; ?>" 
                                    style="width: 20px; height: 20px; border-radius: 50%;" 
                                    type="radio" 
                                    name="category_filter" 
                                    value="<?php echo $category_id; ?>"
                                    
                                    onclick="window.location.href='<?php echo $category_url; ?>'"
                                    
                                    <?php echo $is_checked ? 'checked' : ''; ?>
                                > 
                                <label for="category-<?php echo $category_id; ?>"><?php echo $category_name; ?></label> 
                            </div>
                            <?php
                        }
                    }
                    ?>
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