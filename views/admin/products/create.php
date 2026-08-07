<?php
$pageTitle = "Thêm sản phẩm";
require_once __DIR__ . "/../../../dao/ProductDAO.php";
require_once __DIR__ . "/../../../dao/CategoryDAO.php";
require_once __DIR__ . "/../../../dao/BrandDAO.php";
$dao = new ProductDAO();
$catDao = new CategoryDAO();
$brandDao = new BrandDAO();

$categories = $catDao->getAll();
$brands = $brandDao->getAll();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $proname = trim($_POST["productName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $categoryId = (int)($_POST["categoryId"] ?? 0);
    $brandId = (int)($_POST["brandId"] ?? 0);
    $price = (float)($_POST["price"] ?? 0);
    $discount_price = (float)($_POST["discount_price"] ?? 0);
    $quantity = (int)($_POST["quantity"] ?? 0);

    $fileName = $_FILES["image"]["name"] ?? "";
    $tmpName = $_FILES["image"]["tmp_name"] ?? "";
    $fileSize = $_FILES["image"]["size"] ?? 0;
    $error = $_FILES["image"]["error"] ?? 0;
    $image = "";

    if ($proname == "") $errors[] = "Tên không được trống";
    if ($categoryId == 0) $errors[] = "Chọn danh mục";
    if ($brandId == 0) $errors[] = "Chọn thương hiệu";

    if ($fileName != "") {
        if ($error != UPLOAD_ERR_OK) {
            $errors[] = "Upload hình ảnh không thành công.";
        }
        $allowExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowExtensions)) {
            $errors[] = "Chỉ cho phép file JPG, JPEG, PNG hoặc WEBP.";
        }
        $maxSize = 200 * 1024;
        if ($fileSize > $maxSize) {
            $errors[] = "Kích thước hình ảnh <= 200 KB.";
        }
    }

    if (empty($errors)) {
        if ($fileName != "") {
            $image = time() . "_" . $slug . "." . $extension;
            $uploadPath = __DIR__ . "/../../../uploads/products/" . $image;
            move_uploaded_file($tmpName, $uploadPath);
        }

        $p = new Product($categoryId, $brandId, $proname, $slug, $price, $discount_price, $quantity, "", $image, 1);
        $insertedId = $dao->insert($p);
        if ($insertedId > 0) {
            // Upload gallery
            if (!empty($_FILES["images"]["name"][0])) {
                foreach ($_FILES["images"]["name"] as $key => $gName) {
                    if ($_FILES["images"]["error"][$key] == UPLOAD_ERR_OK) {
                        $gExt = strtolower(pathinfo($gName, PATHINFO_EXTENSION));
                        $gImage = time() . "_" . $key . "_" . $slug . "." . $gExt;
                        $gPath = __DIR__ . "/../../../uploads/products/" . $gImage;
                        if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $gPath)) {
                            $dao->insertImage($insertedId, $gImage);
                        }
                    }
                }
            }
            header("Location: index.php"); exit;
        } else $errors[] = "Thêm thất bại.";
    }
}
ob_start();
?>
<h2>Thêm sản phẩm</h2>
<?php if (!empty($errors)): ?><div class="alert alert-danger"><?= implode("<br>", $errors) ?></div><?php endif; ?>
<form method="POST" enctype="multipart/form-data">
    <div class="mb-3"><label>Tên sản phẩm</label><input type="text" name="productName" class="form-control"></div>
    <div class="mb-3"><label>Slug</label><input type="text" name="slug" class="form-control"></div>
    <div class="mb-3"><label>Danh mục</label>
        <select name="categoryId" class="form-select">
            <option value="0">Chọn...</option>
            <?php foreach($categories as $c): ?><option value="<?= $c->id ?>"><?= $c->name ?></option><?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Thương hiệu</label>
        <select name="brandId" class="form-select">
            <option value="0">Chọn...</option>
            <?php foreach($brands as $b): ?><option value="<?= $b["id"] ?? $b->id ?? $b->id ?>"><?= $b["brandname"] ?? "Brand" ?></option><?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Giá</label><input type="number" name="price" class="form-control"></div>
    <div class="mb-3"><label>Giá giảm</label><input type="number" name="discount_price" class="form-control"></div>
    <div class="mb-3"><label>Số lượng</label><input type="number" name="quantity" class="form-control"></div>
    
    <div class="text-center mb-3" id="preview"></div>
    <div class="mb-3">
        <label class="form-label"> Hình ảnh chính </label>
        <input type="file" id="image" name="image" class="form-control" accept="image/*">
    </div>

    <div class="text-center mb-3" id="preview-gallery"></div>
    <div class="mb-3">
        <label class="form-label"> Thư viện ảnh (Gallery) </label>
        <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Lưu</button>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>