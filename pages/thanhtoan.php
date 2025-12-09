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
                    
                    <!-- Select box cho Tỉnh/Thành phố -->
                    <select name="province" id="province" required>
                        <option value="">Chọn Tỉnh/Thành phố</option>
                    </select>
                    
                    <!-- Select box cho Quận/Huyện -->
                    <select name="district" id="district" required disabled>
                        <option value="">Chọn Quận/Huyện</option>
                    </select>
                    
                    <!-- Select box cho Phường/Xã -->
                    <select name="ward" id="ward" required disabled>
                        <option value="">Chọn Phường/Xã</option>
                    </select>
                    
                    <!-- Thêm hidden để gửi total và user_id -->
                    <input type="hidden" name="total_pay" value="<?= $grand_total ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? 0 ?>">
                    <input type="hidden" name="province_name" id="province_name">
                    <input type="hidden" name="district_name" id="district_name">
                    <input type="hidden" name="ward_name" id="ward_name">
            </div>

            <div class="checkout-right">
                <section class="product-summary">
                    <h2 class="section-title">Giá</h2>
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
            </form>
        </div>
    </div>
</main>

<script>
$(document).ready(function() {
    // Load danh sách tỉnh/thành
    $.getJSON('https://34tinhthanh.com/api/provinces', function(data) {
        if (data && data.length > 0) {
            var options = '<option value="">Chọn Tỉnh/Thành phố</option>';
            $.each(data, function(index, province) {
                options += '<option value="' + province.code + '">' + province.name + '</option>';
            });
            $('#province').html(options);
        } else {
            console.error('Không có dữ liệu tỉnh thành');
            $('#province').html('<option value="">Không tải được dữ liệu</option>');
        }
    }).fail(function(jqxhr, textStatus, error) {
        console.error('Lỗi khi tải tỉnh thành:', textStatus, error);
        $('#province').html('<option value="">Lỗi khi tải dữ liệu</option>');
    });

    // Khi chọn tỉnh/thành
    $('#province').change(function() {
        var provinceCode = $(this).val();
        var provinceName = $(this).find('option:selected').text();
        $('#province_name').val(provinceName);
        
        console.log('Đã chọn tỉnh:', provinceCode, provinceName);
        
        if (provinceCode) {
            // Reset và enable quận/huyện
            $('#district').prop('disabled', false).html('<option value="">Đang tải...</option>');
            $('#ward').prop('disabled', true).html('<option value="">Chọn Phường/Xã</option>');
            
            // Thử các URL API khác nhau cho quận/huyện
            var apiUrls = [
                'https://34tinhthanh.com/api/districts?province_code=' + provinceCode,
                'https://34tinhthanh.com/api/districts?province=' + provinceCode,
                'https://34tinhthanh.com/api/districts/' + provinceCode,
                'https://34tinhthanh.com/api/provinces/' + provinceCode + '/districts'
            ];
            
            // Hàm thử lần lượt các API
            function tryNextApi(index) {
                if (index >= apiUrls.length) {
                    $('#district').html('<option value="">Không có dữ liệu quận/huyện</option>');
                    console.error('Đã thử tất cả API nhưng không thành công');
                    return;
                }
                
                console.log('Đang thử API:', apiUrls[index]);
                
                $.getJSON(apiUrls[index])
                    .done(function(data) {
                        console.log('Dữ liệu quận/huyện nhận được:', data);
                        
                        if (data && data.length > 0) {
                            var options = '<option value="">Chọn Quận/Huyện</option>';
                            $.each(data, function(index, district) {
                                // Kiểm tra cấu trúc dữ liệu
                                var districtCode = district.code || district.district_code || district.id;
                                var districtName = district.name || district.district_name;
                                
                                if (districtCode && districtName) {
                                    options += '<option value="' + districtCode + '">' + districtName + '</option>';
                                }
                            });
                            $('#district').html(options);
                            console.log('Đã load ' + (data.length) + ' quận/huyện');
                        } else {
                            // Thử API tiếp theo
                            tryNextApi(index + 1);
                        }
                    })
                    .fail(function(jqxhr, textStatus, error) {
                        console.log('API ' + apiUrls[index] + ' thất bại:', textStatus);
                        // Thử API tiếp theo
                        tryNextApi(index + 1);
                    });
            }
            
            // Bắt đầu thử từ API đầu tiên
            tryNextApi(0);
            
        } else {
            $('#district').prop('disabled', true).html('<option value="">Chọn Quận/Huyện</option>');
            $('#ward').prop('disabled', true).html('<option value="">Chọn Phường/Xã</option>');
        }
    });

    // Khi chọn quận/huyện
    $('#district').change(function() {
        var districtCode = $(this).val();
        var districtName = $(this).find('option:selected').text();
        $('#district_name').val(districtName);
        
        console.log('Đã chọn quận/huyện:', districtCode, districtName);
        
        if (districtCode) {
            // Reset và enable phường/xã
            $('#ward').prop('disabled', false).html('<option value="">Đang tải...</option>');
            
            // Thử các URL API khác nhau cho phường/xã
            var apiUrls = [
                'https://34tinhthanh.com/api/wards?district_code=' + districtCode,
                'https://34tinhthanh.com/api/wards?district=' + districtCode,
                'https://34tinhthanh.com/api/wards/' + districtCode,
                'https://34tinhthanh.com/api/districts/' + districtCode + '/wards'
            ];
            
            // Hàm thử lần lượt các API
            function tryNextWardApi(index) {
                if (index >= apiUrls.length) {
                    $('#ward').html('<option value="">Không có dữ liệu phường/xã</option>');
                    console.error('Đã thử tất cả API nhưng không thành công');
                    return;
                }
                
                console.log('Đang thử API phường/xã:', apiUrls[index]);
                
                $.getJSON(apiUrls[index])
                    .done(function(data) {
                        console.log('Dữ liệu phường/xã nhận được:', data);
                        
                        if (data && data.length > 0) {
                            var options = '<option value="">Chọn Phường/Xã</option>';
                            $.each(data, function(index, ward) {
                                // Kiểm tra cấu trúc dữ liệu
                                var wardCode = ward.code || ward.ward_code || ward.id;
                                var wardName = ward.name || ward.ward_name;
                                
                                if (wardCode && wardName) {
                                    options += '<option value="' + wardCode + '">' + wardName + '</option>';
                                }
                            });
                            $('#ward').html(options);
                            console.log('Đã load ' + (data.length) + ' phường/xã');
                        } else {
                            // Thử API tiếp theo
                            tryNextWardApi(index + 1);
                        }
                    })
                    .fail(function(jqxhr, textStatus, error) {
                        console.log('API phường/xã ' + apiUrls[index] + ' thất bại:', textStatus);
                        // Thử API tiếp theo
                        tryNextWardApi(index + 1);
                    });
            }
            
            // Bắt đầu thử từ API đầu tiên
            tryNextWardApi(0);
            
        } else {
            $('#ward').prop('disabled', true).html('<option value="">Chọn Phường/Xã</option>');
        }
    });

    // Khi chọn phường/xã
    $('#ward').change(function() {
        var wardName = $(this).find('option:selected').text();
        $('#ward_name').val(wardName);
        console.log('Đã chọn phường/xã:', wardName);
    });

    // Xử lý submit form
    $('#checkoutForm').submit(function(e) {
        // Kiểm tra đã chọn đầy đủ địa chỉ chưa
        if (!$('#province').val() || !$('#district').val() || !$('#ward').val()) {
            alert('Vui lòng chọn đầy đủ tỉnh/thành phố, quận/huyện và phường/xã');
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>