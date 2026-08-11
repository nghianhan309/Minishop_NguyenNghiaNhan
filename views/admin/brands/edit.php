<?php
$pageTitle = "Sửa Thương Hiệu";
require_once __DIR__ . "/../../../dao/BrandDAO.php";
$id = $_GET['id'] ?? 0;
$dao = new BrandDAO();
$b = $dao->findById($id);
if (!$b) die("Not found");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    if ($name != '') {
        $b->name = $name;
        $b->slug = $slug;
        $dao->update($b);
        header("Location: index.php"); exit;
    }
}
ob_start();
?>
<h2>Sửa Thương Hiệu</h2>
<form method="POST">
    <div class="mb-3"><label>Tên thương hiệu</label><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($b->name) ?>" required></div>
    <div class="mb-3"><label>Slug</label><input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($b->slug) ?>"></div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Hủy</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>