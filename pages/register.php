<link rel="stylesheet" href="assets/css/login.css">
<main class="auth-page-main">
    <div class="container-center"> 
        
        <div class="register-form-container login-form-container">
            
            <h1 class="register-title login-title">TẠO TÀI KHOẢN</h1>
            
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger" style="color: red; margin-bottom: 15px; border: 1px solid red; padding: 10px; border-radius: 5px; background-color: #ffeaea; text-align: left; font-size: 0.9em;">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <p class="register-instruction login-instruction">Quý khách vui lòng nhập thông tin để đăng ký</p>
            
            <form action="index.php?route=register" method="POST" class="email-register-form">
                
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Họ và tên" 
                    required 
                    class="login-input"
                    value="<?php echo htmlspecialchars($input_data['name'] ?? ''); ?>"
                >

                <div class="gender-selection-group">
                    <label class="gender-radio">
                        <input 
                            type="radio" 
                            name="gender" 
                            value="0" 
                            required 
                            <?php echo (isset($input_data['gender']) && $input_data['gender'] === '0') ? 'checked' : ''; ?>
                        > Nữ
                    </label>
                    <label class="gender-radio">
                        <input 
                            type="radio" 
                            name="gender" 
                            value="1" 
                            required
                            <?php echo (isset($input_data['gender']) && $input_data['gender'] === '1') ? 'checked' : ''; ?>
                        > Nam
                    </label>
                </div>
                
                <input 
                    type="date" 
                    name="dob" 
                    placeholder="dd/mm/yyyy" 
                    required 
                    class="login-input date-input"
                    value="<?php echo htmlspecialchars($input_data['dob'] ?? ''); ?>"
                >
                
                <input 
                    type="tel" 
                    name="phone_number" 
                    placeholder="Phone number" 
                    required 
                    class="login-input"
                    value="<?php echo htmlspecialchars($input_data['phone_number'] ?? ''); ?>"
                >
                
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email" 
                    required 
                    class="login-input"
                    value="<?php echo htmlspecialchars($input_data['email'] ?? ''); ?>"
                >
                
                <input type="password" name="password" placeholder="Mật khẩu" required class="login-input">
                
                <p class="terms-note">
                    Nhấn vào **"Đăng ký"** quý khách chấp nhận nhận <a href="#" class="policy-link">điều khoản dịch vụ</a> của chúng tôi.
                </p>
                
                <button type="submit" class="btn-register-submit btn-login-submit">Đăng ký</button>
            </form>

            <div class="back-to-home-link">
                <a href="index.php" class="register-link">&leftarrow; Quay lại trang chủ</a>
            </div>

        </div> 
    </div> 
</main>