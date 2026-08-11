<?php
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
$pageTitle = "Thêm Thương Hiệu";
require_once __DIR__ . "/../../../dao/BrandDAO.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    if ($name != '') {
        $dao = new BrandDAO();
        $b = new Brand($name, $slug, null, null, 1);
        $dao->insert($b);
        header("Location: index.php"); exit;
    }
}
ob_start();
?>
<h2>Thêm Thương Hiệu</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <div class="mb-3"><label>Tên thương hiệu</label><input type="text" name="name" class="form-control" required></div>
    <div class="mb-3"><label>Slug</label><input type="text" name="slug" class="form-control"></div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Hủy</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>