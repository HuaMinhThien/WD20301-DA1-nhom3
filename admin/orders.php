
    
    <div class="main-content">
        <header>
            <h1>Quản Lý Đơn Hàng</h1>
            <div class="user-wrapper">
                <img src="https://via.placeholder.com/40" alt="Admin">
                <div><h4>Admin</h4><small>Super Admin</small></div>
            </div>
        </header>

        <main>
            <div style="margin-bottom:1rem;">
                <button class="btn-primary">Tất cả</button>
                <button class="btn-secondary">Chờ duyệt</button>
                <button class="btn-secondary">Đã giao</button>
            </div>
            <div class="card">
                <div class="card-header"><h3>Danh Sách Đơn</h3></div>
                <div class="card-body">
                    <table width="100%">
                        <thead><tr><td>Mã</td><td>Khách</td><td>Ngày</td><td>Tổng tiền</td><td>TT</td><td>Hành động</td></tr></thead>
                        <tbody>
                            <tr>
                                <td>#ORD-01</td><td>Nguyễn Văn A</td><td>24/11</td><td>$120</td>
                                <td><span class="badge warning">Chờ duyệt</span></td>
                                <td><button class="btn-primary">Duyệt</button> <button class="btn-danger">Hủy</button></td>
                            </tr>
                            <tr>
                                <td>#ORD-02</td><td>Trần B</td><td>20/11</td><td>$200</td>
                                <td><span class="badge success">Đã giao</span></td>
                                <td><button class="btn-secondary">Chi tiết</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>