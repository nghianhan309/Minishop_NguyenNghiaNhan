<?php
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
$pageTitle = "Cập nhật sản phẩm";
require_once __DIR__ . "/../../../dao/ProductDAO.php";
require_once __DIR__ . "/../../../dao/CategoryDAO.php";
require_once __DIR__ . "/../../../dao/BrandDAO.php";
$dao = new ProductDAO();
$catDao = new CategoryDAO();
$brandDao = new BrandDAO();

$id = $_GET["id"] ?? 0;
$product = $dao->findById($id);
if (!$product) die("Không tìm thấy sản phẩm");

if (isset($_GET["del_img"])) {
    $imgId = (int)$_GET["del_img"];
    $dao->deleteImage($imgId);
    header("Location: edit.php?id=$id"); exit;
}

$categories = $catDao->getAll();
$brands = $brandDao->getAll();
$gallery = $dao->getImagesByProductId($id);
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
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
    $image = $product->image;

    if ($proname == "") $errors[] = "Tên không được trống";
    if ($categoryId == 0) $errors[] = "Chọn danh mục";

    if ($fileName != "") {
        if ($error != UPLOAD_ERR_OK) $errors[] = "Upload hình ảnh không thành công.";
        $allowExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowExtensions)) $errors[] = "Chỉ cho phép file JPG, JPEG, PNG hoặc WEBP.";
        $maxSize = 200 * 1024;
        if ($fileSize > $maxSize) $errors[] = "Kích thước hình ảnh <= 200 KB.";
    }

    if (empty($errors)) {
        if ($fileName != "") {
            $image = time() . "_" . $slug . "." . $extension;
            $uploadPath = __DIR__ . "/../../../uploads/products/" . $image;
            if (!empty($product->image)) {
                $oldImage = __DIR__ . "/../../../uploads/products/" . $product->image;
                if (file_exists($oldImage)) unlink($oldImage);
            }
            move_uploaded_file($tmpName, $uploadPath);
        }

        $product->proname = $proname;
        $product->slug = $slug;
        $product->category_id = $categoryId;
        $product->brand_id = $brandId;
        $product->price = $price;
        $product->discount_price = $discount_price;
        $product->quantity = $quantity;
        $product->image = $image;
        
        if ($dao->update($product)) {
            if (!empty($_FILES["images"]["name"][0])) {
                foreach ($_FILES["images"]["name"] as $key => $gName) {
                    if ($_FILES["images"]["error"][$key] == UPLOAD_ERR_OK) {
                        $gExt = strtolower(pathinfo($gName, PATHINFO_EXTENSION));
                        $gImage = time() . "_" . $key . "_" . $slug . "." . $gExt;
                        $gPath = __DIR__ . "/../../../uploads/products/" . $gImage;
                        if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $gPath)) {
                            $dao->insertImage($id, $gImage);
                        }
                    }
                }
            }
            header("Location: index.php"); exit;
        } else $errors[] = "Cập nhật thất bại.";
    }
}
ob_start();
?>
<h2>Cập nhật sản phẩm</h2>
<?php if (!empty($errors)): ?><div class="alert alert-danger"><?= implode("<br>", $errors) ?></div><?php endif; ?>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    <div class="mb-3"><label>Tên sản phẩm</label><input type="text" name="productName" class="form-control" value="<?= htmlspecialchars($product->proname) ?>"></div>
    <div class="mb-3"><label>Slug</label><input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($product->slug) ?>"></div>
    <div class="mb-3"><label>Danh mục</label>
        <select name="categoryId" class="form-select">
            <option value="0">Chọn...</option>
            <?php foreach($categories as $c): ?>
                <option value="<?= $c->id ?>" <?= $c->id == $product->category_id ? "selected" : "" ?>><?= $c->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Thương hiệu</label>
        <select name="brandId" class="form-select">
            <option value="0">Chọn...</option>
            <?php foreach($brands as $b): 
                $bid = is_object($b) ? $b->id : ($b["id"] ?? 0);
                $bname = is_object($b) ? $b->name : ($b["brandname"] ?? "Brand");
            ?>
                <option value="<?= $bid ?>" <?= $bid == $product->brand_id ? "selected" : "" ?>><?= $bname ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3"><label>Giá</label><input type="number" name="price" class="form-control" value="<?= $product->price ?>"></div>
    <div class="mb-3"><label>Giá giảm</label><input type="number" name="discount_price" class="form-control" value="<?= $product->discount_price ?>"></div>
    <div class="mb-3"><label>Số lượng</label><input type="number" name="quantity" class="form-control" value="<?= $product->quantity ?>"></div>
    
    <div class="mb-3">
        <label>Hình ảnh hiện tại</label><br>
        <?php if($product->image): ?>
            <img src="/MiniShop_NguyenNghiaNhan/uploads/products/<?= $product->image ?>" class="img-thumbnail" width="150" id="preview">
        <?php else: ?>
            <div id="preview"></div>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label"> Hình ảnh chính </label>
        <input type="file" id="image" name="image" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <label>Thư viện ảnh (Gallery) hiện tại</label><br>
        <?php foreach($gallery as $g): ?>
            <div class="d-inline-block text-center m-1">
                <img src="/MiniShop_NguyenNghiaNhan/uploads/products/<?= $g["image"] ?>" class="img-thumbnail" width="100"><br>
                <a href="edit.php?id=<?= $id ?>&del_img=<?= $g["id"] ?>" class="btn btn-sm btn-danger mt-1" onclick="return confirm('Xóa hình này?')">Xóa</a>
            </div>
        <?php endforeach; ?>
        <div id="preview-gallery" class="mt-2"></div>
    </div>
    <div class="mb-3">
        <label class="form-label"> Thêm ảnh Gallery </label>
        <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>