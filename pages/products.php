<link rel="stylesheet" href="assets/css/products.css">
<link rel="stylesheet" href="assets/css/sale.css">

<?php
// === KẾT NỐI DATABASE ===
require_once __DIR__ . '/../config/Database.php';
$pdo = (new Database())->getConnection();

// === LẤY USER_ID VÀ CÁC BỘ LỌC HIỆN TẠI (ĐÃ ĐƯỢC CONTROLLER XỬ LÝ SẴN) ===
$uid = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 0;

// Các biến này sẽ được controller truyền vào (bắt buộc phải có)
$current_category_id = $current_category_id ?? null;
$current_gender_id   = $current_gender_id   ?? null;
$current_price_range = $current_price_range ?? null;
$current_color_id    = $current_color_id    ?? null;
$current_size_id     = $current_size_id     ?? null;

// Lấy giá trị min/max hiện tại từ URL để hiển thị trên thanh trượt
$current_price_min = $_GET['price_min'] ?? 0; // Giả sử min mặc định là 0
$current_price_max = $_GET['price_max'] ?? 1000000; // Giả sử max mặc định là 1.000.000 (hoặc một mức giá cao nhất)

// Giới hạn giá trị của thanh trượt (Tùy chỉnh theo dữ liệu thực tế của bạn)
$PRICE_RANGE_MIN = 0;
$PRICE_RANGE_MAX = 1000000; // 1.000.000₫ (hoặc cao hơn nếu sản phẩm đắt hơn)

// Cập nhật giá trị hiển thị nếu đã có trong URL
if (isset($_GET['price_min']) && is_numeric($_GET['price_min'])) {
    $current_price_min = (int)$_GET['price_min'];
}
if (isset($_GET['price_max']) && is_numeric($_GET['price_max'])) {
    $current_price_max = (int)$_GET['price_max'];
}

// Đảm bảo giá trị hiển thị không vượt quá giới hạn tổng
$current_price_min = max($PRICE_RANGE_MIN, $current_price_min);
$current_price_max = min($PRICE_RANGE_MAX, $current_price_max);

// Nếu không có giá trị nào từ URL, đặt về mặc định của range
if (!isset($_GET['price_min']) && !isset($_GET['price_max']) && empty($current_price_range)) {
    $current_price_min = $PRICE_RANGE_MIN;
    $current_price_max = $PRICE_RANGE_MAX;
}


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
                <h2>Giá thành</h2>
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
                    <div class="pro-sec1-box-check-label price-range-checkbox" style="cursor: pointer;">
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
                    
                    <div class="price-range-slider-container" style="margin-top: 10px; ">
                        <div class="price-input-display">
                            <label for="min-price-display">Từ:</label>
                            <span id="min-price-display"><?php echo number_format($current_price_min, 0, ',', '.'); ?> ₫</span>
                            <label for="max-price-display">-</label>
                            <span id="max-price-display"><?php echo number_format($current_price_max, 0, ',', '.'); ?> ₫</span>
                        </div>

                        <div class="range-slider" style="cursor: pointer;">
                            <input type="range" 
                                id="min-price-slider" 
                                min="<?php echo $PRICE_RANGE_MIN; ?>" 
                                max="<?php echo $PRICE_RANGE_MAX; ?>" 
                                step="10000" 
                                value="<?php echo $current_price_min; ?>">
                            <input type="range" 
                                id="max-price-slider" 
                                min="<?php echo $PRICE_RANGE_MIN; ?>" 
                                max="<?php echo $PRICE_RANGE_MAX; ?>" 
                                step="10000" 
                                value="<?php echo $current_price_max; ?>">
                        </div>

                        <button id="apply-price-range" class="btn2" style="margin-top: 20px; width: 100%;">
                            <span class="spn2" style="font-size: 16px;">Áp dụng lọc giá</span>
                        </button>
                        
                    </div>
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
            <button id="clear-all-checkboxes" class="btn2" style="margin-top: 10px;">
                <span class="spn2" style="font-size: 16px;">Bỏ chọn tất cả</span>
            </button>
            
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
function formatCurrency(number) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number).replace('₫', '').trim() + ' ₫';
}

