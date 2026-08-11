<?php
require_once __DIR__ . '/../../../middleware/RoleMiddleware.php';
RoleMiddleware::checkAdmin();
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
$pageTitle = "Sửa User";
require_once __DIR__ . "/../../../dao/UserDAO.php";
$id = $_GET['id'] ?? 0;
$dao = new UserDAO();
$b = $dao->findById($id);
if (!$b) die("Not found");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    if ($fullname != '') {
        $b->fullname = $fullname;
        $b->username = $username;
        $dao->update($b);
        header("Location: index.php"); exit;
    }
}
ob_start();
?>
<h2>Sửa Người Dùng</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <div class="mb-3"><label>Họ tên</label><input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($b->fullname) ?>" required></div>
    <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" value="<?= htmlspecialchars($b->username) ?>" required></div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Hủy</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>