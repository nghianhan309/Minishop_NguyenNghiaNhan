<?php
$pageTitle = "Quản lý đơn hàng";
require_once __DIR__ . "/../../../dao/OrderDAO.php";
$dao = new OrderDAO();

$keyword = trim($_GET["keyword"] ?? "");
$status = $_GET["status"] ?? "";
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = trim($_GET["sort"] ?? "");

$offset = ($page - 1) * $limit;
$totalRecords = $dao->countOrder($keyword, $status);
$totalPages = ceil($totalRecords / $limit);

$orders = $dao->getPage($limit, $offset, $keyword, $status, $sort);
ob_start();
?>
<h2>Danh sách đơn hàng</h2>
<form class="row mb-3" method="GET">
    <div class="col-md-3">
        <input type="text" name="keyword" class="form-control" placeholder="Mã đơn / Tên KH..." value="<?= htmlspecialchars($keyword) ?>">
        <input type="hidden" name="limit" value="<?= $limit ?>">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Tất cả trạng thái --</option>
            <option value="0" <?= $status==="0"?"selected":"" ?>>Chờ xác nhận</option>
            <option value="1" <?= $status==="1"?"selected":"" ?>>Đã xác nhận</option>
            <option value="2" <?= $status==="2"?"selected":"" ?>>Đang giao</option>
            <option value="3" <?= $status==="3"?"selected":"" ?>>Hoàn thành</option>
            <option value="4" <?= $status==="4"?"selected":"" ?>>Đã hủy</option>
        </select>
    </div>
    <div class="col-md-3">
        <select name="sort" class="form-select">
            <option value="">Sắp xếp mặc định</option>
            <option value="amount_asc" <?= $sort == "amount_asc" ? "selected" : "" ?>>Tổng tiền tăng dần</option>
            <option value="amount_desc" <?= $sort == "amount_desc" ? "selected" : "" ?>>Tổng tiền giảm dần</option>
            <option value="date_asc" <?= $sort == "date_asc" ? "selected" : "" ?>>Ngày đặt cũ nhất</option>
            <option value="date_desc" <?= $sort == "date_desc" ? "selected" : "" ?>>Ngày đặt mới nhất</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Lọc & Tìm kiếm</button>
    </div>
</form>

<div class="d-flex justify-content-between align-items-center mb-3">
    <form method="GET" class="d-flex align-items-center">
        <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
        <input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">
        <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
        <label class="me-2">Hiển thị:</label>
        <select name="limit" class="form-select w-auto" onchange="this.form.submit()">
            <option value="10" <?= $limit == 10 ? "selected" : "" ?>>10</option>
            <option value="20" <?= $limit == 20 ? "selected" : "" ?>>20</option>
            <option value="30" <?= $limit == 30 ? "selected" : "" ?>>30</option>
        </select>
    </form>
    <span>Tổng số: <?= $totalRecords ?> đơn hàng</span>
</div>

<?php if ($totalRecords == 0): ?>
    <div class="alert alert-warning">Không tìm thấy đơn hàng.</div>
<?php else: ?>
    <table class="table table-bordered table-hover">
        <thead class="table-light"><tr><th>Mã đơn</th><th>Khách hàng</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th>Chức năng</th></tr></thead>
        <tbody>
            <?php foreach ($orders as $o): ?>
            <tr>
                <td><?= $o["order_code"] ?></td>
                <td><?= htmlspecialchars($o["customer_name"]) ?></td>
                <td><?= date("d/m/Y H:i", strtotime($o["created_at"])) ?></td>
                <td><?= number_format($o["total_amount"]) ?> đ</td>
                <td>
                    <?php
                    if($o["status"]==0) echo "<span class='badge bg-warning'>Chờ xác nhận</span>";
                    elseif($o["status"]==1) echo "<span class='badge bg-info'>Đã xác nhận</span>";
                    elseif($o["status"]==2) echo "<span class='badge bg-primary'>Đang giao</span>";
                    elseif($o["status"]==3) echo "<span class='badge bg-success'>Hoàn thành</span>";
                    elseif($o["status"]==4) echo "<span class='badge bg-danger'>Đã hủy</span>";
                    ?>
                </td>
                <td>
                    <a href="detail.php?id=<?= $o["id"] ?>" class="btn btn-info btn-sm">Chi tiết</a>
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
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&status=<?= $status ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=1">Đầu</a>
            </li>
            <li class="page-item <?= $page <= 1 ? "disabled" : "" ?>">
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&status=<?= $status ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=<?= $page - 1 ?>">Trước</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? "active" : "" ?>">
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&status=<?= $status ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $totalPages ? "disabled" : "" ?>">
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&status=<?= $status ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=<?= $page + 1 ?>">Sau</a>
            </li>
            <li class="page-item <?= $page >= $totalPages ? "disabled" : "" ?>">
                <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&status=<?= $status ?>&limit=<?= $limit ?>&sort=<?= $sort ?>&page=<?= $totalPages ?>">Cuối</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
<?php endif; ?>

<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>