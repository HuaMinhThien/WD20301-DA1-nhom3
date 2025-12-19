<?php 
$class_map = [
    'Chờ xác nhận' => 'pending',
    'pending'      => 'pending',
    'Đã xác nhận'  => 'confirmed',
    'Đang giao'    => 'processing',
    'Đã giao'      => 'shipped',
    'Đã hủy'       => 'cancelled',
];?>

<?php 
// orders_table_content.php

if (!empty($orders)): 
    foreach ($orders as $order): 
        $order_date = date('d/m/Y', strtotime($order['order_date']));
        $total_pay = number_format($order['total_pay'], 0, ',', '.');
        $raw_status = trim($order['status']); 
        
        // Xác định class cho badge
        $status_class = 'order-badge-';
        if ($raw_status === 'Chờ xác nhận' || $raw_status === 'pending') {
            $status_class .= 'pending';
            $display_text = 'Chờ xác nhận';
        } elseif ($raw_status === 'Đã xác nhận') {
            $status_class .= 'confirmed';
            $display_text = 'Đã xác nhận';
        } elseif ($raw_status === 'Đã giao') {
            $status_class .= 'shipped';
            $display_text = 'Đã giao';
        } elseif ($raw_status === 'Đã hủy') {
            $status_class .= 'cancelled';
            $display_text = 'Đã hủy';
        } else {
            $status_class .= 'default';
            $display_text = $raw_status;
        }
?>
        <tr class="order-row">
            <td class="order-col-code">#ORD-<?php echo htmlspecialchars($order['id']); ?></td>
            <td class="order-col-customer"><?php echo htmlspecialchars($order['customer_name'] ?? 'N/A'); ?></td>
            <td class="order-col-date"><?php echo htmlspecialchars($order_date); ?></td>
            <td class="order-col-total"><?php echo htmlspecialchars($total_pay); ?>₫</td>
            <td class="order-col-status">
                <span class="order-badge <?php echo $status_class; ?>">
                    <?php echo htmlspecialchars($display_text); ?>
                </span>
            </td>
            <td class="order-col-payment" style="font-weight: bold; color: <?php echo ($order['payment_status'] == 'Đã thanh toán' ? '#28a745' : '#fd7e14'); ?>">
                <?php echo $order['payment_status'] ?? 'Chờ thanh toán'; ?>
            </td>
            <td class="order-col-actions">
                <div class="order-action-buttons">
                    <?php if ($raw_status === 'Chờ xác nhận' || $raw_status === 'pending'): ?>
                        <button class="order-action-btn order-action-confirm" data-id="<?php echo $order['id']; ?>" data-action="confirmed">Xác nhận đơn</button>
                        <button class="order-action-btn order-action-cancel" data-id="<?php echo $order['id']; ?>" data-action="cancelled">Hủy</button>
                    <?php elseif ($raw_status === 'Đã xác nhận'): ?>
                        <button class="order-action-btn order-action-ship" data-id="<?php echo $order['id']; ?>" data-action="shipped">Đã giao</button>
                    <?php elseif ($raw_status === 'Đã giao'): ?>
                        <span class="order-completed">✓ Hoàn thành</span>
                    <?php endif; ?>
                    <button class="order-action-btn order-action-detail" data-id="<?php echo $order['id']; ?>">Chi tiết</button>
                </div>
            </td>
            <td class="order-col-payment-confirm">
                <?php if(($order['payment_status'] ?? '') != 'Đã thanh toán'): ?>
                    <button class="order-payment-btn" 
                            data-id="<?php echo $order['id']; ?>" 
                            data-payment="paid">Đã thu</button>
                <?php else: ?>
                    <span class="order-payment-confirmed">✓ Đã thu</span>
                <?php endif; ?>
            </td>
        </tr>
<?php endforeach; else: ?>
    <tr><td colspan="8" class="order-empty-message">Không tìm thấy đơn hàng nào.</td></tr>
<?php endif; ?>