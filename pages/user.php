<link rel="stylesheet" href="assets/css/user.css">
<main class="user-page-main">
        <div class="container-user">
            <h1 class="page-title">TÀI KHOẢN CỦA BẠN</h1>

            <div class="user-content-wrapper">
                
                <div class="user-sidebar-box">
                    <div class="sidebar-header">
                       <img src="assets/images/img-logo/logo.jpg" alt="" style="width: 300px; height: 100px;" >
                        <p class="user-email">nguyenvana@email.com</p>
                    </div>

                    <div class="loyalty-points">
                        <p class="points-label">Điểm tích lũy:</p>
                        <p class="points-value">3107 điểm</p>
                    </div>

                    <nav class="user-menu">
                        <ul class="sidebar-menu">
                            <li class="menu-item active">
                                <a href="?page=user&action=info">Thông tin cá nhân</a>
                            </li>
                            <li class="menu-item">
                                <a href="?page=user&action=history">Lịch sử đặt hàng</a>
                            </li>
                            <li class="menu-item logout">
                                <a href="?page=logout">Đăng xuất</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="user-main-content-box">
                    <h2 class="content-title">THÔNG TIN TÀI KHOẢN</h2>
                    
                    <form class="personal-info-form">
                        
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" id="name" value="Nguyễn Văn A" class="input-field">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" value="nguyenvana@email.com" readonly class="input-field readonly"> 
                        </div>

                        <div class="form-row">
                            <div class="form-group form-half">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" id="phone" value="0987xxxxxx" class="input-field">
                            </div>

                            <div class="form-group form-half">
                                <label for="dob">Ngày sinh</label>
                                <input type="date" id="dob" value="2000-01-01" class="input-field">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Giới tính</label>
                            <div class="gender-options">
                                <label><input type="radio" name="gender" value="male" checked> Nam</label>
                                <label><input type="radio" name="gender" value="female"> Nữ</label>
                                <label><input type="radio" name="gender" value="other"> Tuấn (LGBT)</label>
                            </div>
                        </div>

                        <button type="submit" class="btn-update">CẬP NHẬT</button>
                    </form>
                </div>
            </div>
        </div>
    </main>