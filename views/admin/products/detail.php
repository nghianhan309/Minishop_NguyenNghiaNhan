<?php
$pageTitle = "Chi tiết sản phẩm";
require_once __DIR__ . "/../../../dao/ProductDAO.php";
$dao = new ProductDAO();
$product = $dao->findById($_GET["id"] ?? 0);
if (!$product) die("Không tìm thấy");
ob_start();
?>
<h2>Chi tiết sản phẩm</h2>
<ul>
    <li>ID: <?= $product->id ?></li>
    <li>Tên sản phẩm: <?= htmlspecialchars($product->proname) ?></li>
    <li>Slug: <?= htmlspecialchars($product->slug) ?></li>
    <li>ID Danh mục: <?= $product->category_id ?></li>
    <li>ID Thương hiệu: <?= $product->brand_id ?></li>
    <li>Giá: <?= number_format($product->price) ?> đ</li>
    <li>Giá giảm: <?= number_format($product->discount_price) ?> đ</li>
    <li>Số lượng: <?= $product->quantity ?></li>
</ul>
<a href="index.php" class="btn btn-secondary">Quay lại</a>
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>
