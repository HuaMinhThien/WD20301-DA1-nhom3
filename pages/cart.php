<link rel="stylesheet" href="assets/css/cart.css">
<main class="cart-page-container" style="margin-top: 120px;">
    <div class="breadcrumb-bar container">
        <span>Trang chủ / Giỏ hàng</span>
    </div>

    <?php 
    // Lấy thông báo thành công từ Controller (Đã unset trong Controller)
    $current_user_id = $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2;
    $success_message = $_SESSION['success_message'] ?? null;
    $error_message = $_SESSION['error_message'] ?? null;
    ?>

    <div class="container">
        <?php if (isset($success_message)): ?>
            <div class="alert-success" style="padding: 15px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert-error" style="padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 5px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="cart-content container">
        
        <?php 
            // 🚨 ĐÃ SỬA: XÓA HÀM getFolderPrefix VÀ LOGIC TIỀN TỐ THƯ MỤC (ao/, quan/)
            
            $total_items = count($cart_items ?? []); // Đảm bảo $cart_items là mảng
            $grand_total = 0;
        ?>

        <h1 class="cart-title">
        
        <p style="color: #e74c3c; font-weight: bold; margin: 10px 0;">
            Đang xem giỏ hàng của User ID: <strong><?php echo $current_user_id; ?></strong>
            <?php if (!isset($_SESSION['user_id'])): ?>
                (Chưa đăng nhập - đang dùng tài khoản khách ID=2)
            <?php endif; ?>
        </p>

            Giỏ hàng của bạn
        </h1>
        <p class="cart-subtitle">Có <?php echo $total_items; ?> sản phẩm trong giỏ hàng</p>

        <?php if ($total_items > 0): ?>

            <div class="cart-main-grid">
                
                <div class="cart-items-list">
                    
                    <?php foreach ($cart_items as $item): 
                        // Lấy dữ liệu từ $cart_items (từ SQL hoặc Session)
                        $product_id = htmlspecialchars($item['product_id'] ?? $item['id']);
                        $item_name = htmlspecialchars($item['name']);
                        $item_qty = htmlspecialchars($item['quantity']);
                        
                        // Lấy Tên Size và Tên Color (Đã lấy từ JOIN trong Model hoặc lưu trong Session)
                        $item_size = htmlspecialchars($item['size_name'] ?? $item['size'] ?? 'N/A'); 
                        $item_color = htmlspecialchars($item['color_name'] ?? 'N/A');
                        
                        // Giá được lấy từ trường 'price' hoặc 'price_final'
                        $item_price = $item['price_final'] ?? $item['price'] ?? 0; 
                        $sub_total = $item_qty * $item_price;
                        $grand_total += $sub_total;
                        
                        // Tạo key duy nhất để xóa hoặc cập nhật: (Variant ID hoặc key Session)
                        $unique_key = $item['variant_id'] ?? $product_id . '_' . $item_size . '_' . $item_color; 

                        // 🚨 ĐÃ SỬA: Đường dẫn ảnh cố định, không dùng tiền tố ao/ quan/
                        $item_image = 'assets/images/sanpham/' . htmlspecialchars($item['image'] ?? 'default.jpg'); 
                    ?>
                        <div class="cart-item">
                            <div class="item-img-wrap">
                                <img src="<?php echo $item_image; ?>" alt="<?php echo $item_name; ?>">
                            </div>
                            <div class="item-details">
                                <div class="item-name"><?php echo $item_name; ?></div>
                                <div class="item-variant">Màu: **<?php echo $item_color; ?>** / Size: **<?php echo $item_size; ?>**</div>
                                <div class="item-price-mobile"><?php echo number_format($item_price, 0, ',', '.'); ?>₫</div>
                            </div>
                            <div class="item-actions">
                                <div class="item-price"><?php echo number_format($item_price, 0, ',', '.'); ?>₫</div>
                                <div class="item-quantity">
                                    <button class="qty-btn">-</button>
                                    <input type="text" value="<?php echo $item_qty; ?>" class="qty-input" readonly>
                                    <button class="qty-btn">+</button>
                                </div>
                                <div class="item-remove">
                                    <a href="index.php?page=cart&action=remove&key=<?php echo urlencode($unique_key); ?>&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>" title="Xóa sản phẩm">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary-box">
                    <div class="summary-total">
                        <span class="label">Tổng tiền:</span>
                        <span class="total-price"><?php echo number_format($grand_total, 0, ',', '.'); ?>₫</span>
                    </div>
                    <button class="btn-checkout">THANH TOÁN</button>
                    <a href="index.php?page=home&user_id=<?php echo $this->userId ?? 2; ?>" class="btn-continue">Tiếp tục mua hàng</a>
                </div>
            </div>

            <div class="notes-policies-grid">
                <div class="notes-box">
                    <span class="box-title">Ghi chú cho đơn hàng</span>
                    <textarea class="note-input" placeholder="Ghi chú"></textarea>
                </div>
                <div class="policies-box">
                    <span class="box-title">Chính sách mua hàng</span>
                    <ul class="policy-list">
                        <li>**KHÔNG ÁP DỤNG** ĐỔI TRẢ ĐỐI VỚI SẢN PHẨM MUA TRONG ĐỢT SALE VÀ SẢN PHẨM ĐÃ CẮT TAG.</li>
                        <li>Nếu Quý khách có nhu cầu tháo túi đựng giày, vui lòng ghi chú "không lấy túi đựng giày" khi đặt mua.</li>
                        <li>Lưu ý: Quý Khách có nhu cầu xuất hóa đơn vui lòng điền đầy đủ thông tin ở phần "Xuất hóa đơn" bên dưới.</li>
                    </ul>
                </div>
            </div>

            <div class="invoice-section">
                <div class="invoice-header">
                    <div class="radio-circle"></div>
                    <span class="invoice-title">Xuất hóa đơn cho đơn hàng</span>
                </div>
                <form class="invoice-form">
                    <div class="form-row">
                        <input type="text" placeholder="Tên công ty...">
                        <input type="text" placeholder="Mã số thuế...">
                        <input type="email" placeholder="Email...">
                    </div>
                    <div class="form-row">
                        <input type="text" placeholder="Địa chỉ công ty...">
                    </div>
                    <button type="submit" class="btn-invoice">LƯU THÔNG TIN</button>
                </form>
            </div>
            <div class="suggested-products-section">
                <h2>SẢN PHẨM GỢI Ý CHO BẠN</h2>
                <div class="pro-section-2-box2"> 
                    
                    <?php 
                    // Lấy $suggested_products được truyền từ Controller
                    if (!empty($suggested_products) && is_array($suggested_products)): 
                    ?>
                        <?php foreach ($suggested_products as $suggested_product): 
                            $s_id = htmlspecialchars($suggested_product['id']);
                            $s_name = htmlspecialchars($suggested_product['name']);
                            
                            // Sử dụng 'sale_price' nếu có, ngược lại dùng 'price'
                            $s_final_price = $suggested_product['sale_price'] ?? $suggested_product['price'];
                            $s_price_formatted = number_format($s_final_price, 0, ',', '.');
                            
                            $s_image_file = htmlspecialchars($suggested_product['image'] ?? 'default.jpg');
                            $s_image = 'assets/images/sanpham/' . $s_image_file;
                        ?>
                            <a href="index.php?page=products_Details&id=<?php echo $s_id; ?>&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>" class="pro-section-2-boxSP">
                                <img src="<?php echo $s_image; ?>" alt="<?php echo $s_name; ?>"> 

                                <p class="pro-sec2-boxSP-name">
                                    <?php echo $s_name; ?>
                                </p>
                                
                                <div class="pro-sec2-boxSP-miniBox">
                                    <p>
                                        <?php echo $s_price_formatted; ?> ₫
                                    </p>

                                    <div class="pro-sec2-boxSP-icon">
                                        <img src="assets/images/img-icon/heart.png" alt="Yêu thích">
                                        <img src="assets/images/img-icon/online-shopping.png" alt="Thêm vào giỏ">
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="width: 100%; text-align: center;">Hiện không có sản phẩm gợi ý nào.</p>
                    <?php endif; ?>
                    
                </div>
            </div>

        <?php else: ?>
            <div style="text-align: center; padding: 50px 0;">
                <p>Giỏ hàng của bạn hiện đang trống.</p>
                <a href="index.php?page=products&user_id=<?php echo $_GET['user_id'] ?? $_SESSION['user_id'] ?? 2; ?>" class="btn-continue" style="display: inline-block; margin-top: 20px;">Quay lại mua sắm</a>
            </div>
        <?php endif; ?>
    </div>
</main>