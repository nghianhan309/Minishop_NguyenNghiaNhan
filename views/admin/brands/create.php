<h2>Thêm Thương Hiệu</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <div class="mb-3"><label>Tên thương hiệu</label><input type="text" name="name" class="form-control" required></div>
    <div class="mb-3"><label>Slug</label><input type="text" name="slug" class="form-control"></div>
    <div class="mb-3">
        <label>Hình ảnh Logo</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="/MiniShop_NguyenNghiaNhan/admin/brand" class="btn btn-secondary">Hủy</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>