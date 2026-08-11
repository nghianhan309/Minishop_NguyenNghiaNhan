<?php
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
$pageTitle = "Thêm danh mục";
require_once __DIR__ . "/../../../dao/CategoryDAO.php";
$dao = new CategoryDAO();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $cateName = trim($_POST["cateName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? 1;

    if ($cateName == "") $errors[] = "Tên danh mục không được để trống.";
    if ($slug == "") $errors[] = "Slug không được để trống.";

    if (empty($errors)) {
        $cat = new Category($cateName, $slug, null, $description, $status);
        if ($dao->insert($cat)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Thêm thất bại.";
        }
    }
}
ob_start();
?>
<h2>Thêm danh mục</h2>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
<?php endif; ?>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <div class="mb-3">
        <label>Tên danh mục</label>
        <input type="text" name="cateName" class="form-control" value="<?= htmlspecialchars($_POST["cateName"] ?? "") ?>">
    </div>
    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($_POST["slug"] ?? "") ?>">
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($_POST["description"] ?? "") ?></textarea>
    </div>
    <div class="mb-3">
        <label>Trạng thái</label>
        <input type="radio" name="status" value="1" checked> Hiển thị
        <input type="radio" name="status" value="0"> Ẩn
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>
