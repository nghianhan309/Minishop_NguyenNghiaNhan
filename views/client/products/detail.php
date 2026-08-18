<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>category/<?= $product->category_slug ?? '' ?>" class="text-decoration-none"><?= htmlspecialchars($product->cateName ?? 'Danh mục') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product->proname) ?></li>
    </ol>
</nav>

<div class="card border-0 shadow-sm mb-5 p-4">
    <div class="row g-5">
        <div class="col-md-5">
            <div class="position-relative">
                <img src="<?= PRODUCT_IMAGE_URL . ($product->image ?: 'nuoc-hoa.png') ?>" class="img-fluid rounded border p-3 w-100" alt="<?= htmlspecialchars($product->proname) ?>" style="object-fit: contain; max-height: 500px;">
                <?php if ($product->discount_price < $product->price): ?>
                    <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2 fs-5 shadow-sm">
                        Giảm <?= round((($product->price - $product->discount_price) / $product->price) * 100) ?>%
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Gallery placeholder -->
            <div class="d-flex gap-2 mt-3 overflow-auto">
                <img src="<?= PRODUCT_IMAGE_URL . ($product->image ?: 'nuoc-hoa.png') ?>" class="img-thumbnail border-primary" style="width: 80px; height: 80px; object-fit: contain; cursor: pointer;">
                <!-- Slick slider can be added here -->
            </div>
        </div>
        
        <div class="col-md-7">
            <h1 class="fw-bold mb-3"><?= htmlspecialchars($product->proname) ?></h1>
            
            <div class="d-flex align-items-center mb-4 text-muted">
                <span class="me-4"><i class="bi bi-tag-fill me-1"></i> Thương hiệu: <a href="<?= BASE_URL ?>brand/<?= $product->brand_slug ?? '' ?>" class="text-decoration-none text-primary fw-bold"><?= htmlspecialchars($product->brandName ?? '') ?></a></span>
                <span><i class="bi bi-box-seam-fill me-1"></i> Tình trạng: 
                    <?php if($product->quantity > 0): ?>
                        <span class="text-success fw-bold">Còn hàng (<?= $product->quantity ?>)</span>
                    <?php else: ?>
                        <span class="text-danger fw-bold">Hết hàng</span>
                    <?php endif; ?>
                </span>
            </div>
            
            <div class="mb-4 bg-light p-4 rounded border-start border-warning border-4">
                <?php if ($product->discount_price < $product->price): ?>
                    <div class="fs-5 text-muted text-decoration-line-through mb-1"><?= number_format($product->price) ?> đ</div>
                    <div class="display-5 fw-bold text-danger"><?= number_format($product->discount_price) ?> đ</div>
                <?php else: ?>
                    <div class="display-5 fw-bold text-danger"><?= number_format($product->price) ?> đ</div>
                <?php endif; ?>
            </div>
            
            <div class="mb-4">
                <h5 class="fw-bold">Mô tả sản phẩm:</h5>
                <p class="text-muted lh-lg"><?= nl2br(htmlspecialchars($product->description)) ?></p>
            </div>
            
            <hr class="mb-4">
            
            <div class="d-flex gap-3 align-items-center mb-4">
                <div class="input-group" style="width: 130px;">
                    <button class="btn btn-outline-secondary" type="button"><i class="bi bi-dash"></i></button>
                    <input type="text" class="form-control text-center" value="1">
                    <button class="btn btn-outline-secondary" type="button"><i class="bi bi-plus"></i></button>
                </div>
                <button type="button" class="btn btn-danger btn-lg flex-grow-1 px-4 fw-bold">
                    <i class="bi bi-bag-check-fill me-2"></i> THÊM VÀO GIỎ HÀNG
                </button>
            </div>
            <button type="button" class="btn btn-outline-primary btn-lg w-100 fw-bold">
                MUA NGAY (Giao hàng tận nơi hoặc nhận tại cửa hàng)
            </button>
        </div>
    </div>
</div>
