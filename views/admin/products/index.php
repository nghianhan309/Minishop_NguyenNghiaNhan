<?php
$pageTitle = "Danh sách sản phẩm";
require_once __DIR__ . "/../../../dao/ProductDAO.php";
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
    <thead><tr><th>Hình ảnh</th><th>Tên</th><th>Danh mục</th><th>Thương hiệu</th><th>Giá</th><th>Chức năng</th></tr></thead>
    <tbody>
        <?php foreach ($products as $item): ?>
        <tr>
            <td>
                <?php if ($item->image != "") { ?>
                    <img src="/MiniShop_NguyenNghiaNhan/uploads/products/<?= $item->image ?>" class="img-thumbnail" width="80">
                <?php } else { ?>
                    <span class="text-muted">No Image</span>
                <?php } ?>
            </td>
            <td><?= htmlspecialchars($item->proname) ?></td>
            <td><?= htmlspecialchars($item->cateName) ?></td>
            <td><?= htmlspecialchars($item->brandName) ?></td>
            <td><?= number_format($item->price) ?></td>
            <td>
                <a href="detail.php?id=<?= $item->id ?>" class="btn btn-info btn-sm">Chi tiết</a>
                <a href="edit.php?id=<?= $item->id ?>" class="btn btn-warning btn-sm">Sửa</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Xóa?');">
                    <input type="hidden" name="id" value="<?= $item->id ?>">
                    <button type="submit" name="btnDelete" class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>