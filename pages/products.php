<link rel="stylesheet" href="assets/css/products.css">
<link rel="stylesheet" href="assets/css/sale.css">

<?php
// === KẾT NỐI DATABASE ===
require_once __DIR__ . '/../config/Database.php';
$pdo = (new Database())->getConnection();

// === LẤY USER_ID VÀ CÁC BỘ LỌC HIỆN TẠI (ĐÃ ĐƯỢC CONTROLLER XỬ LÝ SẴN) ===
$uid = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2;

// Các biến này sẽ được controller truyền vào (bắt buộc phải có)
$current_category_id = $current_category_id ?? null;
$current_gender_id   = $current_gender_id   ?? null;
$current_price_range = $current_price_range ?? null;
$current_color_id    = $current_color_id    ?? null;
$current_size_id     = $current_size_id     ?? null;
?>

<main>
    <div class="sale-bannerfull" style="padding-top: 100px;">
        <img src="assets/images/img-banner/banner-chinh-4.jpg" alt="">
    </div>

    <div class="products-container-1 container-center" style="padding-top: 100px;">
        <div class="pro-section-1">

            <div class="pro-sec1-box1">
                <h2>Danh mục</h2>
                <div class="pro-sec1-box-checkbox">

                    <h3>Giới tính</h3>
                    <?php foreach ($genders as $gender): 
                        $checked = $current_gender_id && in_array($gender['id'], explode(',', $current_gender_id));
                    ?>
                    <div class="pro-sec1-box-check-label" style="cursor: pointer;">
                        <label class="container-prod-checkbox">
                            <input type="checkbox"
                                   id="gender-<?php echo $gender['id']; ?>"
                                   data-filter="gender_id"
                                   value="<?php echo $gender['id']; ?>"
                                   <?php echo $checked ? 'checked' : ''; ?>>
                            <svg viewBox="0 0 64 64" height="2em" width="2em">
                                <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path-prod-checkbox"></path>
                            </svg>
                            <label style="cursor: pointer;" for="gender-<?php echo $gender['id']; ?>"><?php echo $gender['name']; ?></label>
                        </label>
                        </div>
                    <?php endforeach; ?>

                    <hr>

                    <h3>Loại sản phẩm</h3>
                    <?php foreach ($categories as $category): 
                        $checked = $current_category_id && in_array($category['id'], explode(',', $current_category_id));
                    ?>
                    <div class="pro-sec1-box-check-label" style="cursor: pointer;">
                        <label class="container-prod-checkbox">
                            <input type="checkbox"
                                   id="category-<?php echo $category['id']; ?>"
                                   data-filter="category_id"
                                   value="<?php echo $category['id']; ?>"
                                   <?php echo $checked ? 'checked' : ''; ?>>
                            <svg viewBox="0 0 64 64" height="2em" width="2em">
                                <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path-prod-checkbox"></path>
                            </svg>
                            <label for="category-<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
                        </label>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
            </div>

            <div class="pro-sec1-box1">
                <h2>Màu sắc</h2>
                <div class="pro-sec1-box-checkbox">
                    <?php
                    $sql_colors = "SELECT id, name FROM color ORDER BY name";
                    $stmt_colors = $pdo->query($sql_colors);
                    $colors = $stmt_colors->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($colors as $color): 
                        $checked = $current_color_id && in_array($color['id'], explode(',', $current_color_id));
                    ?>
                    <div class="pro-sec1-box-check-label" style="cursor: pointer;">
                        <label class="container-prod-checkbox">
                            <input type="checkbox"
                                   id="color-<?php echo $color['id']; ?>"
                                   data-filter="color_id"
                                   value="<?php echo $color['id']; ?>"
                                   <?php echo $checked ? 'checked' : ''; ?>>
                            <svg viewBox="0 0 64 64" height="2em" width="2em">
                                <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path-prod-checkbox"></path>
                            </svg>
                            <label style="cursor: pointer;" for="color-<?php echo $color['id']; ?>">
                                <?php echo $color['name']; ?>
                            </label>
                        </label>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
            </div>

            <div class="pro-sec1-box1">
                <h2>Giá</h2>
                <div class="pro-sec1-box-checkbox">
                    <?php
                    $price_ranges = [
                        ['label' => 'Dưới 500.000đ',        'value' => '0_500000'],
                        ['label' => '500.000đ - 600.000đ',  'value' => '500000_600000'],
                        ['label' => '600.000đ - 700.000đ',  'value' => '600000_700000'],
                        ['label' => 'Trên 700.000đ',        'value' => '700000_999999999'],
                    ];
                    foreach ($price_ranges as $range):
                        $checked = $current_price_range && in_array($range['value'], explode(',', $current_price_range));
                    ?>
                    <div class="pro-sec1-box-check-label" style="cursor: pointer;">
                        <label class="container-prod-checkbox">
                            <input type="checkbox"
                                   id="price-<?php echo $range['value']; ?>"
                                   data-filter="price_range"
                                   value="<?php echo $range['value']; ?>"
                                   <?php echo $checked ? 'checked' : ''; ?>>
                            <svg viewBox="0 0 64 64" height="2em" width="2em">
                                <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path-prod-checkbox"></path>
                            </svg>
                            <label style="cursor: pointer;" for="price-<?php echo $range['value']; ?>"><?php echo $range['label']; ?></label>
                        </label>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
            </div>

            <div class="pro-sec1-box1">
                <h2>Kích cỡ</h2>
                <div class="pro-sec1-box-checkbox">
                    <?php
                    $sql_sizes = "SELECT id, name FROM size ORDER BY 
                                  CASE name WHEN 'XS' THEN 1 WHEN 'S' THEN 2 WHEN 'M' THEN 3 WHEN 'L' THEN 4 WHEN 'XL' THEN 5 WHEN 'XXL' THEN 6 ELSE 99 END";
                    $stmt_sizes = $pdo->query($sql_sizes);
                    $sizes = $stmt_sizes->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($sizes as $size):
                        $checked = $current_size_id && in_array($size['id'], explode(',', $current_size_id));
                    ?>
                    <div class="pro-sec1-box-check-label" style="cursor: pointer;">
                        <label class="container-prod-checkbox">
                            <input type="checkbox"
                                   id="size-<?php echo $size['id']; ?>"
                                   data-filter="size_id"
                                   value="<?php echo $size['id']; ?>"
                                   <?php echo $checked ? 'checked' : ''; ?>>
                            <svg viewBox="0 0 64 64" height="2em" width="2em">
                                <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path-prod-checkbox"></path>
                            </svg>
                            <label style="cursor: pointer;" for="size-<?php echo $size['id']; ?>"><?php echo $size['name']; ?></label>
                        </label>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
            </div>
        </div>

        <div class="pro-section-2">
            <div class="pro-section-2-box1">
                <p>Có <?php echo isset($products) && is_array($products) ? count($products) : 0; ?> sản phẩm</p>
            </div>

            <div class="pro-section-2-box2">
                <?php if (!empty($products) && is_array($products)): ?>
                    <?php foreach ($products as $product):
                        $productImagePath = 'assets/images/sanpham/';
                    ?>
                    <div class="pro-section-2-boxSP">
                        <a href="?page=products_Details&id=<?php echo $product['id']; ?>">
                            <img src="<?php echo htmlspecialchars($productImagePath . $product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <p class="pro-sec2-boxSP-name"><?php echo htmlspecialchars($product['name']); ?></p>
                        </a>
                        <div class="pro-sec2-boxSP-miniBox">
                            <h3><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</h3>

                            
                            <!-- From Uiverse.io by HuaMinhThien --> 
                                <div title="Like" class="heart-container">
                                <input id="Give-It-An-Id" class="checkbox" type="checkbox" />
                                <div class="svg-container">
                                    <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="svg-outline"
                                    viewBox="0 0 24 24"
                                    >
                                    <path
                                        d="M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Zm-3.585,18.4a2.973,2.973,0,0,1-3.83,0C4.947,16.006,2,11.87,2,8.967a4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,11,8.967a1,1,0,0,0,2,0,4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,22,8.967C22,11.87,19.053,16.006,13.915,20.313Z"
                                    ></path>
                                    </svg>
                                    <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="svg-filled"
                                    viewBox="0 0 24 24"
                                    >
                                    <path
                                        d="M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Z"
                                    ></path>
                                    </svg>
                                    <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    height="100"
                                    width="100"
                                    class="svg-celebrate"
                                    >
                                    <polygon points="10,10 20,20"></polygon>
                                    <polygon points="10,50 20,50"></polygon>
                                    <polygon points="20,80 30,70"></polygon>
                                    <polygon points="90,10 80,20"></polygon>
                                    <polygon points="90,50 80,50"></polygon>
                                    <polygon points="80,80 70,70"></polygon>
                                    </svg>
                                </div>
                                </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Xin lỗi, hiện tại không có sản phẩm nào phù hợp.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="products-container-2">
        <img src="assets/images/img-logo/aura clothes xoa nen 1.png" alt="">
    </div>
