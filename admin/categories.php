

    <div class="main-content">
        <header>
            <h1>Quản Lý Danh Mục</h1>
            <div class="user-wrapper">
                <img src="https://via.placeholder.com/40" alt="Admin">
                <div><h4>Admin</h4><small>Super Admin</small></div>
            </div>
        </header>

        <main>
            <div class="recent-grid">
                <div class="card">
                    <div class="card-header"><h3>Danh Sách Loại</h3></div>
                    <div class="card-body">
                        <table width="100%">
                            <thead><tr><td>ID</td><td>Tên</td><td>SL SP</td><td>Hành động</td></tr></thead>
                            <tbody>
                                <tr><td>#1</td><td>Áo Khoác</td><td>15</td><td><button class="action-btn edit"><i class="fa-solid fa-pen"></i></button></td></tr>
                                <tr><td>#2</td><td>Váy Đầm</td><td>8</td><td><button class="action-btn edit"><i class="fa-solid fa-pen"></i></button></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><h3>Thêm Mới</h3></div>
                    <div class="card-body">
                        <form class="admin-form">
                            <div class="form-group"><label>Tên Danh Mục</label><input type="text"></div>
                            <div class="form-group"><label>Mô tả</label><textarea rows="3"></textarea></div>
                            <button type="button" class="btn-primary">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>