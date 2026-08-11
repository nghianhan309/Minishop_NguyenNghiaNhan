<?php
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
$pageTitle = "Thêm User";
require_once __DIR__ . "/../../../dao/UserDAO.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    if ($fullname != '') {
        $dao = new UserDAO();
        $b = new User($fullname, $username, null, null, 1, 1);
        $dao->insert($b);
        header("Location: index.php"); exit;
    }
}
ob_start();
?>
<h2>Thêm Người Dùng</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <div class="mb-3"><label>Họ tên</label><input type="text" name="fullname" class="form-control" required></div>
    <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" required></div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Hủy</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>