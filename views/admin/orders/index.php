<?php
$pageTitle = "Quản lý đơn hàng";
require_once __DIR__ . "/../../../dao/OrderDAO.php";
$dao = new OrderDAO();
$keyword = trim($_GET["keyword"] ?? "");
$status = $_GET["status"] ?? "";
$orders = $dao->getAll($keyword, $status);
ob_start();
?>
<h2>Danh sách đơn hàng</h2>
<form class="row mb-3" method="GET">
    <div class="col-md-3">
        <input type="text" name="keyword" class="form-control" placeholder="Mã đơn / Tên KH..." value="<?= htmlspecialchars($keyword) ?>">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Tất cả --</option>
            <option value="0" <?= $status==="0"?"selected":"" ?>>Chờ xác nhận</option>
            <option value="1" <?= $status==="1"?"selected":"" ?>>Đã xác nhận</option>
            <option value="2" <?= $status==="2"?"selected":"" ?>>Đang giao</option>
            <option value="3" <?= $status==="3"?"selected":"" ?>>Hoàn thành</option>
            <option value="4" <?= $status==="4"?"selected":"" ?>>Đã hủy</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </div>
</form>
<table class="table table-bordered">
    <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th>Chức năng</th></tr></thead>
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
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>