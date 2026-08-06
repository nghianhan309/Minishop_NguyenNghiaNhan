<?php
// Generator part 3
$baseDir = __DIR__ . '/';

$brandDaoCode = '<?php
require_once __DIR__ . "/BaseDAO.php";
class BrandDAO extends BaseDAO {
    public function __construct() { parent::__construct(); }
    public function getTotalCount(): int {
        $result = $this->executeQuery("SELECT COUNT(*) as total FROM brands");
        if ($result && $row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }
    public function getAll(): array {
        $list = [];
        $result = $this->executeQuery("SELECT * FROM brands");
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>';
file_put_contents($baseDir . 'dao/BrandDAO.php', $brandDaoCode);

$orderDaoCode = '<?php
require_once __DIR__ . "/BaseDAO.php";

class OrderDAO extends BaseDAO {
    public function __construct() { parent::__construct(); }

    public function getTotalCount(): int {
        $result = $this->executeQuery("SELECT COUNT(*) as total FROM orders");
        if ($result && $row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }

    public function getNewestOrders(int $limit = 5): array {
        $list = [];
        $sql = "SELECT o.*, c.fullname as customer_name FROM orders o JOIN customers c ON o.customer_id = c.id ORDER BY o.created_at DESC LIMIT ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) $list[] = $row;
        return $list;
    }

    public function getAll($keyword = "", $status = ""): array {
        $list = [];
        $sql = "SELECT o.*, c.fullname as customer_name FROM orders o JOIN customers c ON o.customer_id = c.id WHERE 1=1";
        $types = ""; $params = [];
        if ($keyword !== "") {
            $sql .= " AND (o.order_code LIKE ? OR c.fullname LIKE ?)";
            $types .= "ss";
            $kw = "%".$keyword."%";
            $params[] = $kw; $params[] = $kw;
        }
        if ($status !== "") {
            $sql .= " AND o.status = ?";
            $types .= "i";
            $params[] = (int)$status;
        }
        $sql .= " ORDER BY o.id DESC";

        if ($types !== "") {
            $stmt = $this->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->executeQuery($sql);
        }

        while ($row = $result->fetch_assoc()) $list[] = $row;
        return $list;
    }

    public function findById(int $id) {
        $sql = "SELECT o.*, c.fullname as customer_name, c.phone, c.address FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getOrderDetails(int $orderId): array {
        $list = [];
        $sql = "SELECT od.*, p.proname FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $res = $stmt->get_result();
        while($r = $res->fetch_assoc()) $list[] = $r;
        return $list;
    }

    public function updateStatus(int $orderId, int $status): bool {
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $status, $orderId);
        return $stmt->execute();
    }
}
?>';
file_put_contents($baseDir . 'dao/OrderDAO.php', $orderDaoCode);

$orderIndexCode = '<?php
$pageTitle = "Quản lý đơn hàng";
require_once "../../dao/OrderDAO.php";
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
                if($o["status"]==0) echo "<span class=\'badge bg-warning\'>Chờ xác nhận</span>";
                elseif($o["status"]==1) echo "<span class=\'badge bg-info\'>Đã xác nhận</span>";
                elseif($o["status"]==2) echo "<span class=\'badge bg-primary\'>Đang giao</span>";
                elseif($o["status"]==3) echo "<span class=\'badge bg-success\'>Hoàn thành</span>";
                elseif($o["status"]==4) echo "<span class=\'badge bg-danger\'>Đã hủy</span>";
                ?>
            </td>
            <td>
                <a href="detail.php?id=<?= $o["id"] ?>" class="btn btn-info btn-sm">Chi tiết</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>';
file_put_contents($baseDir . 'views/admin/orders/index.php', $orderIndexCode);

$orderDetailCode = '<?php
$pageTitle = "Chi tiết đơn hàng";
require_once "../../dao/OrderDAO.php";
$dao = new OrderDAO();
$id = $_GET["id"] ?? 0;
$order = $dao->findById($id);
if (!$order) die("Không tìm thấy đơn hàng");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnUpdateStatus"])) {
    $dao->updateStatus($id, (int)$_POST["status"]);
    header("Location: detail.php?id=$id"); exit;
}

$details = $dao->getOrderDetails($id);
ob_start();
?>
<h2>Chi tiết đơn hàng #<?= $order["order_code"] ?></h2>
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
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>';
file_put_contents($baseDir . 'views/admin/orders/detail.php', $orderDetailCode);

echo "Orders generated.";
?>
