<link rel="stylesheet" href="assets/css/cart-history.css">

<main class="order-history-main" style="padding-top: 120px; ">
    <div class="container">
        <div class="breadcrumb">
            <span>Trang chủ /</span>
            <span class="current-page">Lịch sử đơn hàng</span>
        </div>

        <div class="order-list">
            <?php 
            // Nhóm bill theo id để hiển thị từng đơn hàng
            $groupedBills = [];
            foreach ($bills as $bill) {
                $groupedBills[$bill['id']][] = $bill;
            }
            foreach ($groupedBills as $billId => $items): 
                $firstItem = $items[0]; // Lấy info chung từ item đầu

                // Reset tổng tiền cho mỗi đơn hàng mới
                $order_total = 0;
            ?>
                <div class="order-item <?= strtolower($firstItem['status']) ?>">

                    <div class="order-status-and-date">
                        <span class="order-date">Ngày đặt: <?= date('d/m/Y', strtotime($firstItem['order_date'])) ?></span>

                        <?php if ($firstItem['status'] == 'Đã hủy' || $firstItem['status'] == 'Chờ xác nhận'):?>
                            <span style="color: red; font-size: 16px;" class="status-badge <?= strtolower($firstItem['status']) ?>"><?= ucfirst($firstItem['status']) ?></span>
                        <?php elseif ($firstItem['status'] == 'Đã giao' ): ?>
                            <span style="color: green; font-size: 16px;" class="status-badge <?= strtolower($firstItem['status']) ?>"><?= ucfirst($firstItem['status']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="sec-order-show">

                        <div class="product-info">
                            <?php foreach ($items as $item): 
                                // Tính tổng cho đơn hàng hiện tại: giá x số lượng
                                $order_total += $item['price'] * $item['quantity'];
                            ?>
                            <a href="index.php?page=products_Details&id=<?= $item['product_id'] ?>" class="o-sanpham-img-name">
                                <div class="cot1-product">
                                    <div class="product-thumb" style="width: 70px; height: 100px;">
                                        <img src="assets/images/sanpham/<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                                    </div>
                                    
                                    <div class="product-details">
                                        <p class="product-name"><?= htmlspecialchars($item['product_name']) ?></p>
                                        <p class="product-quantity"> x<?= $item['quantity'] ?></p>
                                        <p class="product-sku">Màu: <?= htmlspecialchars($item['color_name']) ?> </p>
                                        <p class="product-sku"> Size: <?= htmlspecialchars($item['size_name']) ?></p>
                                    </div>
                                </div>

                                <div class="cot3-product">
                                    <p>Đơn giá: <?= number_format($item['price'], 0, ',', '.') ?>₫</p>
                                </div>
                            </a>
                            <hr style="border: 1px solid #00000027;">
                            <?php endforeach; ?>
                        </div>
                    </div>
                        
                    <!-- Hiển thị tổng tiền của TỪNG ĐƠN HÀNG -->
                    <div class="summary-total">
                        <span class="label">Tổng tiền:</span>
                        <h3 class="total-price"><?= number_format($order_total, 0, ',', '.') ?>₫</h3>
                    </div>

                    <div class="order-actions">
                        <div class="action-buttons">
                            <?php if ($firstItem['status'] == 'Chờ xác nhận'): ?>
                                <button class="action-btn cancel-btn">Hủy đơn</button>
                            <?php elseif ($firstItem['status'] == 'Đã hủy' || $firstItem['status'] == 'Đã giao' ): ?>
                                <button class="action-btn buy-again-btn">Mua lại</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>