function updatePriceDisplay() {
    const minSlider = document.getElementById('min-price-slider');
    const maxSlider = document.getElementById('max-price-slider');
    const minDisplay = document.getElementById('min-price-display');
    const maxDisplay = document.getElementById('max-price-display');

    let minVal = parseInt(minSlider.value);
    let maxVal = parseInt(maxSlider.value);

    // Đảm bảo min không lớn hơn max
    if (minVal > maxVal) {
        // Hoán đổi giá trị nếu người dùng kéo min vượt qua max
        [minVal, maxVal] = [maxVal, minVal];
        minSlider.value = minVal;
        maxSlider.value = maxVal;
    }

    minDisplay.textContent = formatCurrency(minVal);
    maxDisplay.textContent = formatCurrency(maxVal);

    // Cập nhật trạng thái hiển thị của thông báo
    const clearMsg = document.querySelector('.price-range-clear-msg');
    const currentParams = new URLSearchParams(window.location.search);
    const urlMin = currentParams.get('price_min');
    const urlMax = currentParams.get('price_max');
    const defaultMin = parseInt(minSlider.min);
    const defaultMax = parseInt(maxSlider.max);

    // Kiểm tra nếu có giá trị min/max trong URL hoặc thanh trượt đã được thay đổi so với mặc định
    if ((urlMin !== null && parseInt(urlMin) !== defaultMin) || 
        (urlMax !== null && parseInt(urlMax) !== defaultMax) ||
        minVal !== defaultMin || maxVal !== defaultMax) {
        clearMsg.style.display = 'block';
    } else {
        clearMsg.style.display = 'none';
    }
}

function applyPriceRangeFilter() {
    const minSlider = document.getElementById('min-price-slider');
    const maxSlider = document.getElementById('max-price-slider');
    const minVal = parseInt(minSlider.value);
    const maxVal = parseInt(maxSlider.value);
    const defaultMin = parseInt(minSlider.min);
    const defaultMax = parseInt(maxSlider.max);
    
    const params = new URLSearchParams();

    // 1. Thu thập tất cả checkbox (trừ price_range)
    document.querySelectorAll('input[data-filter]:checked').forEach(cb => {
        // Bỏ qua checkbox lọc theo mức giá cố định khi lọc theo thanh trượt
        if (cb.dataset.filter !== 'price_range') {
            params.append(cb.dataset.filter + '[]', cb.value);
        }
    });

    // 2. Thêm giá trị Min/Max mới
    // Chỉ thêm vào URL nếu chúng khác giá trị mặc định của thanh trượt
    if (minVal > defaultMin) {
        params.append('price_min', minVal);
    }
    if (maxVal < defaultMax) {
        params.append('price_max', maxVal);
    }

    // 3. Giữ user_id và page
    const currentParams = new URLSearchParams(window.location.search);
    const userId = currentParams.get('user_id') || '<?php echo $uid; ?>';
    params.append('user_id', userId); 
    params.append('page', 'products');

    const newUrl = '?' + params.toString();
    history.pushState({}, '', newUrl);

    // Gửi yêu cầu lọc
    fetchAndRender(newUrl);
}

