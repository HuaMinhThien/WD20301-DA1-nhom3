<link rel="stylesheet" href="assets/css/login.css">
<main class="auth-page-main">
    <div class="container-center"> 
        
        <div class="register-form-container login-form-container">
            
            <h1 class="register-title login-title">TẠO TÀI KHOẢN</h1>

            <!-- THÔNG BÁO ĐĂNG KÝ THÀNH CÔNG -->
            <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
                <div class="alert alert-success" style="background:#d4edda; color:#155724; padding:15px; border-radius:8px; margin:20px 0; text-align:center; font-weight:bold;">
                    Đăng ký thành công!<br>
                    Đang chuyển đến trang đăng nhập...
                </div>
                <script>
                    setTimeout(() => {
                        window.location.href = 'index.php?page=login';
                    }, 2000);
                </script>
            <?php endif; ?>

            <!-- THÔNG BÁO LỖI -->
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger" style="color:#721c24; background:#f8d7da; border:1px solid #f5c6cb; padding:12px; border-radius:5px; margin-bottom:15px; font-size:0.95em;">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <p class="register-instruction login-instruction">Quý khách vui lòng nhập thông tin để đăng ký</p>
            
            <!-- FORM ĐĂNG KÝ - ĐÃ SỬA ACTION & NAME FIELD -->
            <form action="index.php?page=register" method="POST" class="email-register-form">
                
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Họ và tên" 
                    required 
                    class="login-input"
                    value="<?php echo htmlspecialchars($input_data['name'] ?? ''); ?>"
                >

                <div class="gender-selection-group" style="margin: 15px 0; text-align: left;">
                    <label class="gender-radio">
                        <input 
                            type="radio" 
                            name="gender" 
                            value="0" 
                            required 
                            <?php echo (isset($input_data['gender']) && $input_data['gender'] == '0') ? 'checked' : ''; ?>
                        > Nữ
                    </label>
                    <label class="gender-radio" style="margin-left: 25px;">
                        <input 
                            type="radio" 
                            name="gender" 
                            value="1" 
                            required
                            <?php echo (isset($input_data['gender']) && $input_data['gender'] == '1') ? 'checked' : ''; ?>
                        > Nam
                    </label>
                    
                </div>
                
                <input 
                    type="date" 
                    name="dob" 
                    required 
                    class="login-input date-input"
                    value="<?php echo htmlspecialchars($input_data['dob'] ?? ''); ?>"
                >
                
                <!-- ĐÃ ĐỔI THÀNH name="phone" ĐỂ KHỚP VỚI MODEL -->
                <input 
                    type="tel" 
                    name="phone" 
                    placeholder="Số điện thoại" 
                    required 
                    class="login-input"
                    value="<?php echo htmlspecialchars($input_data['phone'] ?? ''); ?>"
                >
                
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email" 
                    required 
                    class="login-input"
                    value="<?php echo htmlspecialchars($input_data['email'] ?? ''); ?>"
                >
                
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Mật khẩu (tối thiểu 6 ký tự)" 
                    required 
                    class="login-input"
                    minlength="6"
                >
                
                <p class="terms-note" style="font-size: 0.9em; color: #555; margin: 15px 0;">
                    Nhấn vào <strong>"Đăng ký"</strong> nghĩa là quý khách đã đồng ý với 
                    <a href="#" class="policy-link">điều khoản dịch vụ</a> của chúng tôi.
                </p>
                
                <button type="submit" class="btn-register-submit btn-login-submit">
                    Đăng ký
                </button>
            </form>

            <div class="back-to-home-link" style="margin-top: 20px; text-align: center;">
                <a href="index.php?page=login" style="color: #007bff; font-weight: 500;">
                    Đã có tài khoản? Đăng nhập ngay
                </a>
                <br><br>
                <a href="index.php" class="register-link">
                    Quay lại trang chủ
                </a>
            </div>

        </div> 
    </div> 
</main>