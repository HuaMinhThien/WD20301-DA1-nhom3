<link rel="stylesheet" href="assets/css/products.css">
<link rel="stylesheet" href="assets/css/sale.css">
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
                    <?php
                    // Lấy các tham số lọc hiện tại (đã có từ Controller)
                    $current_category_id = $_GET['category_id'] ?? null;
                    $current_gender_id = $_GET['gender_id'] ?? null;
                    $current_price_range = $_GET['price_range'] ?? null; // Tham số mới
                    
                    // Định nghĩa các khoảng giá và giá trị (value) tương ứng
                    // value sẽ là "min_max" (ví dụ: "100000_200000")
                    $price_ranges = [
                        ['min' => 0, 'max' => 200000, 'label' => 'Dưới 200.000đ', 'value' => '0_200000'],
                        ['min' => 200000, 'max' => 300000, 'label' => '200.000đ - 300.000đ', 'value' => '200000_300000'],
                        ['min' => 300000, 'max' => 400000, 'label' => '300.000đ - 400.000đ', 'value' => '300000_400000'],
                        ['min' => 400000, 'max' => 500000, 'label' => '400.000đ - 500.000đ', 'value' => '400000_500000'],
                        ['min' => 500000, 'max' => 600000, 'label' => '500.000đ - 600.000đ', 'value' => '500000_600000'],
                        ['min' => 600000, 'max' => 700000, 'label' => '600.000đ - 700.000đ', 'value' => '600000_700000'],
                        ['min' => 700000, 'max' => 999999999, 'label' => 'Trên 700.000đ', 'value' => '700000_999999999'],
                    ];

                    foreach ($price_ranges as $range) {
                        // URL cơ sở: giữ lại Category và Gender nếu có
                        $base_url_price = "?page=products";
                        if ($current_category_id) {
                            $base_url_price .= "&category_id=" . htmlspecialchars($current_category_id);
                        }
                        if ($current_gender_id) {
                            $base_url_price .= "&gender_id=" . htmlspecialchars($current_gender_id);
                        }
                        
                        // URL đích
                        $price_url = $base_url_price . "&price_range=" . htmlspecialchars($range['value']);
                        $is_checked = ($current_price_range === $range['value']);
                        ?>
                        <div class="pro-sec1-box-check-label">
                            <input 
                                id="price-<?php echo $range['value']; ?>" 
                                style="width: 20px; height: 20px; border-radius: 50%;" 
                                type="radio" 
                                name="price_filter" 
                                value="<?php echo htmlspecialchars($range['value']); ?>"
                                
                                onclick="window.location.href='<?php echo $price_url; ?>'"
                                
                                <?php echo $is_checked ? 'checked' : ''; ?>
                            > 
                            <label for="price-<?php echo $range['value']; ?>"><?php echo $range['label']; ?></label> 
                        </div>
                    <?php } ?>
                    
                    <?php if ($current_price_range): 
                        $base_url_clear = "?page=products";
                        if ($current_category_id) {
                            $base_url_clear .= "&category_id=" . htmlspecialchars($current_category_id);
                        }
                        if ($current_gender_id) {
                            $base_url_clear .= "&gender_id=" . htmlspecialchars($current_gender_id);
                        }
                    ?>
                        <div class="pro-sec1-box-check-label">
                            <a href="<?php echo $base_url_clear; ?>" style="color: red; margin-left: 30px; font-weight: bold; text-decoration: none;">&times; Bỏ lọc giá</a>
                        </div>
                    <?php endif; ?>
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
                
                // Kiểm tra xem $products có tồn tại và là mảng không
                if (!empty($products) && is_array($products)): 
                    // Lặp qua từng sản phẩm trong mảng
                    foreach ($products as $product):
                        // =========================================================
                        // ✨ LOGIC ĐÃ SỬA: TẠO ĐƯỜNG DẪN ẢNH CHÍNH XÁC CHO TỪNG SẢN PHẨM
                        // =========================================================
                        $productImagePath = 'assets/images/'; 
                        $product_cat_id = $product['category_id'] ?? 0;

                        if ($product_cat_id == 1) {
                            $productImagePath .= 'ao/'; 
                        } elseif ($product_cat_id == 2) {
                            $productImagePath .= 'quan/'; 
                        } 
                        // Nếu category_id khác 1 và 2, đường dẫn là 'assets/images/'

                ?>
                
                <div class="pro-section-2-boxSP">
                    
                    <a href="?page=products_Details&id=<?php echo htmlspecialchars($product['id']); ?>">
                        <img src="<?php echo htmlspecialchars($productImagePath . $product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"> 

                        <p class="pro-sec2-boxSP-name">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </p>
                    </a>
                    
                    <div class="pro-sec2-boxSP-miniBox">
                        <p>
                            <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                        </p>

                        <form action="index.php?page=cart&action=add" method="POST" id="add-form-<?php echo $product['id']; ?>" style="display:inline;"> 
                            
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <input type="hidden" name="quantity" value="1"> 
                            
                            <input type="hidden" name="color_id" value="1"> 
                            <input type="hidden" name="size_id" value="1"> 
                            
                            <div class="pro-sec2-boxSP-icon">
                                <img src="assets/images/img-icon/heart.png" alt="Yêu thích">
                                
                                <img 
                                    src="assets/images/img-icon/online-shopping.png" 
                                    alt="Thêm vào giỏ"
                                    style="cursor: pointer;"
                                    onclick="event.preventDefault(); document.getElementById('add-form-<?php echo $product['id']; ?>').submit();"
                                >
                            </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; // Đóng foreach ?>
                <?php else: // Nếu không có sản phẩm ?>
                <p>Xin lỗi, hiện tại không có sản phẩm nào phù hợp.</p>
                <?php endif; // Đóng if kiểm tra $products ?>
            </div>
            
        </div>
    </div>

    <div class="products-container-2">
        <img src="assets/images/img-logo/aura clothes xoa nen 1.png" alt="">
    </div>
</main>