function updateFilters() {
    const params = new URLSearchParams();
    const minSlider = document.getElementById('min-price-slider');
    const maxSlider = document.getElementById('max-price-slider');
    const defaultMin = parseInt(minSlider.min);
    const defaultMax = parseInt(maxSlider.max);
    
    // Kiểm tra xem có đang lọc theo Min/Max Range trong URL không
    const isRangeFilterActive = (new URLSearchParams(window.location.search).has('price_min') || new URLSearchParams(window.location.search).has('price_max'));
    
    let rangeFilterAdded = false;

    // 1. Thu thập tất cả checkbox đã check – SỬA ĐÂY ĐỂ PHP NHẬN MẢNG!
    document.querySelectorAll('input[data-filter]:checked').forEach(cb => {
        // Nếu có checkbox mức giá cố định được chọn, thì bỏ qua việc thêm range min/max
        if (cb.dataset.filter === 'price_range') {
            params.append(cb.dataset.filter + '[]', cb.value); 
        } else {
            params.append(cb.dataset.filter + '[]', cb.value);
        }
    });
    
    // 2. Thêm giá trị Min/Max hiện có trong URL vào params nếu không có mức giá cố định nào được chọn
    const currentParams = new URLSearchParams(window.location.search);
    const urlMin = currentParams.get('price_min');
    const urlMax = currentParams.get('price_max');
    
    if (urlMin !== null) {
        params.append('price_min', urlMin);
        rangeFilterAdded = true;
    }
    if (urlMax !== null) {
        params.append('price_max', urlMax);
        rangeFilterAdded = true;
    }


    // 3. Giữ user_id và page
    const userId = currentParams.get('user_id') || '<?php echo $uid; ?>';
    params.append('user_id', userId); 
    params.append('page', 'products');

    const newUrl = '?' + params.toString();
    history.pushState({}, '', newUrl);

    // Gửi yêu cầu lọc
    fetchAndRender(newUrl);
}

function fetchAndRender(url) {
    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // Cập nhật số lượng sản phẩm
        const newProductCount = doc.querySelector('.pro-section-2-box1 p')?.innerHTML || '<p>Có 0 sản phẩm</p>';
        document.querySelector('.pro-section-2-box1 p').innerHTML = newProductCount;

        // Cập nhật danh sách sản phẩm
        const newProductList = doc.querySelector('.pro-section-2-box2')?.innerHTML || '<p>Xin lỗi, hiện tại không có sản phẩm nào phù hợp.</p>';
        document.querySelector('.pro-section-2-box2').innerHTML = newProductList;

        updateClearLinks();
        updatePriceDisplay(); // Gọi lại để hiển thị trạng thái thông báo
    });
}

// THÊM JS ĐỂ XỬ LÝ NÚT BỎ CHỌN TẤT CẢ
document.getElementById('clear-all-checkboxes').addEventListener('click', function() {
    // Bỏ chọn tất cả checkbox có data-filter
    document.querySelectorAll('input[data-filter]').forEach(cb => {
        cb.checked = false;
    });

    // Reset thanh trượt về giá trị mặc định
    const minSlider = document.getElementById('min-price-slider');
    const maxSlider = document.getElementById('max-price-slider');
    minSlider.value = minSlider.min;
    maxSlider.value = maxSlider.max;
    
    // Xóa các tham số price_min, price_max khỏi URL
    const currentParams = new URLSearchParams(window.location.search);
    currentParams.delete('price_min');
    currentParams.delete('price_max');
    
    const newUrl = '?' + currentParams.toString().replace(/price_range%5B%5D/g, 'price_range[]');

    history.pushState({}, '', newUrl);
    
    // Cập nhật lại lọc ngay lập tức
    updateFilters();
});

// Lắng nghe sự kiện change/input từ checkbox
document.addEventListener('change', e => {
    // Chỉ cần lắng nghe sự kiện change từ input checkbox
    if (e.target.matches('input[type="checkbox"][data-filter]')) {
        
        // Nếu người dùng chọn một mức giá cố định, phải xóa lọc Min/Max Range
        if (e.target.dataset.filter === 'price_range' && e.target.checked) {
            const minSlider = document.getElementById('min-price-slider');
            const maxSlider = document.getElementById('max-price-slider');
            
            // Reset thanh trượt về mặc định
            minSlider.value = minSlider.min;
            maxSlider.value = maxSlider.max;
            
            // Xóa giá trị Min/Max trong URL
            const currentParams = new URLSearchParams(window.location.search);
            currentParams.delete('price_min');
            currentParams.delete('price_max');
            
            const newUrl = '?' + currentParams.toString().replace(/price_range%5B%5D/g, 'price_range[]');
            history.pushState({}, '', newUrl);
        }

        updateFilters();
    }
});

