<link rel="stylesheet" href="assets/css/thanhtoan.css">
<main class="checkout-page-main" style="padding-top: 120px;">
    <div class="checkout-container">
        <div class="checkout-left">
            <section class="shipping-info">
                <h2 class="section-title">Thông tin giao hàng</h2>
                <div class="tab-header">
                    <span class="tab-link active">Giỏ hàng /</span>
                    <span class="tab-link">Thông tin giao hàng</span>
                </div>

                <form class="shipping-form" method="POST" action="index.php?page=cart&action=checkout">
                    <input type="text" name="full_name" placeholder="Nhập họ và tên" required>
                    <input type="text" name="phone" placeholder="Nhập số điện thoại" required>
                    <input type="email" name="email" placeholder="Nhập email" required>
                    <input type="text" name="address" placeholder="Địa chỉ, tên đường" required>
                    <input type="text" name="city_district_ward" placeholder="Tỉnh/TP, Quận/Huyện, Phường/Xã" required>
                    <!-- Thêm hidden để gửi total và user_id -->
                    <input type="hidden" name="total_pay" value="<?= $grand_total ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? 0 ?>">
            </div>

            <div class="checkout-right">
                <section class="product-summary">
                    <h2 class="section-title">Giá</h2>
                    <?php foreach ($cart_items as $item): ?>
                    <div class="product-item">
                        <div class="product-thumb">
                            <img style="width: 80px; height: 100px;" src="assets/images/sanpham/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        </div>
                        <div class="product-details">
                            <p class="product-name"><?= htmlspecialchars($item['name']) ?></p>
                            <p class="product-sku">Màu: <?= htmlspecialchars($item['color_name']) ?> / Size: <?= htmlspecialchars($item['size_name']) ?></p>
                        </div>
                        <div class="product-price">
                            <p><?= number_format($item['price'], 0, ',', '.') ?>₫</p>
                        </div>
                        <div class="product-quantity">
                            x <?= $item['quantity'] ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </section>

                <!-- Phần mã khuyến mãi giữ nguyên hoặc tích hợp voucher nếu có -->

                <section class="order-summary">
                    <h2 class="section-title">Tóm tắt đơn hàng</h2>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Tổng tiền hàng</span>
                            <span><?= number_format($grand_total, 0, ',', '.') ?>₫</span>
                        </div>
                        <div class="summary-row">
                            <span>Tổng phí vận chuyển</span>
                            <span>0₫</span>
                        </div>
                        <div class="summary-row">
                            <span>Tổng khuyến mãi</span>
                            <span>0₫</span>
                        </div>
                        <div class="summary-row total">
                            <span>Tổng thanh toán</span>
                            <span><?= number_format($grand_total, 0, ',', '.') ?>₫</span>
                        </div>
                    </div>
                    <button type="submit" class="checkout-btn">Đặt hàng</button>
                </section>
            </div>
            </form>
        </div>
    </main>