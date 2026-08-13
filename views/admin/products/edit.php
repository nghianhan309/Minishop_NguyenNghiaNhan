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
                <a href="/MiniShop_NguyenNghiaNhan/admin/product/edit/<?= $id ?>&del_img=<?= $g["id"] ?>" class="btn btn-sm btn-danger mt-1" onclick="return confirm('Xóa hình này?')">Xóa</a>
            </div>
        <?php endforeach; ?>
        <div id="preview-gallery" class="mt-2"></div>
    </div>
    <div class="mb-3">
        <label class="form-label"> Thêm ảnh Gallery </label>
        <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="/MiniShop_NguyenNghiaNhan/admin/product" class="btn btn-secondary">Quay lại</a>
</form>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>