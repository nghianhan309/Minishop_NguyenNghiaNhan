<h2>Chi tiết danh mục</h2>
<ul>
    <li>ID: <?= $category->id ?></li>
    <li>Tên: <?= htmlspecialchars($category->name) ?></li>
    <li>Slug: <?= htmlspecialchars($category->slug) ?></li>
    <li>Trạng thái: <?= $category->status == 1 ? "Hiển thị" : "Ẩn" ?></li>
    <li>Mô tả: <?= htmlspecialchars($category->description) ?></li>
    <li>Ngày tạo: <?= $category->createdAt ?></li>
</ul>
<a href="/MiniShop_NguyenNghiaNhan/admin/category" class="btn btn-secondary">Quay lại</a>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>