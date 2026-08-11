<?php
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
$pageTitle = "Cập nhật danh mục";
require_once __DIR__ . "/../../../dao/CategoryDAO.php";
$dao = new CategoryDAO();
$id = $_GET["id"] ?? 0;
$category = $dao->findById($id);

if (!$category) die("Không tìm thấy danh mục");

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $cateName = trim($_POST["cateName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? 1;

    if ($cateName == "") $errors[] = "Tên không để trống.";
    if ($slug == "") $errors[] = "Slug không để trống.";

    if (empty($errors)) {
        $category->name = $cateName;
        $category->slug = $slug;
        $category->description = $description;
        $category->status = $status;
        if ($dao->update($category)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại.";
        }
    }
}
ob_start();
?>
<h2>Cập nhật danh mục</h2>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
<?php endif; ?>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <input type="hidden" name="categoryId" value="<?= $category->id ?>">
    <div class="mb-3">
        <label>Tên danh mục</label>
        <input type="text" name="cateName" class="form-control" value="<?= htmlspecialchars($category->name) ?>">
    </div>
    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($category->slug) ?>">
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($category->description) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Trạng thái</label>
        <input type="radio" name="status" value="1" <?= $category->status==1 ? "checked" : "" ?>> Hiển thị
        <input type="radio" name="status" value="0" <?= $category->status==0 ? "checked" : "" ?>> Ẩn
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</form>
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>
