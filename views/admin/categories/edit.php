<h2>Cập nhật danh mục</h2>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
<?php endif; ?>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <input type="hidden" name="categoryId" value="<?= $category->id ?>">
    <div class="mb-3">
        <label>Tên danh mục</label>
        <input type="text" name="cateName" class="form-control" value="<?= htmlspecialchars($category->name) ?>">
    </div>
    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($category->slug) ?>">
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($category->description) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Trạng thái</label>
        <input type="radio" name="status" value="1" <?= $category->status==1 ? "checked" : "" ?>> Hiển thị
        <input type="radio" name="status" value="0" <?= $category->status==0 ? "checked" : "" ?>> Ẩn
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="/MiniShop_NguyenNghiaNhan/admin/category" class="btn btn-secondary">Quay lại</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>