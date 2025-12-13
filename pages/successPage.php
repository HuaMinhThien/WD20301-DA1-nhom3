
    <style>
        

        .success-container {
            background-color: #fff;
            padding: 40px 50px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 90%;
            /* height: 600px; */
        }

        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .success-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .order-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: left;
            font-size: 16px;
        }

        .order-info p {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
        }

        .order-info strong {
            color: #333;
        }

        .btn-group {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .btn {
            padding: 14px 30px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            min-width: 200px;
        }

        .btn-primary {
            
            background-color: #001F3E;
            color: #FDFACF;
        }

        .btn-primary:hover {
            background-color: #002b56ff;
        }

        .btn-secondary {
            background-color: #FDFACF;
            color: #001F3E;
        }

        .btn-secondary:hover {
            background-color: #002b56ff;
            color: #FDFACF;
            }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }
            .btn {
                width: 100%;
            }
        }
    </style>

<div class="container-center" style="padding:200px 0; display: flex; justify-content: center;">
    <div class="success-container">
        <div class="success-icon">✔</div>
        <h1 class="success-title">Đặt hàng thành công!</h1>

        <?php if (isset($_SESSION['order_success'])): 
            $order = $_SESSION['order_success'];
        ?>
            <div class="order-info">
                <p><strong>Mã đơn hàng:</strong> <span>#<?php echo $order['bill_id']; ?></span></p>
                <p><strong>Họ và tên:</strong> <span><?php echo htmlspecialchars($order['full_name']); ?></span></p>
                <p><strong>Số điện thoại:</strong> <span><?php echo htmlspecialchars($order['phone']); ?></span></p>
                <p><strong>Tổng thanh toán:</strong> <span><?php echo number_format($order['total_pay'], 0, ',', '.'); ?>₫</span></p>
            </div>

            <div class="btn-group">
                <a href="index.php?page=home" class="btn btn-primary">Tiếp tục mua sắm</a>
                <a href="index.php?page=cart_history" class="btn btn-secondary">Xem lịch sử đơn hàng</a>
            </div>

        <?php 
            // Xóa session để tránh hiển thị lại khi refresh trang
            unset($_SESSION['order_success']);
        else: ?>
            <p style="margin-bottom: 60px;">Không tìm thấy thông tin đơn hàng.</p>
            <a href="index.php?page=home" class="btn btn-primary" >Quay về trang chủ</a>
        <?php endif; ?>
    </div>
</div>
