<link rel="stylesheet" href="assets/css/products.css">
<link rel="stylesheet" href="assets/css/sale.css">

<?php
// === KẾT NỐI DATABASE ===
require_once __DIR__ . '/../config/Database.php';
$pdo = (new Database())->getConnection();

// === LẤY USER_ID VÀ CÁC BỘ LỌC HIỆN TẠI ===
$uid                 = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2;
$current_category_id = $_GET['category_id'] ?? null;
$current_gender_id   = $_GET['gender_id']   ?? null;
$current_price_range = $_GET['price_range'] ?? null;
$current_color_id    = $_GET['color_id']    ?? null;
$current_size_id     = $_GET['size_id']     ?? null;
?>

<main>
    <div class="sale-bannerfull" style="padding-top: 100px;" >
        <img src="assets/images/img-banner/banner-chinh-4.jpg" alt="">
    </div>

    <div class="products-container-1 container-center" style="padding-top: 100px;">
        <div class="pro-section-1">
            
            <div class="pro-sec1-box1" >
                <h2>Danh mục</h2>
                <div class="pro-sec1-box-checkbox">
                    
                    <?php 
                    $base_url_gender = "?page=products&user_id=$uid";
                    if ($current_category_id) {
                        $base_url_gender .= "&category_id=" . htmlspecialchars($current_category_id);
                    }
                    ?>
                    
                    <h3>Giới tính</h3>
                    <?php 
                    if (isset($genders) && is_array($genders)) {
                        foreach ($genders as $gender) {
                            $gender_id = (int)$gender['id'];
                            $gender_name = htmlspecialchars($gender['name']);
                            $gender_url = $base_url_gender . "&gender_id=" . $gender_id;
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
                    $base_url_category = "?page=products&user_id=$uid";
                    if ($current_gender_id) {
                        $base_url_category .= "&gender_id=" . htmlspecialchars($current_gender_id);
                    }
                    
                    if (isset($categories) && is_array($categories)) {
                        foreach ($categories as $category) {
                            $category_id = (int)$category['id'];
                            $category_name = htmlspecialchars($category['name']);
                            $category_url = $base_url_category . "&category_id=" . $category_id;
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

            <!-- ==================== MÀU SẮC ==================== -->
            <div class="pro-sec1-box1">
                <h2>Màu sắc</h2>
                <div class="pro-sec1-box-checkbox">

                    <?php
                    // FIX: Bỏ hex_code vì bảng color không có cột này
                    $sql_colors = "SELECT id, name FROM color ORDER BY name";
                    $stmt_colors = $pdo->query($sql_colors);
                    $colors = $stmt_colors->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($colors as $color) {
                        $color_id   = (int)$color['id'];
                        $color_name = htmlspecialchars($color['name']);

                        $base_url_color = "?page=products&user_id=$uid";
                        if ($current_category_id) $base_url_color .= "&category_id=" . htmlspecialchars($current_category_id);
                        if ($current_gender_id)   $base_url_color .= "&gender_id=" . htmlspecialchars($current_gender_id);
                        if ($current_price_range) $base_url_color .= "&price_range=" . htmlspecialchars($current_price_range);
                        if ($current_size_id)     $base_url_color .= "&size_id=" . $current_size_id;

                        $color_url  = $base_url_color . "&color_id=" . $color_id;
                        $is_checked = ($current_color_id == $color_id);
                        ?>
                        <div class="pro-sec1-box-check-label">
                            <input 
                                id="color-<?php echo $color_id; ?>" 
                                style="width: 20px; height: 20px; border-radius: 50%;" 
                                type="radio" 
                                name="color_filter" 
                                value="<?php echo $color_id; ?>"
                                onclick="window.location.href='<?php echo $color_url; ?>'"
                                <?php echo $is_checked ? 'checked' : ''; ?>
                            > 
                            <label for="color-<?php echo $color_id; ?>">
                                <!-- FIX: Màu mặc định (bạn có thể thay bằng màu tương ứng thủ công sau) -->
                                <span style="display:inline-block;width:15px;height:15px;background:#333;border-radius:50%;vertical-align:middle;margin-right:8px;border:1px solid #ccc;"></span>
                                <?php echo $color_name; ?>
                            </label> 
                        </div>
                        <?php
                    }

                    if ($current_color_id) {
                        $clear_url = "?page=products&user_id=$uid";
                        if ($current_category_id) $clear_url .= "&category_id=" . htmlspecialchars($current_category_id);
                        if ($current_gender_id)   $clear_url .= "&gender_id=" . htmlspecialchars($current_gender_id);
                        if ($current_price_range) $clear_url .= "&price_range=" . htmlspecialchars($current_price_range);
                        if ($current_size_id)     $clear_url .= "&size_id=" . $current_size_id;
                        ?>
                        <div class="pro-sec1-box-check-label">
                            <a href="<?php echo $clear_url; ?>" style="color:red;margin-left:30px;font-weight:bold;text-decoration:none;">× Bỏ chọn màu</a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="pro-sec1-box1">
                <h2>Giá</h2>

                <div class="pro-sec1-box-checkbox">
                    <?php
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
                        $base_url_price = "?page=products&user_id=$uid";
                        if ($current_category_id) {
                            $base_url_price .= "&category_id=" . htmlspecialchars($current_category_id);
                        }
                        if ($current_gender_id) {
                            $base_url_price .= "&gender_id=" . htmlspecialchars($current_gender_id);
                        }
                        
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
                        $base_url_clear = "?page=products&user_id=$uid";
                        if ($current_category_id) {
                            $base_url_clear .= "&category_id=" . htmlspecialchars($current_category_id);
                        }
                        if ($current_gender_id) {
                            $base_url_clear .= "&gender_id=" . htmlspecialchars($current_gender_id);
                        }
                    ?>
                        <div class="pro-sec1-box-check-label">
                            <a href="<?php echo $base_url_clear; ?>" style="color: red; margin-left: 30px; font-weight: bold; text-decoration: none;">× Bỏ lọc giá</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ==================== KÍCH CỠ ==================== -->
            <div class="pro-sec1-box1">
                <h2>Kích cỡ</h2>
                <div class="pro-sec1-box-checkbox">

                    <?php
                    $sql_sizes = "SELECT id, name FROM size ORDER BY 
                                  CASE name 
                                    WHEN 'XS' THEN 1 
                                    WHEN 'S' THEN 2 
                                    WHEN 'M' THEN 3 
                                    WHEN 'L' THEN 4 
                                    WHEN 'XL' THEN 5 
                                    WHEN 'XXL' THEN 6 
                                    ELSE 99 
                                  END";
                    $stmt_sizes = $pdo->query($sql_sizes);
                    $sizes = $stmt_sizes->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($sizes as $size) {
                        $size_id   = (int)$size['id'];
                        $size_name = htmlspecialchars($size['name']);

                        $base_url_size = "?page=products&user_id=$uid";
                        if ($current_category_id) $base_url_size .= "&category_id=" . htmlspecialchars($current_category_id);
                        if ($current_gender_id)   $base_url_size .= "&gender_id=" . htmlspecialchars($current_gender_id);
                        if ($current_price_range) $base_url_size .= "&price_range=" . htmlspecialchars($current_price_range);
                        if ($current_color_id)    $base_url_size .= "&color_id=" . $current_color_id;

                        $size_url   = $base_url_size . "&size_id=" . $size_id;
                        $is_checked = ($current_size_id == $size_id);
                        ?>
                        <div class="pro-sec1-box-check-label">
                            <input 
                                id="size-<?php echo $size_id; ?>" 
                                style="width: 20px; height: 20px; border-radius: 50%;" 
                                type="radio" 
                                name="size_filter" 
                                value="<?php echo $size_id; ?>"
                                onclick="window.location.href='<?php echo $size_url; ?>'"
                                <?php echo $is_checked ? 'checked' : ''; ?>
                            > 
                            <label for="size-<?php echo $size_id; ?>"><?php echo $size_name; ?></label> 
                        </div>
                        <?php
                    }

                    if ($current_size_id) {
                        $clear_size_url = "?page=products&user_id=$uid";
                        if ($current_category_id) $clear_size_url .= "&category_id=" . htmlspecialchars($current_category_id);
                        if ($current_gender_id)   $clear_size_url .= "&gender_id=" . htmlspecialchars($current_gender_id);
                        if ($current_price_range) $clear_size_url .= "&price_range=" . htmlspecialchars($current_price_range);
                        if ($current_color_id)    $clear_size_url .= "&color_id=" . $current_color_id;
                        ?>
                        <div class="pro-sec1-box-check-label">
                            <a href="<?php echo $clear_size_url; ?>" style="color:red; margin-left:30px; font-weight:bold; text-decoration:none;">× Bỏ chọn kích cỡ</a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="pro-section-2">

            <div class="pro-section-2-box1">
                <p>Có 
                    <?php 
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
                
                if (!empty($products) && is_array($products)): 
                    foreach ($products as $product):
                        $productImagePath = 'assets/images/sanpham/'; 
                ?>
                
                <div class="pro-section-2-boxSP">
                    
                    <a href="?page=products_Details&id=<?php echo htmlspecialchars($product['id']); ?>&user_id=<?php echo $uid; ?>">
                        <img src="<?php echo htmlspecialchars($productImagePath . $product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"> 

                        <p class="pro-sec2-boxSP-name">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </p>
                    </a>
                    
                    <div class="pro-sec2-boxSP-miniBox">
                        <p>
                            <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                        </p>

                        <form action="index.php?page=cart&action=add&user_id=<?php echo $uid; ?>" method="POST" id="add-form-<?php echo $product['id']; ?>" style="display:inline;"> 
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <input type="hidden" name="quantity" value="1"> 

                            <?php
                                // Lấy variant đầu tiên còn hàng (dùng cho mọi sản phẩm: áo, quần, phụ kiện)
                                $stmt = $pdo->prepare("
                                    SELECT id 
                                    FROM product_variant 
                                    WHERE product_id = ? 
                                    AND quantity > 0 
                                    LIMIT 1
                                ");
                                $stmt->execute([$product['id']]);
                                $available_variant_id = $stmt->fetchColumn();

                                $can_add_to_cart = ($available_variant_id !== false && $available_variant_id > 0);

                                if ($can_add_to_cart) {
                                    echo '<input type="hidden" name="variant_id" value="' . $available_variant_id . '">';
                                }
                                ?>

                                <!-- Icon giỏ hàng -->
                                <div class="pro-sec2-boxSP-icon">
                                    <img src="assets/images/img-icon/heart.png" alt="Yêu thích">
                                    <img 
                                        src="assets/images/img-icon/online-shopping.png" 
                                        alt="Thêm vào giỏ"
                                        style="cursor: pointer;"
                                        <?php if ($can_add_to_cart): ?>
                                            onclick="event.preventDefault(); document.getElementById('add-form-<?php echo $product['id']; ?>').submit();"
                                        <?php else: ?>
                                            onclick="alert('Sản phẩm tạm hết hàng!'); return false;"
                                            style="opacity:0.5; cursor:not-allowed;"
                                        <?php endif; ?>
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