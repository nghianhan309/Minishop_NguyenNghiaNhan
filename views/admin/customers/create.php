<?php
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
$pageTitle = "Thêm Khách Hàng";
require_once __DIR__ . "/../../../dao/CustomerDAO.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $fullname = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    if ($fullname != '') {
        $dao = new CustomerDAO();
        $b = new Customer($fullname, $phone, null, null);
        $dao->insert($b);
        header("Location: index.php"); exit;
    }
}
ob_start();
?>
<h2>Thêm Khách Hàng</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <div class="mb-3"><label>Họ tên</label><input type="text" name="fullname" class="form-control" required></div>
    <div class="mb-3"><label>Số điện thoại</label><input type="text" name="phone" class="form-control"></div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Hủy</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>