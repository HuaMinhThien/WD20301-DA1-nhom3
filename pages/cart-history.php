<link rel="stylesheet" href="assets/css/cart-history.css">


<main class="order-history-main" style="padding-top: 120px; ">
        <div class="container">
            <div class="breadcrumb">
                <span>Trang chủ /</span>
                <span class="current-page">Lịch sử đơn hàng</span>
            </div>

            <div class="tabs">
                <button class="tab-button active">Tất cả</button>
                <button class="tab-button">Đang chờ xử lý</button>
                <button class="tab-button">Đang giao</button>
                <button class="tab-button">Đã giao</button>
                <button class="tab-button">Trả hàng/Hoàn tiền</button>
                <button class="tab-button">Đã hủy</button>
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
                ?>
                    <div class="order-item <?= strtolower($firstItem['status']) ?>">
                        <div class="product-info">
                            <?php foreach ($items as $item): ?>
                            <div class="product-thumb">
                                <img src="assets/images/sanpham/<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                            </div>
                            <div class="product-details">
                                <p class="product-name"><?= htmlspecialchars($item['product_name']) ?></p>
                                <p class="product-quantity">Số lượng: x<?= $item['quantity'] ?></p>
                                <p class="product-sku">Màu: <?= htmlspecialchars($item['color_name']) ?> / Size: <?= htmlspecialchars($item['size_name']) ?></p>
                                <a href="index.php?page=products_Details&id=<?= $item['product_id'] ?>" class="view-detail-link">Xem chi tiết</a>
                            </div>
                            <hr>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="order-status-and-date">
                            <span class="order-date">Ngày đặt: <?= date('d/m/Y', strtotime($firstItem['order_date'])) ?></span>
                        </div>

                        <div class="order-actions">
                            <span class="status-badge <?= strtolower($firstItem['status']) ?>"><?= ucfirst($firstItem['status']) ?></span>
                            <div class="action-buttons">
                                <!-- Thêm button tùy theo status, ví dụ -->
                                <?php if ($firstItem['status'] == 'pending'): ?>
                                    <button class="action-btn cancel-btn">Hủy đơn</button>
                                <?php elseif ($firstItem['status'] == 'completed'): ?>
                                    <button class="action-btn review-btn">Đánh giá</button>
                                    <button class="action-btn buy-again-btn">Mua lại</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>