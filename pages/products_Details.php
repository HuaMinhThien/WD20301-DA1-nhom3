<?php
if (empty($product)) {
    echo "<div style='text-align: center; padding: 50px;'>Không tìm thấy sản phẩm.</div>";
    return; 
}

// Giả định $product['image'] là 'img' và $product['image_child'] là 'img_child' 
// đã được lấy từ Model
$product_image = $product['image'] ?? 'default-main.jpg';
$product_image_child = $product['image_child'] ?? 'default-child.jpg'; 
// Dùng $product['description'] làm mô tả chi tiết nếu $product['description_full'] không có (vì đã sửa ở Model)
$full_description = $product['description_full'] ?? $product['description'] ?? 'Chưa có mô tả chi tiết.';


$available_sizes = ['S', 'M', 'L', 'XL'];
?>

<div class="product-detail-container">

    <div class="product-detail-main-content">
        
        <div class="product-thumbnails">
            <?php 
            // Vòng lặp này hoạt động dựa trên mảng 'thumbnails' được tạo trong ProductModel
            foreach ($product['thumbnails'] as $thumb): 
            ?>
                <div class="thumb-item">
                    <img class="thumb-image" 
                         src="<?php echo $imagePath . htmlspecialchars($thumb); ?>" 
                         alt="Thumbnail" 
                         onclick="changeMainImage('<?php echo $imagePath . htmlspecialchars($thumb); ?>')">
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="product-main-image">
            <img id="main-product-image" src="<?php echo $imagePath . htmlspecialchars($product_image); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        
        <div class="product-info-panel">
            <h1 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h1>
            
            <div class="price-section">
                <?php 
                // Sử dụng 'sale_price' và 'price' đã được chuẩn hóa trong Model
                $display_price = $product['price'] ?? 0;
                $display_sale_price = $product['sale_price'] ?? $display_price;
                ?>
                <?php if ($display_sale_price < $display_price): ?>
                    <span class="sale-price"><?php echo number_format($display_sale_price, 0, ',', '.'); ?>₫</span>
                    <span class="original-price"><?php echo number_format($display_price, 0, ',', '.'); ?>₫</span>
                <?php else: ?>
                    <span class="current-price"><?php echo number_format($display_price, 0, ',', '.'); ?>₫</span>
                <?php endif; ?>
            </div>
            
            <form action="index.php?page=cart&action=add" method="POST" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                <div class="option-group color-options">
                    <label>Màu sắc:</label>
                    <div class="color-swatches">
                        <span class="color-swatch active" style="background-color: #d1b59a;"></span>
                        <span class="color-swatch" style="background-color: #000000;"></span>
                        <span class="color-swatch" style="background-color: #ffffff; border: 1px solid #ccc;"></span>
                    </div>
                </div>

                <div class="option-group size-options">
                    <label for="size">Kích cỡ:</label>
                    <div class="size-buttons">
                        <?php foreach ($available_sizes as $size): ?>
                            <input type="radio" id="size-<?php echo $size; ?>" name="size" value="<?php echo $size; ?>" required>
                            <label for="size-<?php echo $size; ?>"><?php echo $size; ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="option-group quantity-control">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="99" required>
                </div>

                <div class="action-buttons">
                    <button type="submit" name="action" value="buy_now" class="btn-buy-now">MUA NGAY</button>
                    <button type="submit" name="action" value="add_to_cart" class="btn-add-to-cart">THÊM VÀO GIỎ</button>
                </div>
            </form>
            
            
        </div>
    </div>

    <div class="product-description-full">
        <h2>Mô tả chi tiết</h2>
        <p><?php echo nl2br(htmlspecialchars($full_description)); ?></p>
        

        <div class="description-images">
             <img src="<?php echo $imagePath . htmlspecialchars($product_image); ?>" alt="Ảnh Sản Phẩm Chính">
             <img src="<?php echo $imagePath . htmlspecialchars($product_image_child); ?>" alt="Ảnh Sản Phẩm Phụ">
        </div>
    </div>

    <div class="related-products-section">
        <h2>SẢN PHẨM LIÊN QUAN</h2>
        <div class="related-products-list">
            <?php 
            // Giả định $related_products được truyền từ Controller
            // Dùng vòng lặp để hiển thị tối đa 4 sản phẩm liên quan
            $count = 0;
            if (!empty($related_products)) {
                foreach ($related_products as $rp): 
                    if ($count >= 4) break; 
            ?>
                <div class="related-product-item">
                    <a href="?page=products_Details&id=<?php echo $rp['id']; ?>">
                        <img src="<?php echo $imagePath . htmlspecialchars($rp['image']); ?>" alt="<?php echo htmlspecialchars($rp['name']); ?>">
                        <p class="rp-name"><?php echo htmlspecialchars($rp['name']); ?></p>
                        <p class="rp-price"><?php echo number_format($rp['price'], 0, ',', '.'); ?>₫</p>
                    </a>
                </div>
            <?php 
                    $count++;
                endforeach;
            } else {
                echo "<p>Không có sản phẩm liên quan nào.</p>";
            }
            ?>
        </div>
    </div>
</div>

<script>
    /**
     * Hàm thay đổi nguồn (src) của ảnh chính.
     * @param {string} newSrc - Đường dẫn ảnh mới (từ thumbnail).
     */
    function changeMainImage(newSrc) {
        var mainImage = document.getElementById('main-product-image');
        if (mainImage) {
            mainImage.src = newSrc;
        }
    }

    // Tùy chọn: Thêm hiệu ứng active cho thumbnail được chọn (nếu bạn có CSS)
    document.addEventListener('DOMContentLoaded', function() {
        var thumbnails = document.querySelectorAll('.thumb-image');

        thumbnails.forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                // Loại bỏ lớp 'active' khỏi tất cả các thumbnail
                thumbnails.forEach(t => t.parentElement.classList.remove('active'));
                
                // Thêm lớp 'active' vào thumbnail vừa click
                this.parentElement.classList.add('active');
            });
        });
        
        // Thiết lập ảnh đầu tiên là active khi trang tải
        if (thumbnails.length > 0) {
            thumbnails[0].parentElement.classList.add('active');
        }
    });
</script>