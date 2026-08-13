<h2>Chi tiết sản phẩm</h2>
<div class="row">
    <div class="col-md-4">
        <h4>Hình ảnh chính</h4>
        <?php if ($product->image != "") { ?>
            <img src="/MiniShop_NguyenNghiaNhan/uploads/products/<?= $product->image ?>" class="img-thumbnail w-100">
        <?php } else { ?>
            <p class="text-muted">No Image</p>
        <?php } ?>
        
        <h4 class="mt-4">Gallery</h4>
        <?php foreach($gallery as $g): ?>
            <img src="/MiniShop_NguyenNghiaNhan/uploads/products/<?= $g["image"] ?>" class="img-thumbnail m-1" width="100">
        <?php endforeach; ?>
    </div>
    <div class="col-md-8">
        <ul>
            <li>ID: <?= $product->id ?></li>
            <li>Tên sản phẩm: <?= htmlspecialchars($product->proname) ?></li>
            <li>Slug: <?= htmlspecialchars($product->slug) ?></li>
            <li>ID Danh mục: <?= $product->category_id ?></li>
            <li>ID Thương hiệu: <?= $product->brand_id ?></li>
            <li>Giá: <?= number_format($product->price) ?> đ</li>
            <li>Giá giảm: <?= number_format($product->discount_price) ?> đ</li>
            <li>Số lượng: <?= $product->quantity ?></li>
        </ul>
    </div>
</div>
<a href="/MiniShop_NguyenNghiaNhan/admin/product" class="btn btn-secondary mt-3">Quay lại</a>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>