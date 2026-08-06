<?php
$baseDir = __DIR__ . '/';

$prodIndexCode = '<?php
$pageTitle = "Danh sách sản phẩm";
require_once "../../dao/ProductDAO.php";
$dao = new ProductDAO();
if (isset($_POST["btnDelete"])) {
    $dao->delete((int)$_POST["id"]);
}
$keyword = trim($_GET["keyword"] ?? "");
$products = $dao->getAll($keyword);
ob_start();
?>
<h2>Danh sách sản phẩm</h2>
<a href="create.php" class="btn btn-success mb-3">Thêm mới</a>
<form class="row mb-3" method="GET">
    <div class="col-md-4">
        <input type="text" name="keyword" class="form-control" placeholder="Tên sản phẩm..." value="<?= htmlspecialchars($keyword) ?>">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </div>
</form>
<table class="table table-bordered">
    <thead><tr><th>ID</th><th>Tên</th><th>Danh mục</th><th>Thương hiệu</th><th>Giá</th><th>Chức năng</th></tr></thead>
    <tbody>
        <?php foreach ($products as $item): ?>
        <tr>
            <td><?= $item->id ?></td>
            <td><?= htmlspecialchars($item->proname) ?></td>
            <td><?= htmlspecialchars($item->cateName) ?></td>
            <td><?= htmlspecialchars($item->brandName) ?></td>
            <td><?= number_format($item->price) ?></td>
            <td>
                <a href="detail.php?id=<?= $item->id ?>" class="btn btn-info btn-sm">Chi tiết</a>
                <a href="edit.php?id=<?= $item->id ?>" class="btn btn-warning btn-sm">Sửa</a>
                <form method="POST" class="d-inline" onsubmit="return confirm(\'Xóa?\');">
                    <input type="hidden" name="id" value="<?= $item->id ?>">
                    <button type="submit" name="btnDelete" class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>';
file_put_contents($baseDir . 'views/admin/products/index.php', $prodIndexCode);

$prodCreateCode = '<?php
$pageTitle = "Thêm sản phẩm";
require_once "../../dao/ProductDAO.php";
require_once "../../dao/CategoryDAO.php";
require_once "../../dao/BrandDAO.php";
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
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>';
file_put_contents($baseDir . 'views/admin/products/create.php', $prodCreateCode);

echo "Products generated.";
?>
