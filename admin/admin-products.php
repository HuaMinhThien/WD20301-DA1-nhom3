

    <div class="main-content">
        <header>
            <h1>Quản Lý Sản Phẩm</h1>
        </header>
        <br>
        <main>
            <div class="recent-grid">
                <div class="card">
                    <div class="card-header"><h3>Danh Sách</h3></div>
                    <div class="card-body">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên</th>
                                    <th>Giá</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php 
    // Kiểm tra xem biến $products có tồn tại và là một mảng không
    if (isset($products) && is_array($products) && count($products) > 0): 
    ?>
        <?php foreach ($products as $row): ?>
            <tr>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="<?php echo $row['image']; ?>" width="50">
                    <?php endif; ?>
                </td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo number_format($row['price']); ?></td>
                </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" style="text-align:center;">Chưa có sản phẩm nào hoặc lỗi kết nối!</td>
        </tr>
    <?php endif; ?>
</tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3><?php echo isset($editProduct) ? 'Sửa ID: '.$editProduct['id'] : 'Thêm Mới'; ?></h3>
                    </div>
                    <div class="card-body">
                        <form class="admin-form" method="POST" enctype="multipart/form-data" action="index.php?action=<?php echo isset($editProduct) ? 'update' : 'create'; ?>">
                            
                            <?php if(isset($editProduct)): ?>
                                <input type="hidden" name="id" value="<?php echo $editProduct['id']; ?>">
                            <?php endif; ?>

                            <div class="form-group">
                                <label>Tên SP</label>
                                <input type="text" name="name" required value="<?php echo $editProduct['name'] ?? ''; ?>">
                            </div>
                            
                            <div class="form-group-row">
                                <div class="form-group">
                                    <label>Giá</label>
                                    <input type="number" name="price" required value="<?php echo $editProduct['price'] ?? ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Kho</label>
                                    <input type="number" name="storage" value="<?php echo $editProduct['storage'] ?? '100'; ?>">
                                </div>
                            </div>

                            <div class="form-group-row">
                                <div class="form-group">
                                    <label>Danh mục (ID)</label>
                                    <input type="number" name="category_id" placeholder="VD: 1" value="<?php echo $editProduct['category_id'] ?? ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Giới tính (ID)</label>
                                    <input type="number" name="gender_id" placeholder="VD: 1" value="<?php echo $editProduct['gender_id'] ?? ''; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Ảnh Đại diện</label>
                                <input type="file" name="img">
                                <?php if(isset($editProduct) && !empty($editProduct['image'])): ?>
                                    <small>Ảnh hiện tại: <?php echo $editProduct['image']; ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="description" rows="3"><?php echo $editProduct['description_full'] ?? ($editProduct['description'] ?? ''); ?></textarea>
                            </div>

                            <button type="submit" class="btn-primary">Lưu Lại</button>
                            <?php if(isset($editProduct)): ?>
                                <a href="index.php" style="display:block; text-align:center; margin-top:10px;">Hủy bỏ</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
