<?php 
// File này chỉ chứa phần <tbody> của bảng, giả định $orders và $status_map đã được định nghĩa 
// từ file orders.php gọi đến nó.

// Ánh xạ ngược: Dùng để chuyển trạng thái từ CSDL (tiếng Việt) thành CSS class (tiếng Anh)
$class_map = [
    'Chờ xác nhận' => 'pending',
    'Đã giao' => 'shipped',
    'Đã hủy' => 'cancelled',
];

if (!empty($orders)): ?>
    <?php foreach ($orders as $order): 
        // Định dạng ngày
        $order_date = date('d/m/Y', strtotime($order['order_date']));
        // Định dạng tiền
        $total_pay = number_format($order['total_pay'], 0, ',', '.');
        
        // Tên trạng thái hiển thị (giá trị từ CSDL, tiếng Việt)
        $status_text = htmlspecialchars($order['status']);

        // Gán class cho badge dựa trên status (ánh xạ sang tiếng Anh/CSS class)
        // Nếu không tìm thấy, mặc định là 'default'
        $status_class = $class_map[$status_text] ?? 'default'; 
        
    ?>
        <tr>
            <td>#ORD-<?php echo htmlspecialchars($order['id']); ?></td>
            <td><?php echo htmlspecialchars($order['customer_name'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($order_date); ?></td>
            <td><?php echo htmlspecialchars($total_pay); ?>₫</td>
            <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
            <td>
                <?php if ($status_class == 'pending'): ?>
                    <button class="btn-primary action-btn" data-id="<?php echo htmlspecialchars($order['id']); ?>" data-action="shipped">Duyệt</button> 
                    <button class="btn-danger action-btn" data-id="<?php echo htmlspecialchars($order['id']); ?>" data-action="cancelled">Hủy</button>
                <?php endif; ?>
                <button class="btn-secondary detail-btn" data-id="<?php echo htmlspecialchars($order['id']); ?>">Chi tiết</button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" style="text-align: center; padding: 30px;">Không tìm thấy đơn hàng nào.</td>
    </tr>
<?php endif; ?>