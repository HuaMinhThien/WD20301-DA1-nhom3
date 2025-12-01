<link rel="stylesheet" href="assets/css/login.css">
<main class="auth-page-main">
    <div class="container-center"> 
        
        <div class="login-form-container">
            
            <h1 class="login-title">TÀI KHOẢN AURA CỦA BẠN</h1>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger" style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px; border-radius: 5px; background-color: #ffeaea; text-align: left; font-size: 0.9em;">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
                
            <p class="login-instruction">Quý khách vui lòng chọn phương thức đăng nhập</p>
            
            <form action="index.php?page=login" method="POST" class="email-login-form">
                <p class="login-instruction login-email-label">Đăng nhập bằng địa chỉ Email</p>
                
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email..." 
                    required 
                    class="login-input"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                >
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Mật khẩu..." 
                    required 
                    class="login-input"
                >
                
                <p class="forgot-password">
                    <a href="#">Quên mật khẩu</a>
                </p>
                
                <!-- DI CHUYỂN NÚT SUBMIT VÀO ĐÂY (BÊN TRONG FORM) -->
                <button type="submit" class="btn-login-submit">ĐĂNG NHẬP</button>
            </form>

            <div class="divider">Hoặc</div>

            <div class="social-login-group">
                <button class="social-btn social-google" type="button">
                    <img src="assets/images/img-icon/google-logo.png" alt="Google Icon" class="social-icon">
                    Tiếp tục với GOOGLE
                </button>
                <button class="social-btn social-apple" type="button">
                    <img src="assets/images/img-icon/apple-logo.png" alt="Apple Icon" class="social-icon">
                    Tiếp tục với APPLE
                </button>
            </div>
            
            <p class="recaptcha-note">
                Trang Web này được bảo vệ với reCAPTCHA <br>
                thường xuyên và tuân thủ <a href="#" class="policy-link">Chính sách bảo mật</a> và <a href="#" class="policy-link">Điều khoản dịch vụ</a> của Google được áp dụng.
            </p>

            <div class="register-link-box">
                Khách hàng mới? <a href="?page=register" class="register-link">Tạo tài khoản</a>
            </div>

        </div> 
    </div> 
</main>
<?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
    <div style="background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:20px 0;text-align:center;font-weight:bold;">
        Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.
    </div>
<?php endif; ?>