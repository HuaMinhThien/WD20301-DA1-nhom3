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
    unset($_SESSION['success_message'], $_SESSION['error_message']); // Unset lại để tránh lặp
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
                    <?php 
                    $grand_total = 0;
                    foreach ($cart_items as $item): 
                        $sub_total = $item['price'] * $item['quantity'];
                        $grand_total += $sub_total;
                    ?>
                        <div class="cart-item">
                            <div class="item-img-wrap">
                                <img src="assets/images/sanpham/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </div>
                            <div class="item-details">
                                <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                <div class="item-variant">
                                    Màu: <strong><?php echo htmlspecialchars($item['color_name']); ?></strong> / 
                                    Size: <strong><?php echo htmlspecialchars($item['size_name']); ?></strong>
                                </div>
                            </div>
                            <div class="item-actions">
                                <div class="item-price"><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</div>
                                <div class="item-subtotal">
                                    Tạm tính: <?php echo number_format($sub_total, 0, ',', '.'); ?>₫
                                </div>

                                <!-- Form cập nhật số lượng -->
                                <form action="index.php?page=cart&action=update&user_id=<?php echo $current_user_id; ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="variant_id" value="<?php echo $item['variant_id']; ?>">
                                    <div class="item-quantity">
                                        <button type="button" class="qty-btn" onclick="this.parentNode.querySelector('input[name=quantity]').stepDown(); this.form.submit();">-</button>
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="qty-input" readonly>
                                        <button type="button" class="qty-btn" onclick="this.parentNode.querySelector('input[name=quantity]').stepUp(); this.form.submit();">+</button>
                                    </div>
                                </form>

                                <!-- Nút xóa -->
                                <div class="item-remove">
                                    <a href="index.php?page=cart&action=remove&key=<?php echo $item['variant_id']; ?>&user_id=<?php echo $current_user_id; ?>" 
                                    onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
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
                    <a href="index.php?page=thanhtoan&user_id=<?php echo $current_user_id; ?>" class="btn-checkout">THANH TOÁN</a>
                    <a href="index.php?page=home&user_id=<?php echo $current_user_id; ?>" class="btn-continue">Tiếp tục mua hàng</a>
                </div>
            </div>

            

        <?php else: ?>
            <div style="text-align: center; padding: 50px 0;">
                <p>Giỏ hàng của bạn hiện đang trống.</p>
                <a href="index.php?page=products&user_id=<?php echo $current_user_id; ?>" class="btn-continue" style="display: inline-block; margin-top: 20px;">Quay về mua sắm</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- JS để update quantity (thêm vào cuối file hoặc script riêng) -->
    <script>
    function updateQty(button, change) {
        const input = button.parentElement.querySelector('.qty-input');
        let newQty = parseInt(input.value) + change;
        if (newQty < 1) newQty = 1;
        input.value = newQty;
        input.form.submit();  // Tự động submit form update
    }
    </script>
</main>