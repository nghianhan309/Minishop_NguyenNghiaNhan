<?php
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
$pageTitle = "Sửa Khách Hàng";
require_once __DIR__ . "/../../../dao/CustomerDAO.php";
$id = $_GET['id'] ?? 0;
$dao = new CustomerDAO();
$b = $dao->findById($id);
if (!$b) die("Not found");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $fullname = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    if ($fullname != '') {
        $b->fullname = $fullname;
        $b->phone = $phone;
        $dao->update($b);
        header("Location: index.php"); exit;
    }
}
ob_start();
?>
<h2>Sửa Khách Hàng</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <div class="mb-3"><label>Họ tên</label><input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($b->fullname) ?>" required></div>
    <div class="mb-3"><label>Số điện thoại</label><input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($b->phone) ?>"></div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Hủy</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>