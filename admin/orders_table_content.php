<?php 
// File này chỉ chứa phần <tbody> của bảng, giả định $orders và $status_map đã được định nghĩa 
// từ file orders.php gọi đến nó.

if (!empty($orders)): ?>
    <?php foreach ($orders as $order): 
        // Định dạng ngày
        $order_date = date('d/m/Y', strtotime($order['order_date']));
        // Định dạng tiền
        $total_pay = number_format($order['total_pay'], 0, ',', '.');
        // Gán class cho badge dựa trên status
        $status_class = strtolower($order['status']); 
        // Tên trạng thái hiển thị
        $status_text = $status_map[$status_class] ?? ucfirst($status_class);
    ?>
        <tr>
            <td>#ORD-<?php echo htmlspecialchars($order['id']); ?></td>
            <td><?php echo htmlspecialchars($order['customer_name'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($order_date); ?></td>
            <td><?php echo htmlspecialchars($total_pay); ?>₫</td>
            <td><span class="badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($status_text); ?></span></td>
            <td>
                <?php if ($status_class == 'pending'): ?>
                    <button class="btn-primary">Duyệt</button> 
                    <button class="btn-danger">Hủy</button>
                <?php else: ?>
                    <button class="btn-secondary">Chi tiết</button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" style="text-align: center; padding: 30px;">Không tìm thấy đơn hàng nào.</td>
    </tr>
<?php endif; ?>