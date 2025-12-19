<?php 
// orders_table_content.php

// 1. Ánh xạ để gán class CSS (màu sắc) cho Badge
$class_map = [
    'Chờ xác nhận' => 'pending',
    'pending'      => 'pending', // Đảm bảo giá trị 'pending' cũng nhận màu vàng/cam
    'Đã giao'      => 'shipped',
    'Đã hủy'       => 'cancelled',
];?>

<?php 
// orders_table_content.php
$class_map = [
    'Chờ xác nhận' => 'pending',
    'pending'      => 'pending',
    'Đang giao'    => 'processing',
    'Đã giao'      => 'shipped',
    'Đã hủy'       => 'cancelled',
];

if (!empty($orders)): 
    foreach ($orders as $order): 
        $order_date = date('d/m/Y', strtotime($order['order_date']));
        $total_pay = number_format($order['total_pay'], 0, ',', '.');
        $raw_status = trim($order['status']); 
        
        // Lấy class từ mảng mapping, nếu không thấy thì để mặc định
        $status_class = $class_map[$raw_status] ?? 'default';
        $display_text = ($raw_status === 'pending') ? 'Chờ xác nhận' : $raw_status;
?>
        <tr>
            <td>#ORD-<?php echo htmlspecialchars($order['id']); ?></td>
            <td><?php echo htmlspecialchars($order['customer_name'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($order_date); ?></td>
            <td><?php echo htmlspecialchars($total_pay); ?>₫</td>
            <td>
                <span class="badge <?php echo $status_class; ?>">
                    <?php echo htmlspecialchars($display_text); ?>
                </span>
            </td>
            <td style="font-weight: bold; color: <?php echo ($order['payment_status'] == 'Đã thanh toán' ? '#28a745' : '#fd7e14'); ?>">
                <?php echo $order['payment_status'] ?? 'Chờ thanh toán'; ?>
            </td>
            <td>
                <div style="display: flex; gap: 5px;">
                    <?php if ($raw_status === 'Chờ xác nhận' || $raw_status === 'pending'): ?>
                        <button class="btn-primary action-btn" data-id="<?php echo $order['id']; ?>" data-action="shipped">Duyệt</button>
                        <button class="btn-danger action-btn" data-id="<?php echo $order['id']; ?>" data-action="cancelled">Hủy</button>
                    <?php endif; ?>
                    <button class="btn-secondary detail-btn" data-id="<?php echo $order['id']; ?>">Chi tiết</button>
                </div>
            </td>
            <td>
                <?php if(($order['payment_status'] ?? '') != 'Đã thanh toán'): ?>
                    <button class="payment-btn btn-success" 
                            style="background-color: #28a745; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px;"
                            data-id="<?php echo $order['id']; ?>" 
                            data-payment="paid">Xác nhận tiền</button>
                <?php else: ?>
                    <span style="color: #28a745; font-weight: bold;">✓ Đã thu</span>
                <?php endif; ?>
            </td>
        </tr>
<?php endforeach; else: ?>
    <tr><td colspan="8" style="text-align: center; padding: 30px;">Không tìm thấy đơn hàng nào.</td></tr>
<?php endif; ?>