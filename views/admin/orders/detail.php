<?php
$pageTitle = "Chi tiết đơn hàng";
require_once __DIR__ . "/../../../dao/OrderDAO.php";
$dao = new OrderDAO();
$id = $_GET["id"] ?? 0;
$order = $dao->findById($id);
if (!$order) die("Không tìm thấy đơn hàng");

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnUpdateStatus"])) {
    $dao->updateStatus($id, (int)$_POST["status"]);
    $_SESSION["success_msg"] = "Cập nhật trạng thái thành công!";
    header("Location: detail.php?id=$id"); exit;
}

$details = $dao->getOrderDetails($id);
ob_start();
$success_msg = $_SESSION["success_msg"] ?? "";
unset($_SESSION["success_msg"]);
?>
<h2>Chi tiết đơn hàng #<?= $order["order_code"] ?></h2>
<?php if($success_msg): ?>
    <div class="alert alert-success"><?= $success_msg ?></div>
<?php endif; ?>
<div class="card mb-3">
    <div class="card-body">
        <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order["customer_name"]) ?></p>
        <p><strong>SĐT:</strong> <?= htmlspecialchars($order["phone"]) ?></p>
        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order["address"]) ?></p>
        <form method="POST" class="d-flex align-items-center">
            <strong class="me-2">Trạng thái:</strong>
            <select name="status" class="form-select w-auto me-2">
                <option value="0" <?= $order["status"]==0?"selected":"" ?>>Chờ xác nhận</option>
                <option value="1" <?= $order["status"]==1?"selected":"" ?>>Đã xác nhận</option>
                <option value="2" <?= $order["status"]==2?"selected":"" ?>>Đang giao</option>
                <option value="3" <?= $order["status"]==3?"selected":"" ?>>Hoàn thành</option>
                <option value="4" <?= $order["status"]==4?"selected":"" ?>>Đã hủy</option>
            </select>
            <button type="submit" name="btnUpdateStatus" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</div>
<h4>Sản phẩm</h4>
<table class="table table-bordered">
    <thead><tr><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead>
    <tbody>
        <?php foreach ($details as $d): ?>
        <tr>
            <td><?= htmlspecialchars($d["proname"]) ?></td>
            <td><?= $d["quantity"] ?></td>
            <td><?= number_format($d["price"]) ?> đ</td>
            <td><?= number_format($d["subtotal"]) ?> đ</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-end">Tổng tiền:</th>
            <th class="text-danger fs-5"><?= number_format($order["total_amount"]) ?> đ</th>
        </tr>
    </tfoot>
</table>
<a href="index.php" class="btn btn-secondary">Quay lại</a>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>