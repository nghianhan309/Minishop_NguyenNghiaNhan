<h2>Chi tiết đơn hàng #<?= $order["order_code"] ?></h2>
<?php if($success_msg): ?>
    <div class="alert alert-success"><?= $success_msg ?></div>
<?php endif; ?>
<div class="card mb-3">
    <div class="card-body">
        <form method="POST" action="">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Họ tên khách hàng</label>
                    <input type="text" name="customer_name" class="form-control" value="<?= htmlspecialchars($order["customer_name"]) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($order["phone"]) ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Địa chỉ giao hàng</label>
                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($order["address"]) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Ghi chú & Hình thức giao/nhận</label>
                <textarea name="note" class="form-control" rows="2"><?= htmlspecialchars($order["note"]) ?></textarea>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <strong class="me-3">Trạng thái đơn hàng:</strong>
                <select name="status" class="form-select w-auto me-3">
                    <option value="0" <?= $order["status"]==0?"selected":"" ?>>Chờ xác nhận</option>
                    <option value="1" <?= $order["status"]==1?"selected":"" ?>>Đã xác nhận</option>
                    <option value="2" <?= $order["status"]==2?"selected":"" ?>>Đang giao</option>
                    <option value="3" <?= $order["status"]==3?"selected":"" ?>>Hoàn thành</option>
                    <option value="4" <?= $order["status"]==4?"selected":"" ?>>Đã hủy</option>
                </select>
                <button type="submit" name="btnUpdateOrder" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
<h4>Sản phẩm</h4>
<table class="table table-bordered">
    <thead><tr><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead>
    <tbody>
        <?php foreach ($details as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d["proname"]) ?></td>
            <td><?= $d["quantity"] ?></td>
            <td><?= number_format($d["price"]) ?> đ</td>
            <td><?= number_format($d["subtotal"]) ?> đ</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-end">Tổng tiền:</th>
            <th class="text-danger fs-5"><?= number_format($order["total_amount"]) ?> đ</th>
        </tr>
    </tfoot>
</table>
<a href="/MiniShop_NguyenNghiaNhan/admin/order" class="btn btn-secondary">Quay lại</a>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>