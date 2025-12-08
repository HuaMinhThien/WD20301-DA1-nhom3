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

                        <div class="product-info" id="product-info-<?= $billId ?>">
                            <?php 
                            $itemCount = count($items);
                            foreach ($items as $index => $item): 
                                // Tính tổng cho đơn hàng hiện tại: giá x số lượng (tính hết để hiển thị tổng tiền đúng)
                                $order_total += $item['price'] * $item['quantity'];

                                // Thêm class 'hidden' cho các sản phẩm từ thứ 2 trở đi
                                $hiddenClass = ($index > 0) ? 'hidden' : '';
                            ?>
                            <a href="index.php?page=products_Details&id=<?= $item['product_id'] ?>" class="o-sanpham-img-name product-item <?= $hiddenClass ?>">
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
                            <hr style="border: 1px solid #00000027;" class="product-item <?= $hiddenClass ?>">
                            <?php endforeach; ?>

                            <?php if ($itemCount > 1): ?>
                                <button class="view-more-btn" onclick="showAllProducts('<?= $billId ?>')">Xem thêm</button>
                            <?php endif; ?>
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
                                <a href="index.php?page=cart&action=cancel&bill_id=<?= $billId ?>" 
                                class="action-btn cancel-btn" 
                                onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                    Hủy đơn
                                </a>
                            <?php elseif ($firstItem['status'] == 'Đã hủy' || $firstItem['status'] == 'Đã giao'): ?>
                                <a href="index.php?page=cart&action=buy_again&bill_id=<?= $billId ?>" 
                                class="action-btn buy-again-btn" 
                                onclick="return confirm('Thêm lại toàn bộ sản phẩm trong đơn hàng này vào giỏ hàng?')">
                                    Mua lại
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<script>
    function showAllProducts(billId) {
        const productInfo = document.getElementById('product-info-' + billId);
        const hiddenItems = productInfo.querySelectorAll('.product-item.hidden');
        hiddenItems.forEach(item => {
            item.classList.remove('hidden');
        });
        const viewMoreBtn = productInfo.querySelector('.view-more-btn');
        if (viewMoreBtn) {
            viewMoreBtn.style.display = 'none'; 
        }
    }
</script>