<div class="main-content">  
    <header>
        <h1>Quản Lý Đơn Hàng</h1>
        <div class="user-wrapper">
            <img src="https://via.placeholder.com/40" alt="Admin">
            <div><h4>Admin</h4><small>Super Admin</small></div>
        </div>
    </header>

    <main>
        <div class="filter-group" style="margin-bottom: 1rem;">
            <button class="filter-btn active" data-status="all">Tất cả</button>
            <button class="filter-btn" data-status="pending">Chờ duyệt</button>
            <button class="filter-btn" data-status="success">Đã giao</button>
            <button class="filter-btn" data-status="danger">Đã hủy</button>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Danh sách</h3>
            </div>
            <div class="card-body">
                <table width="100%">
                    <thead>
                        <tr>
                            <th>Mã</th>
                            <th>Tên khách hàng</th>
                            <th>Ngày</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>Trần Huỳnh Thanh Liêm</td>
                            <td>24/11</td>
                            <td>2.000.000 đ</td>
                            <td><span class="badge pending">Chờ duyệt</span></td>
                            <td>
                                <div class="action-group">
                                    <button class="btn btn-dark btn-detail">Chi tiết</button>
                                    <button class="btn btn-dark btn-approve">Duyệt</button> 
                                    <button class="btn btn-danger btn-cancel">Hủy</button> 
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>#002</td>
                            <td>Mai Thái Tuấn</td>
                            <td>24/11</td>
                            <td>2.000.000 đ</td>
                            <td><span class="badge success">Đã giao</span></td>
                            <td>
                                <div class="action-group">
                                    <button class="btn btn-dark btn-detail">Chi tiết</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>#003</td>
                            <td>Hứa Minh Thiện</td>
                            <td>24/11</td>
                            <td>2.000.000 đ</td>
                            <td><span class="badge danger">Đã hủy</span></td>
                            <td>
                                <div class="action-group">
                                    <button class="btn btn-dark btn-detail">Chi tiết</button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>#004</td>
                            <td>Đào Lê Trí Tân</td>
                            <td>24/11</td>
                            <td>2.000.000 đ</td>
                            <td><span class="badge pending">Chờ duyệt</span></td>
                            <td>
                                <div class="action-group">
                                    <button class="btn btn-dark btn-detail">Chi tiết</button>
                                    <button class="btn btn-dark btn-approve">Duyệt</button> 
                                    <button class="btn btn-danger btn-cancel">Hủy</button> 
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<div id="modal-order-detail" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Chi tiết đơn hàng</h2>
            <span class="close-btn">&times;</span>
        </div>

        <div class="modal-body">
            
            <div class="order-info-row">
                <div class="info-left">
                    <p><strong>Đơn hàng: 22010124125521352</strong></p>
                    <p class="text-muted">24/11/2025 - 10:30 | NV check đơn Trần Văn A - Tranvana@gmail.com</p>
                </div>
                <div class="info-right">
                    <span class="badge success" style="font-size: 0.9rem;">Đã giao hàng</span>
                </div>
            </div>

            <div class="invoice-layout">
                
                <div class="layout-left">
                    <div class="customer-row">
                        <div class="box-info">
                            <h5>Khách hàng</h5>
                            <p>Trần Huỳnh Thanh Liêm</p>
                            <p>0909123123</p>
                        </div>
                        <div class="box-info highlight">
                            <h5>Người nhận</h5>
                            <p>Trần Huỳnh Thanh Liêm</p>
                            <p>0909123123</p>
                            <p>Tòa T, Trường FPT Polytechnic, Phần mềm Quang Trung</p>
                        </div>
                    </div>

                    <table class="table-product">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Áo Thun Nam Tay Ngắn Form Vừa<br>
                                    <small class="text-muted">SKU: TS26SS32T-RGUS</small>
                                </td>
                                <td>X1</td>
                                <td>390.000 đ</td>
                                <td>390.000 đ</td>
                            </tr>
                            <tr>
                                <td>
                                    Áo Sơ Mi Nam Tay Ngắn Form Ôm<br>
                                    <small class="text-muted">SKU: WS25FH76P-SD</small>
                                </td>
                                <td>X1</td>
                                <td>700.000 đ</td>
                                <td>700.000 đ</td>
                            </tr>
                            <tr>
                                <td>
                                    Áo Polo Nam Tay Ngắn Form Vừa<br>
                                    <small class="text-muted">SKU: KS26SS01T-SCCA</small>
                                </td>
                                <td>X1</td>
                                <td>700.000 đ</td>
                                <td>700.000 đ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="layout-right">
                    <div class="payment-box">
                        <h5>Phương thức thanh toán</h5>
                        <div class="row-between">
                            <span>MoMo</span>
                            <strong>2.000.000 đ</strong>
                        </div>
                    </div>

                    <div class="summary-box">
                        <div class="row-between">
                            <span>Tạm tính</span>
                            <span>2.000.000 đ</span>
                        </div>
                        <div class="row-between">
                            <span>Khuyến mãi</span>
                            <span class="text-danger">-30.000 đ</span>
                        </div>
                        <div class="row-between">
                            <span>Phí vận chuyển</span>
                            <span>Miễn phí</span>
                        </div>
                        <div class="row-between">
                            <span>Mã giảm giá</span>
                            <span>-</span>
                        </div>
                        <hr>
                        <div class="row-between total-row">
                            <strong>Thành tiền</strong>
                            <strong class="text-highlight">2.000.000 đ</strong>
                        </div>
                        <div class="row-between">
                            <small class="text-muted">Cần thanh toán</small>
                            <small class="text-muted">(Đã bao gồm VAT)</small>
                        </div>
                        
                        <div class="modal-footer">
                            <button class="btn btn-close-modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /* =========================================
       1. XỬ LÝ DUYỆT / HỦY ĐƠN HÀNG (MỚI THÊM)
       ========================================= */
    
    // --- Chức năng Duyệt đơn ---
    const approveBtns = document.querySelectorAll('.btn-approve');
    approveBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Bạn có chắc muốn duyệt đơn hàng này?')) return;

            // 1. Tìm dòng chứa nút vừa bấm
            const row = this.closest('tr');
            
            // 2. Tìm badge trạng thái trong dòng đó
            const badge = row.querySelector('.badge');

            // 3. Cập nhật giao diện Badge -> Đã giao (Xanh)
            badge.textContent = 'Đã giao';
            badge.className = 'badge success'; // Reset class và set thành success

            // 4. Ẩn nút Duyệt và Hủy đi (Chỉ giữ lại nút Chi tiết)
            this.style.display = 'none'; // Ẩn nút Duyệt
            const cancelBtn = row.querySelector('.btn-cancel');
            if (cancelBtn) cancelBtn.style.display = 'none'; // Ẩn nút Hủy
        });
    });

    // --- Chức năng Hủy đơn ---
    const cancelBtns = document.querySelectorAll('.btn-cancel');
    cancelBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Bạn có chắc muốn hủy đơn hàng này?')) return;

            // 1. Tìm dòng chứa nút vừa bấm
            const row = this.closest('tr');

            // 2. Tìm badge trạng thái
            const badge = row.querySelector('.badge');

            // 3. Cập nhật giao diện Badge -> Đã hủy (Đỏ)
            badge.textContent = 'Đã hủy';
            badge.className = 'badge danger';

            // 4. Ẩn nút Duyệt và Hủy đi
            this.style.display = 'none'; // Ẩn nút Hủy
            const approveBtn = row.querySelector('.btn-approve');
            if (approveBtn) approveBtn.style.display = 'none'; // Ẩn nút Duyệt
        });
    });


    /* =========================================
       2. XỬ LÝ LỌC TRẠNG THÁI (FILTER)
       ========================================= */
    const filterBtns = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('tbody tr');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Xóa class active cũ, thêm vào nút mới bấm
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const status = btn.getAttribute('data-status');

            tableRows.forEach(row => {
                const badge = row.querySelector('.badge');
                // Logic lọc: Nếu chọn All hoặc badge có class tương ứng thì hiện
                if (status === 'all' || badge.classList.contains(status)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });


    /* =========================================
       3. XỬ LÝ MODAL CHI TIẾT (POPUP)
       ========================================= */
    const modal = document.getElementById("modal-order-detail");
    const btnsOpen = document.querySelectorAll(".btn-detail"); 
    const btnClose = document.querySelector(".close-btn");
    const btnCloseFooter = document.querySelector(".btn-close-modal");

    // Mở modal
    btnsOpen.forEach(btn => {
        btn.addEventListener("click", () => {
            modal.style.display = "flex";
        });
    });

    // Các hàm đóng modal
    function closeModal() { modal.style.display = "none"; }
    btnClose.onclick = closeModal;
    btnCloseFooter.onclick = closeModal;
    window.onclick = (e) => { if (e.target == modal) closeModal(); }
</script>

</body>
</html>



<style>
  
</style>