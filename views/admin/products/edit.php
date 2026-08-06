<?php
$pageTitle = "Cập nhật sản phẩm";
require_once __DIR__ . "/../../../dao/ProductDAO.php";
require_once __DIR__ . "/../../../dao/CategoryDAO.php";
require_once __DIR__ . "/../../../dao/BrandDAO.php";
$dao = new ProductDAO();
$catDao = new CategoryDAO();
$brandDao = new BrandDAO();

$id = $_GET["id"] ?? 0;
$product = $dao->findById($id);
if (!$product) die("Không tìm thấy sản phẩm");

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

    if (empty($errors)) {
        $product->proname = $proname;
        $product->slug = $slug;
        $product->category_id = $categoryId;
        $product->brand_id = $brandId;
        $product->price = $price;
        $product->discount_price = $discount_price;
        $product->quantity = $quantity;
        
        if ($dao->update($product)) {
            header("Location: index.php"); exit;
        } else $errors[] = "Cập nhật thất bại.";
    }
}
ob_start();
?>
<h2>Cập nhật sản phẩm</h2>
<?php if (!empty($errors)): ?><div class="alert alert-danger"><?= implode("<br>", $errors) ?></div><?php endif; ?>
<form method="POST">
    <div class="mb-3"><label>Tên sản phẩm</label><input type="text" name="productName" class="form-control" value="<?= htmlspecialchars($product->proname) ?>"></div>
    <div class="mb-3"><label>Slug</label><input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($product->slug) ?>"></div>
    <div class="mb-3"><label>Danh mục</label>
        <select name="categoryId" class="form-select">
            <option value="0">Chọn...</option>
            <?php foreach($categories as $c): ?>
                <option value="<?= $c->id ?>" <?= $c->id == $product->category_id ? "selected" : "" ?>><?= $c->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Thương hiệu</label>
        <select name="brandId" class="form-select">
            <option value="0">Chọn...</option>
            <?php foreach($brands as $b): 
                $bid = $b["id"] ?? $b->id ?? $b->id;
                $bname = $b["brandname"] ?? "Brand";
            ?>
                <option value="<?= $bid ?>" <?= $bid == $product->brand_id ? "selected" : "" ?>><?= $bname ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Giá</label><input type="number" name="price" class="form-control" value="<?= $product->price ?>"></div>
    <div class="mb-3"><label>Giá giảm</label><input type="number" name="discount_price" class="form-control" value="<?= $product->discount_price ?>"></div>
    <div class="mb-3"><label>Số lượng</label><input type="number" name="quantity" class="form-control" value="<?= $product->quantity ?>"></div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</form>
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>
