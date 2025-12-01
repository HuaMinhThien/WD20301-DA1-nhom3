<?php

class BillModel {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    // Lưu đơn hàng mới từ giỏ hàng
    // === HÀM TẠO ĐƠN HÀNG MỚI ===
    public function createBillFromCart($userId, $voucherId = null, $totalPay, $status = 'pending') {
        // 1. Lấy giỏ hàng
        $cartSql = "SELECT cd.quantity, cd.productVariant_id, pv.product_id, pv.color_id, pv.size_id, p.price, p.name, p.img
                    FROM cartdetail cd
                    JOIN product_variant pv ON cd.productVariant_id = pv.id
                    JOIN products p ON pv.product_id = p.id
                    JOIN cart c ON cd.cart_id = c.id
                    WHERE c.user_id = ?";
        $cartStmt = $this->db->prepare($cartSql);
        $cartStmt->execute([$userId]);
        $cartItems = $cartStmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cartItems)) return false;

        // 2. Tạo bill
        $billSql = "INSERT INTO bill (user_id, voucher_id, order_date, status, total_pay) 
                    VALUES (?, ?, NOW(), ?, ?)";
        $billStmt = $this->db->prepare($billSql);
        $billStmt->execute([$userId, $voucherId, $status, $totalPay]);
        $billId = $this->db->lastInsertId();

        // 3. Lưu vào billdetail (chỉ có productVariant_id và quantity)
        foreach ($cartItems as $item) {
            $detailSql = "INSERT INTO billdetail (bill_id, productVariant_id, quantity) 
                        VALUES (?, ?, ?)";
            $detailStmt = $this->db->prepare($detailSql);
            $detailStmt->execute([$billId, $item['productVariant_id'], $item['quantity']]);
        }

        // 4. Xóa giỏ hàng
        $clearSql = "DELETE cd FROM cartdetail cd JOIN cart c ON cd.cart_id = c.id WHERE c.user_id = ?";
        $clearStmt = $this->db->prepare($clearSql);
        $clearStmt->execute([$userId]);

        return $billId;
    }

    // === HÀM LẤY LỊCH SỬ ĐƠN HÀNG ===
    public function getBillsByUserId($userId) {
        $sql = "SELECT 
                    b.id, b.order_date, b.status, b.total_pay,
                    bd.productVariant_id, bd.quantity,
                    pv.product_id,
                    p.name AS product_name, p.img AS product_image, p.price,
                    c.name AS color_name, s.name AS size_name
                FROM bill b
                JOIN billdetail bd ON b.id = bd.bill_id
                JOIN product_variant pv ON bd.productVariant_id = pv.id
                JOIN products p ON pv.product_id = p.id
                JOIN color c ON pv.color_id = c.id
                JOIN size s ON pv.size_id = s.id
                WHERE b.user_id = ?
                ORDER BY b.order_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}