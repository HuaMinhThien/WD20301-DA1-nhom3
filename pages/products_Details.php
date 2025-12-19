<link rel="stylesheet" href="assets/css/chitietSP.css">



<?php
if (empty($product)) {
    echo "<div style='text-align: center; padding: 50px;'>Không tìm thấy sản phẩm.</div>";
    return; 
}

$product_image       = $product['image'] ?? 'default-main.jpg';
$product_image_child = $product['image_child'] ?? 'default-child.jpg'; 
$full_description    = $product['description_full'] ?? $product['description'] ?? 'Chưa có mô tả chi tiết.';
?>

<div class="product-detail-container">

    <?php
    $success_message = $_SESSION['success_message'] ?? null;
    $error_message   = $_SESSION['error_message'] ?? null;
    unset($_SESSION['success_message'], $_SESSION['error_message']);
    ?>

    <?php if ($success_message): ?>
        <div class="alert alert-success" style="padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin: 20px 0;">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div class="alert alert-error" style="padding: 15px; background: #f8d7da; color: #721c24; border-radius: 5px; margin: 20px 0;">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>
    
    <div class="product-detail-main-content">
        
        <div class="product-thumbnails">
            <?php 
            foreach ($product['thumbnails'] as $thumb): 
            ?>
                <div class="thumb-item">
                    <img class="thumb-image" 
                         src="<?php echo htmlspecialchars($imagePath . $thumb); ?>" 
                         alt="Thumbnail" 
                         onclick="changeMainImage('<?php echo htmlspecialchars($imagePath . $thumb); ?>')">
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="product-main-image">
            <img id="main-product-image" src="<?php echo htmlspecialchars($imagePath . $product_image); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        
        <div class="product-info-panel">
            
            <p class="sale-SP" > MIỄN PHÍ VẬN CHUYỂN ĐƠN HÀNG TỪ 500K</p>

            <h1 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h1>
            
            <p style="font-size: 14px;">SKU: WS25FH63P-LC</p>

            <div class="price-section">
                <?php 
                    $display_price = $product['price'] ?? 0;
                ?>
                
                    <span class="current-price"><?php echo number_format($display_price, 0, ',', '.'); ?>₫</span>
            </div>
            
            <form id="add-to-cart-form" action="index.php?page=cart&action=add" method="POST">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                
                <!-- Các select màu, size, số lượng ... giữ nguyên -->
                <div class="product-selection-group">
                    <label for="color-select">Màu sắc:</label>
                    <select name="color_id" id="color-select" required onchange="updateSizes()">
                        <option value="" disabled selected>Chọn màu sắc</option>
                        <?php 
                        if (!empty($available_colors) && is_array($available_colors)) {
                            foreach ($available_colors as $color_id => $color_name) {
                                echo '<option value="'.$color_id.'">'.htmlspecialchars($color_name).'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="product-selection-group">
                    <label for="size-select">Kích thước:</label>
                    <select name="size_id" id="size-select" required>
                        <option value="" disabled selected>Chọn kích thước</option>
                        <?php 
                        if (!empty($available_sizes) && is_array($available_sizes)) {
                            foreach ($available_sizes as $size_id => $size_name) {
                                echo '<option value="'.$size_id.'">'.htmlspecialchars($size_name).'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="product-selection-group quantity-box">
                    <label for="quantity-input">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity-input" value="1" min="1" max="99" required style="width: 60px;">
                </div>
                
                <div class="action-buttons">

                    <button type="button" id="buy-now-button" class="btn-buy-now">
                        Mua Ngay
                    </button>
                    <button type="submit" class="btn-add-to-cart" style="border: 1px solid #001F3E;">
                        Thêm vào Giỏ hàng
                    </button>
                    
                    
                </div>
            </form>
        </div>
    </div>

    <div class="product-description-full">
        <h2 style="margin-bottom: 20px;" >Mô tả chi tiết</h2>
        <p style="margin-bottom: 20px;"><?php echo nl2br(htmlspecialchars($full_description)); ?></p>
        
        <div class="description-images">
             <img src="<?php echo htmlspecialchars($imagePath . $product_image); ?>" alt="Ảnh Sản Phẩm Chính">
             <img src="<?php echo htmlspecialchars($imagePath . $product_image_child); ?>" alt="Ảnh Sản Phẩm Phụ">
        </div>
    </div>

    <div class="related-products-section">
        <h2>SẢN PHẨM LIÊN QUAN</h2>
        <div class="pro-section-2-box2" style="justify-content: center; gap: 2%;">
            <?php 
            $count = 0;
            if (!empty($related_products) && is_array($related_products)):
                foreach ($related_products as $related_item): 
                    if ($count >= 4) break; 
                    
                    
            ?>
            
            <a href="?page=products_Details&id=<?php echo htmlspecialchars($related_item['id']); ?>" class="pro-section-2-boxSP" style="width: 23%; height: auto;">
                <img src="<?php echo htmlspecialchars($imagePath . $related_item['image']); ?>" alt="<?php echo htmlspecialchars($related_item['name']); ?>"> 

                <p class="pro-sec2-boxSP-name">
                    <?php echo htmlspecialchars($related_item['name']); ?>
                </p>
                
                <div class="pro-sec2-boxSP-miniBox">
                    <p>
                        <?php echo number_format($related_item['price'], 0, ',', '.'); ?> ₫
                    </p>

                    <div class="pro-sec2-boxSP-icon">
                        <img src="assets/images/img-icon/heart.png" alt="Yêu thích">
                    </div>
                </div>
            </a>

            <?php 
                $count++;
                endforeach; 
            else: 
            ?>
            <p style="width: 100%; text-align: center;">Không có sản phẩm liên quan nào.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function changeMainImage(newSrc) {
        const mainImage = document.getElementById('main-product-image');
        if (mainImage) mainImage.src = newSrc;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Thumbnail active
        const thumbnails = document.querySelectorAll('.thumb-image');
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                thumbnails.forEach(t => t.parentElement.classList.remove('active'));
                this.parentElement.classList.add('active');
            });
        });
        if (thumbnails.length > 0) thumbnails[0].parentElement.classList.add('active');

        // ==================== XỬ LÝ NÚT "MUA NGAY" ====================
        document.getElementById('buy-now-button').addEventListener('click', function() {
            const form = document.getElementById('add-to-cart-form');

            // Kiểm tra các trường required (màu, size, số lượng)
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            form.action = 'index.php?page=cart&action=add&redirect=thanhtoan';
            form.submit();
        });

        // Đặt lại action mặc định cho nút "Thêm vào giỏ hàng" (tránh bị ghi đè)
        document.getElementById('add-to-cart-form').action = 'index.php?page=cart&action=add';

        // 🚨 Sửa lỗi: Cần đảm bảo form không bị ghi đè action khi submit bằng nút mặc định
        document.getElementById('add-to-cart-form').addEventListener('submit', function() {
            // Đặt lại action mặc định, đảm bảo không có redirect
            this.action = 'index.php?page=cart&action=add';
        });
    });

    // Danh sách variant để lọc size theo màu
    const variants = <?php echo json_encode($variants ?? []); ?>;

    function updateSizes() {
        const colorId = document.getElementById('color-select').value;
        const sizeSelect = document.getElementById('size-select');
        sizeSelect.innerHTML = '<option value="" disabled selected>Chọn kích thước</option>';

        if (!colorId) return;

        const available = variants
            .filter(v => v.color_id == colorId && v.stock_quantity > 0)
            .map(v => ({id: v.size_id, name: v.size_name}));

        const unique = [...new Map(available.map(item => [item.id, item])).values()];

        unique.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.textContent = s.name;
            sizeSelect.appendChild(opt);
        });
    }
</script>