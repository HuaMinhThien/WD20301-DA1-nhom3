<link rel="stylesheet" href="assets/css/thanhtoan.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<main class="checkout-page-main" style="padding-top: 120px;">
    <div class="checkout-container">
        <div class="checkout-left">
            <section class="shipping-info">
                <h2 class="section-title">Thông tin giao hàng</h2>
                <div class="tab-header">
                    <span class="tab-link active">Giỏ hàng /</span>
                    <span class="tab-link">Thông tin giao hàng</span>
                </div>

                <form class="shipping-form" method="POST" action="index.php?page=cart&action=checkout" id="checkoutForm">
                    <input type="text" name="full_name" placeholder="Nhập họ và tên" required>
                    <input type="text" name="phone" placeholder="Nhập số điện thoại" required>
                    <input type="email" name="email" placeholder="Nhập email" required>
                    <input type="text" name="address" placeholder="Địa chỉ, tên đường, số nhà" required>
                    
                    <select name="province" id="province" required>
                        <option value="">Chọn Tỉnh/Thành phố</option>
                    </select>
                    
                    <select name="district" id="district" required disabled>
                        <option value="">Chọn Quận/Huyện</option>
                    </select>
                    
                    <input type="hidden" name="total_pay" value="<?= $grand_total ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? 0 ?>">
                    <input type="hidden" name="province_name" id="province_name">
                    <input type="hidden" name="district_name" id="district_name">
                    </section> </div>

        <div class="checkout-right">
            <section class="product-summary">
                <h2 class="section-title">Giỏ hàng</h2>
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
        </form> </div>
</main>

<script>
$(document).ready(function() {
    
    // Khởi tạo select box Quận/Huyện
    $('#district').prop('disabled', true).html('<option value="">Chọn Quận/Huyện</option>');

    // 1. Load danh sách tỉnh/thành từ API mới
    // Endpoint: https://esgoo.net/api-tinhthanh-new/1/0.htm
    $.getJSON('https://esgoo.net/api-tinhthanh-new/1/0.htm', function(data) {
        if (data && data.error === 0) {
            var options = '<option value="">Chọn Tỉnh/Thành phố</option>';
            $.each(data.data, function (index, province) {
                // Sử dụng 'id' làm code, 'full_name' làm tên
                options += '<option value="' + province.id + '">' + province.full_name + '</option>';
            });
            $('#province').html(options);
        } else {
            console.error('Không tải được dữ liệu Tỉnh/Thành phố từ API mới.');
            $('#province').html('<option value="">Không tải được dữ liệu</option>');
        }
    }).fail(function(jqxhr, textStatus, error) {
        console.error('Lỗi khi tải tỉnh thành:', textStatus, error);
        $('#province').html('<option value="">Lỗi khi tải dữ liệu</option>');
    });

    // 2. Khi chọn tỉnh/thành
    $('#province').change(function() {
        var provinceCode = $(this).val();
        var provinceName = $(this).find('option:selected').text();
        
        // Cập nhật giá trị hidden
        $('#province_name').val(provinceName);
        $('#district_name').val(''); // Reset

        if (provinceCode) {
            // Reset và enable quận/huyện
            $('#district').prop('disabled', false).html('<option value="">Đang tải...</option>');
            
            // Load danh sách Quận/Huyện (Cấp 2) từ API mới
            // Endpoint: https://esgoo.net/api-tinhthanh-new/2/[ID_TINH].htm
            var apiUrlDistrict = 'https://esgoo.net/api-tinhthanh-new/2/' + provinceCode + '.htm';

            $.getJSON(apiUrlDistrict, function(data) {	       
                if (data && data.error === 0) {
                   var options = '<option value="">Chọn Quận/Huyện</option>';
                   $.each(data.data, function (index, district) {
                      // Sử dụng 'id' làm code, 'full_name' làm tên
                      options += '<option value="' + district.id + '">' + district.full_name + '</option>';
                   });
                   $('#district').html(options);
                   console.log('Đã load ' + (data.data.length) + ' quận/huyện');
                } else {
                    $('#district').html('<option value="">Không có dữ liệu quận/huyện</option>');
                    console.error('Không tải được dữ liệu Quận/Huyện (cấp 2).');
                }
            }).fail(function(jqxhr, textStatus, error) {
                $('#district').html('<option value="">Lỗi khi tải dữ liệu</option>');
                console.error('Lỗi khi tải quận/huyện:', textStatus, error);
            });
            
        } else {
            // Nếu không chọn tỉnh
            $('#district').prop('disabled', true).html('<option value="">Chọn Quận/Huyện</option>');
        }
    });

    // 3. Khi chọn quận/huyện
    $('#district').change(function() {
        var districtName = $(this).find('option:selected').text();
        
        // Cập nhật giá trị hidden cho Quận/Huyện.
        $('#district_name').val(districtName);
        console.log('Đã chọn quận/huyện:', districtName);
    });

    // 4. Xử lý submit form
    $('#checkoutForm').submit(function(e) {
        // Kiểm tra đã chọn đầy đủ địa chỉ chưa (chỉ cần Tỉnh và Quận/Huyện)
        if (!$('#province').val() || !$('#district').val()) {
            alert('Vui lòng chọn đầy đủ Tỉnh/Thành phố và Quận/Huyện.');
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>