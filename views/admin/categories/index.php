<?php
$pageTitle = "Danh sách danh mục";
require_once __DIR__ . "/../../../dao/CategoryDAO.php";
$dao = new CategoryDAO();

if (isset($_POST["btnDelete"])) {
    $dao->delete((int)$_POST["id"]);
}

$keyword = trim($_GET["keyword"] ?? "");
$categories = $dao->getAll($keyword);
ob_start();
?>
<h2>Danh sách danh mục</h2>
<a href="create.php" class="btn btn-success mb-3">Thêm mới</a>
<form class="row mb-3" method="GET">
    <div class="col-md-4">
        <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa..." value="<?= htmlspecialchars($keyword) ?>">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </div>
</form>
<table class="table table-bordered">
    <thead><tr><th>STT</th><th>Tên danh mục</th><th>Slug</th><th>Trạng thái</th><th>Chức năng</th></tr></thead>
    <tbody>
        <?php $stt = 1; foreach ($categories as $item): ?>
        <tr>
            <td><?= $stt++ ?></td>
            <td><?= htmlspecialchars($item->name) ?></td>
            <td><?= htmlspecialchars($item->slug) ?></td>
            <td><?= $item->status == 1 ? "<span class=\"badge bg-success\">Hiển thị</span>" : "<span class=\"badge bg-secondary\">Ẩn</span>" ?></td>
            <td>
                <a href="detail.php?id=<?= $item->id ?>" class="btn btn-info btn-sm">Chi tiết</a>
                <a href="edit.php?id=<?= $item->id ?>" class="btn btn-warning btn-sm">Sửa</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                    <input type="hidden" name="id" value="<?= $item->id ?>">
                    <button type="submit" name="btnDelete" class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>
