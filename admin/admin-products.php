

    <div class="main-content">
        <header>
            <h1>Quản Lý Sản Phẩm</h1>
            <div class="user-wrapper">
                <img src="https://via.placeholder.com/40" alt="Admin">
                <div><h4>Admin</h4><small>Super Admin</small></div>
            </div>
        </header>

        <main>
            <div class="recent-grid">
                <div class="card">
                    <div class="card-header"><h3>Danh Sách</h3></div>
                    <div class="card-body">
                        <table width="100%">
                            <thead><tr><td>Tên</td><td>Giá</td><td>Kho</td><td>Hành động</td></tr></thead>
                            <tbody>
                                <tr>
                                    <td>Áo Blazer</td><td>$120</td><td>50</td>
                                    <td><button class="action-btn edit"><i class="fa-solid fa-pen"></i></button><button class="action-btn delete"><i class="fa-solid fa-trash"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"><h3>Thêm/Sửa</h3></div>
                    <div class="card-body">
                        <form class="admin-form">
                            <div class="form-group"><label>Tên SP</label><input type="text"></div>
                            <div class="form-group-row">
                                <div class="form-group"><label>Giá</label><input type="number"></div>
                                <div class="form-group"><label>Kho</label><input type="number"></div>
                            </div>
                            <div class="form-group-row">
                                <div class="form-group"><label>Màu</label><input type="color" value="#001F3E" style="height:45px;"></div>
                                <div class="form-group"><label>Size</label><select><option>S</option><option>M</option><option>L</option></select></div>
                            </div>
                            <div class="form-group"><label>Mô tả</label><textarea rows="3"></textarea></div>
                            <button type="button" class="btn-primary">Lưu</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>