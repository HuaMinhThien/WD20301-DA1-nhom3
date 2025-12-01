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

            <!-- Giữ lại email đã nhập khi bị lỗi -->
            <input 
                type="email" 
                name="email" 
                placeholder="Email..." 
                required 
                class="login-input"
                value="<?php echo htmlspecialchars($old_email); ?>"
            >
            
            <p class="login-instruction">Quý khách vui lòng chọn phương thức đăng nhập</p>
            
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
            
            <div class="divider">Hoặc</div>
            
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

                <p class="recaptcha-note">
                    Trang Web này được bảo vệ với reCAPTCHA <br>
                    thường xuyên và tuân thủ <a href="#" class="policy-link">Chính sách bảo mật</a> và <a href="#" class="policy-link">Điều khoản dịch vụ</a> của Google được áp dụng.
                </p>
                
                <button type="submit" class="btn-login-submit">ĐĂNG NHẬP</button>
            </form>

            <div class="register-link-box">
    Khách hàng mới? <a href="?page=register" class="register-link">Tạo tài khoản</a>
            </div>

        </div> 
    </div> 
</main>