<?php
$pageTitle = "Chi tiết danh mục";
require_once __DIR__ . "/../../../dao/CategoryDAO.php";
$dao = new CategoryDAO();
$category = $dao->findById($_GET["id"] ?? 0);
if (!$category) die("Không tìm thấy");
ob_start();
?>
<h2>Chi tiết danh mục</h2>
<ul>
    <li>ID: <?= $category->id ?></li>
    <li>Tên: <?= htmlspecialchars($category->name) ?></li>
    <li>Slug: <?= htmlspecialchars($category->slug) ?></li>
    <li>Trạng thái: <?= $category->status == 1 ? "Hiển thị" : "Ẩn" ?></li>
    <li>Mô tả: <?= htmlspecialchars($category->description) ?></li>
    <li>Ngày tạo: <?= $category->createdAt ?></li>
</ul>
<a href="index.php" class="btn btn-secondary">Quay lại</a>
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>