</main>

<script>
function updateFilters() {
    const params = new URLSearchParams();

    // Thu thập tất cả checkbox đã check – SỬA ĐÂY ĐỂ PHP NHẬN MẢNG!
    document.querySelectorAll('input[data-filter]:checked').forEach(cb => {
        params.append(cb.dataset.filter + '[]', cb.value); // ← THÊM '[]' ĐỂ PHP TỰ MẢNG HÓA
    });

    // Giữ user_id và page
    const currentParams = new URLSearchParams(window.location.search);
    const userId = currentParams.get('user_id') || '<?php echo $uid; ?>';
    params.append('user_id', userId); // Dùng append để an toàn
    params.append('page', 'products');

    const newUrl = '?' + params.toString();
    history.pushState({}, '', newUrl);

    fetch(newUrl, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        document.querySelector('.pro-section-2-box1 p').innerHTML = 
            doc.querySelector('.pro-section-2-box1 p').innerHTML;

        document.querySelector('.pro-section-2-box2').innerHTML = 
            doc.querySelector('.pro-section-2-box2').innerHTML;

        updateClearLinks();
    });
}



document.addEventListener('change', e => {
    // Chỉ cần lắng nghe sự kiện change từ input checkbox
    if (e.target.matches('input[type="checkbox"][data-filter]')) {
        updateFilters();
    }
});

document.addEventListener('DOMContentLoaded', updateClearLinks);
</script>