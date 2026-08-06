<?php
$pageTitle = "Thêm sản phẩm";
require_once __DIR__ . "/../../../dao/ProductDAO.php";
require_once __DIR__ . "/../../../dao/CategoryDAO.php";
require_once __DIR__ . "/../../../dao/BrandDAO.php";
$dao = new ProductDAO();
$catDao = new CategoryDAO();
$brandDao = new BrandDAO();

$categories = $catDao->getAll();
$brands = $brandDao->getAll();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $proname = trim($_POST["productName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $categoryId = (int)($_POST["categoryId"] ?? 0);
    $brandId = (int)($_POST["brandId"] ?? 0);
    $price = (float)($_POST["price"] ?? 0);
    $discount_price = (float)($_POST["discount_price"] ?? 0);
    $quantity = (int)($_POST["quantity"] ?? 0);

    if ($proname == "") $errors[] = "Tên không được trống";
    if ($categoryId == 0) $errors[] = "Chọn danh mục";
    if ($brandId == 0) $errors[] = "Chọn thương hiệu";
    if ($price <= 0) $errors[] = "Giá > 0";
    if ($quantity < 0) $errors[] = "Số lượng không hợp lệ";

    if (empty($errors)) {
        $p = new Product($categoryId, $brandId, $proname, $slug, $price, $discount_price, $quantity, "", 1);
        if ($dao->insert($p)) {
            header("Location: index.php"); exit;
        } else $errors[] = "Thêm thất bại.";
    }
}
ob_start();
?>
<h2>Thêm sản phẩm</h2>
<?php if (!empty($errors)): ?><div class="alert alert-danger"><?= implode("<br>", $errors) ?></div><?php endif; ?>
<form method="POST">
    <div class="mb-3"><label>Tên sản phẩm</label><input type="text" name="productName" class="form-control"></div>
    <div class="mb-3"><label>Slug</label><input type="text" name="slug" class="form-control"></div>
    <div class="mb-3"><label>Danh mục</label>
        <select name="categoryId" class="form-select">
            <option value="0">Chọn...</option>
            <?php foreach($categories as $c): ?><option value="<?= $c->id ?>"><?= $c->name ?></option><?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Thương hiệu</label>
        <select name="brandId" class="form-select">
            <option value="0">Chọn...</option>
            <?php foreach($brands as $b): ?><option value="<?= $b["id"] ?? $b->id ?? $b->id ?>"><?= $b["brandname"] ?? "Brand" ?></option><?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Giá</label><input type="number" name="price" class="form-control"></div>
    <div class="mb-3"><label>Giá giảm</label><input type="number" name="discount_price" class="form-control"></div>
    <div class="mb-3"><label>Số lượng</label><input type="number" name="quantity" class="form-control"></div>
    <button type="submit" class="btn btn-primary">Lưu</button>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>
