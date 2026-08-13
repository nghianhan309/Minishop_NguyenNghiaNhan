<h2>Thêm Khách Hàng</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <div class="mb-3"><label>Họ tên</label><input type="text" name="fullname" class="form-control" required></div>
    <div class="mb-3"><label>Số điện thoại</label><input type="text" name="phone" class="form-control"></div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="/MiniShop_NguyenNghiaNhan/admin/customer" class="btn btn-secondary">Hủy</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>