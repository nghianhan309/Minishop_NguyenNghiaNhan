<h2>Thêm sản phẩm</h2>
<?php if (!empty($errors)): ?><div class="alert alert-danger"><?= implode("<br>", $errors) ?></div><?php endif; ?>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
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
            <?php foreach($brands as $b): 
                $bid = is_object($b) ? $b->id : ($b["id"] ?? 0);
                $bname = is_object($b) ? $b->name : ($b["brandname"] ?? "Brand");
            ?>
                <option value="<?= $bid ?>"><?= $bname ?></option>
            <?php endforeach; ?>
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