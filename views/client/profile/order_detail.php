<div class="mb-3">
    <a href="<?= BASE_URL ?>profile" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Quay lại hồ sơ</a>
</div>

<div class="card shadow-sm border-0 mb-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_code']) ?></h4>
        <?php 
        switch($order['status']) {
            case 0: echo '<span class="badge bg-warning text-dark fs-6">Chờ xác nhận</span>'; break;
            case 1: echo '<span class="badge bg-info fs-6">Đã xác nhận</span>'; break;
            case 2: echo '<span class="badge bg-primary fs-6">Đang giao</span>'; break;
            case 3: echo '<span class="badge bg-success fs-6">Đã giao</span>'; break;
            case 4: echo '<span class="badge bg-danger fs-6">Đã hủy</span>'; break;
        }
        ?>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <h6 class="fw-bold text-muted text-uppercase mb-3">Thông tin nhận hàng</h6>
            <p class="mb-1"><strong>Người nhận:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
            <p class="mb-1"><strong>Điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
            <p class="mb-1"><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?></p>
            <p class="mb-0"><strong>Ghi chú:</strong> <?= nl2br(htmlspecialchars($order['note'])) ?></p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <h6 class="fw-bold text-muted text-uppercase mb-3">Thông tin thanh toán</h6>
            <p class="mb-1"><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
            <p class="mb-1"><strong>Hình thức:</strong> COD - Thanh toán khi nhận hàng</p>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Sản phẩm</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-end">Đơn giá</th>
                    <th class="text-end">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['proname']) ?></td>
                    <td class="text-center"><?= $item['quantity'] ?></td>
                    <td class="text-end"><?= number_format($item['price']) ?> đ</td>
                    <td class="text-end fw-bold text-danger"><?= number_format($item['subtotal']) ?> đ</td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                    <td class="text-end fw-bold text-danger fs-5"><?= number_format($order['total_amount']) ?> đ</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php if ($order['status'] == 0): ?>
    <div class="text-end mb-4">
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
            <i class="bi bi-x-circle"></i> Yêu cầu hủy đơn hàng
        </button>
    </div>

    <!-- Modal Hủy đơn hàng -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= BASE_URL ?>profile/cancelOrder" method="POST">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="cancelOrderModalLabel">Hủy Đơn Hàng #<?= htmlspecialchars($order['order_code']) ?></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn hủy đơn hàng này không? Vui lòng chọn lý do hủy:</p>
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason1" value="Thay đổi ý định mua hàng" checked>
                            <label class="form-check-label" for="reason1">Thay đổi ý định mua hàng</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason2" value="Tìm thấy giá rẻ hơn ở nơi khác">
                            <label class="form-check-label" for="reason2">Tìm thấy giá rẻ hơn ở nơi khác</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason3" value="Quên thêm sản phẩm/Mã giảm giá">
                            <label class="form-check-label" for="reason3">Quên thêm sản phẩm/Mã giảm giá</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason4" value="Thời gian giao hàng quá lâu">
                            <label class="form-check-label" for="reason4">Thời gian giao hàng quá lâu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason5" value="Lý do khác">
                            <label class="form-check-label" for="reason5">Lý do khác</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