// Lắng nghe sự kiện từ thanh trượt
const minSlider = document.getElementById('min-price-slider');
const maxSlider = document.getElementById('max-price-slider');
const applyButton = document.getElementById('apply-price-range');

minSlider.addEventListener('input', updatePriceDisplay);
maxSlider.addEventListener('input', updatePriceDisplay);

applyButton.addEventListener('click', function() {
    // Bỏ chọn tất cả checkbox lọc theo mức giá cố định
    document.querySelectorAll('input[data-filter="price_range"]').forEach(cb => {
        cb.checked = false;
    });
    
    applyPriceRangeFilter();
});

document.addEventListener('DOMContentLoaded', function() {
    // Cập nhật thanh trượt về giá trị trong URL khi load trang
    const currentParams = new URLSearchParams(window.location.search);
    const urlMin = currentParams.get('price_min');
    const urlMax = currentParams.get('price_max');
    
    if (urlMin !== null) {
        minSlider.value = urlMin;
    }
    if (urlMax !== null) {
        maxSlider.value = urlMax;
    }
    
    updatePriceDisplay(); // Khởi tạo hiển thị giá trị và thông báo
    updateClearLinks(); // Đảm bảo hàm này được gọi nếu cần

    // Nếu đang có lọc Min/Max từ URL, bỏ chọn tất cả mức giá cố định
    if (urlMin !== null || urlMax !== null) {
        document.querySelectorAll('input[data-filter="price_range"]').forEach(cb => {
            cb.checked = false;
        });
    }

});

// === CODE MỚI: BẬT TÍNH NĂNG CLICK TRÊN THANH TRƯỢT (TRACK) ===
const rangeSlider = document.querySelector('.range-slider');
if (rangeSlider) {
    rangeSlider.addEventListener('click', (e) => {
        const minSlider = document.getElementById('min-price-slider');
        const maxSlider = document.getElementById('max-price-slider');
        
        // Bỏ qua nếu click vào thumb (vì thumb đã có hành vi kéo)
        if (e.target.matches('input[type="range"]')) {
            return;
        }

        if (!minSlider || !maxSlider) return;

        // 1. Lấy tọa độ nhấp chuột (Offset X)
        const clickX = e.offsetX;
        
        // 2. Lấy chiều rộng của thanh trượt
        const sliderWidth = rangeSlider.offsetWidth;
        
        // 3. Tính phần trăm vị trí nhấp chuột (0 đến 1)
        const clickPercent = clickX / sliderWidth;

        // 4. Lấy giá trị tối thiểu và tối đa (min/max) của thanh trượt
        const minRange = parseFloat(minSlider.min || 0);
        const maxRange = parseFloat(minSlider.max || 5000000); 

        // 5. Tính giá trị tương ứng với vị trí nhấp chuột
        const newValue = Math.round(minRange + (maxRange - minRange) * clickPercent);

        // 6. Quyết định cập nhật Min hay Max slider
        const currentMin = parseFloat(minSlider.value);
        const currentMax = parseFloat(maxSlider.value);
        
        // Khoảng cách từ vị trí click đến Min và Max hiện tại
        const distToMin = Math.abs(newValue - currentMin);
        const distToMax = Math.abs(newValue - currentMax);

        // Cập nhật slider nào gần vị trí click nhất
        if (distToMin < distToMax) {
            minSlider.value = Math.min(newValue, currentMax); // Đảm bảo Min <= Max
        } else {
            maxSlider.value = Math.max(newValue, currentMin); // Đảm bảo Max >= Min
        }

        // Gọi hàm lọc để cập nhật UI và áp dụng bộ lọc
        applyPriceRangeFilter(); 
    });
}

</script>