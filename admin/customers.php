<div class="main-content">
    <header>
        <h1>Quản Lý Người Dùng</h1>
        <div class="user-wrapper">
            <img src="https://via.placeholder.com/40" alt="Admin">
            <div><h4>Admin</h4><small>Super Admin</small></div>
        </div>
    </header>

    <main>
        <div class="card">
            <div class="card-header"><h3>Danh Sách User</h3></div>
            <div class="card-body">
                <table width="100%">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Họ tên</td>
                            <td>Email</td>
                            <td>SĐT</td>
                            <td>Giới tính</td> 
                            <td>Vai trò</td>
                            <td>Hành động</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($users) && count($users) > 0): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>#USR-<?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td> 
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                    <td>
                                        <?php echo ($user['gender'] == 1) ? 'Nam' : 'Nữ'; ?>
                                    </td>
                                    <td>
                                        <span class="badge success">
                                            <?php echo htmlspecialchars($user['role']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <!-- From Uiverse.io by ahmed150up --> 
                                        <label class="lock-checkbox">
                                        <input id="lock" type="checkbox">
                                        <span class="lock-icon">
                                            <svg viewBox="0 0 24 24">
                                            <path d="M12 17c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm6-9h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM8.9 6c0-1.71 1.39-3.1 3.1-3.1s3.1 1.39 3.1 3.1v2H8.9V6z"></path>
                                            </svg>
                                        </span>
                                        </label>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" style="text-align:center">Chưa có dữ liệu user.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>