<?php
$pageTitle = "Danh sách sản phẩm";
require_once __DIR__ . "/../../../dao/ProductDAO.php";
$dao = new ProductDAO();

if (isset($_POST["btnDelete"])) {
    $dao->delete((int)$_POST["id"]);
}

$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = trim($_GET["sort"] ?? "");

$offset = ($page - 1) * $limit;
$totalRecords = $dao->count("products", "proname", $keyword);
$totalPages = ceil($totalRecords / $limit);

$products = $dao->getPage($limit, $offset, $keyword, $sort);
ob_start();
?>
<h2>Danh sách sản phẩm</h2>
<a href="create.php" class="btn btn-success mb-3">Thêm mới</a>

<form class="row mb-3" method="GET">
    <div class="col-md-3">
        <input type="text" name="keyword" class="form-control" placeholder="Tên sản phẩm..." value="<?= htmlspecialchars($keyword) ?>">
        <input type="hidden" name="limit" value="<?= $limit ?>">
    </div>
    <div class="col-md-3">
        <select name="sort" class="form-select">
            <option value="">Sắp xếp mặc định</option>
            <option value="name_asc" <?= $sort == "name_asc" ? "selected" : "" ?>>Tên A-Z</option>
            <option value="name_desc" <?= $sort == "name_desc" ? "selected" : "" ?>>Tên Z-A</option>
            <option value="price_asc" <?= $sort == "price_asc" ? "selected" : "" ?>>Giá tăng dần</option>
            <option value="price_desc" <?= $sort == "price_desc" ? "selected" : "" ?>>Giá giảm dần</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Lọc & Tìm kiếm</button>
    </div>
</form>

<div class="d-flex justify-content-between align-items-center mb-3">
    <form method="GET" class="d-flex align-items-center">
        <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
        <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
        <label class="me-2">Hiển thị:</label>
        <select name="limit" class="form-select w-auto" onchange="this.form.submit()">
            <option value="10" <?= $limit == 10 ? "selected" : "" ?>>10</option>
            <option value="20" <?= $limit == 20 ? "selected" : "" ?>>20</option>
            <option value="30" <?= $limit == 30 ? "selected" : "" ?>>30</option>
        </select>
    </form>
    <span>Tổng số: <?= $totalRecords ?> sản phẩm</span>
</div>

<?php if ($totalRecords == 0): ?>
    <div class="alert alert-warning">Không tìm thấy sản phẩm.</div>
<?php else: ?>
    <table class="table table-bordered table-hover">
        <thead class="table-light"><tr><th>ID</th><th>Hình ảnh</th><th>Tên</th><th>Danh mục</th><th>Thương hiệu</th><th>Giá</th><th>Chức năng</th></tr></thead>
        <tbody>
            <?php foreach ($products as $item): ?>
            <tr>
                <td><?= $item->id ?></td>
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
                <td><?= number_format($item->price) ?> đ</td>
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

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $page <= 1 ? "disabled" : "" ?>">
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=1">Đầu</a>
            </li>
            <li class="page-item <?= $page <= 1 ? "disabled" : "" ?>">
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=<?= $page - 1 ?>">Trước</a>
            </li>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? "active" : "" ?>">
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <li class="page-item <?= $page >= $totalPages ? "disabled" : "" ?>">
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=<?= $page + 1 ?>">Sau</a>
            </li>
            <li class="page-item <?= $page >= $totalPages ? "disabled" : "" ?>">
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=<?= $totalPages ?>">Cuối</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
<?php endif; ?>

<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>