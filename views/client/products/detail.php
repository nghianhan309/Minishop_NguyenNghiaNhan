<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none"><i
                    class="bi bi-house-door-fill"></i> Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>category/<?= $product->category_slug ?? '' ?>"
                class="text-decoration-none"><?= htmlspecialchars($product->cateName ?? 'Danh mục') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product->proname) ?></li>
    </ol>
</nav>

<div class="card border-0 shadow-sm mb-5 p-4">
    <div class="row g-5">
        <div class="col-md-5">
            <div class="position-relative" id="product-image-container">
                <button
                    class="btn btn-light position-absolute top-50 start-0 translate-middle-y ms-2 rounded-circle shadow d-flex align-items-center justify-content-center"
                    onclick="prevImage()"
                    style="z-index: 10; width: 40px; height: 40px; padding: 0; opacity: 0.9; border: 1px solid #ddd;">
                    <i class="bi bi-chevron-left fs-5"></i>
                </button>

                <img src="<?= PRODUCT_IMAGE_URL . ($product->image ?: 'nuoc-hoa.png') ?>" id="main-product-image"
                    class="img-fluid rounded border p-3 w-100" alt="<?= htmlspecialchars($product->proname) ?>"
                    style="object-fit: contain; max-height: 500px; transition: 0.3s;">

                <button
                    class="btn btn-light position-absolute top-50 end-0 translate-middle-y me-2 rounded-circle shadow d-flex align-items-center justify-content-center"
                    onclick="nextImage()"
                    style="z-index: 10; width: 40px; height: 40px; padding: 0; opacity: 0.9; border: 1px solid #ddd;">
                    <i class="bi bi-chevron-right fs-5"></i>
                </button>

                <?php if ($product->discount_price < $product->price): ?>
                    <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2 fs-5 shadow-sm">
                        Giảm <?= round((($product->price - $product->discount_price) / $product->price) * 100) ?>%
                    </span>
                <?php endif; ?>
            </div>

            <!-- Gallery placeholder -->
            <div class="d-flex gap-2 mt-3 overflow-auto" id="product-gallery">
                <img src="<?= PRODUCT_IMAGE_URL . ($product->image ?: 'nuoc-hoa.png') ?>"
                    class="img-thumbnail border-primary gallery-thumb active-thumb"
                    style="width: 80px; height: 80px; object-fit: contain; cursor: pointer;"
                    onclick="changeMainImage(this.src, 0)">

                <?php if (!empty($gallery)): ?>
                    <?php $gIndex = 1;
                    foreach ($gallery as $g): ?>
                        <img src="<?= PRODUCT_IMAGE_URL . $g['image'] ?>" class="img-thumbnail gallery-thumb"
                            style="width: 80px; height: 80px; object-fit: contain; cursor: pointer;"
                            onclick="changeMainImage(this.src, <?= $gIndex++ ?>)">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <script>
                let currentImageIndex = 0;
                const galleryImages = [
                    '<?= PRODUCT_IMAGE_URL . ($product->image ?: 'nuoc-hoa.png') ?>',
                    <?php if (!empty($gallery)): ?>
                                <?php foreach ($gallery as $g): ?>
                                            '<?= PRODUCT_IMAGE_URL . $g['image'] ?>',
                        <?php endforeach; ?>
                    <?php endif; ?>
                ];

                function updateThumbnails() {
                    document.querySelectorAll('.gallery-thumb').forEach((el, idx) => {
                        if (idx === currentImageIndex) {
                            el.classList.add('border-primary', 'active-thumb');
                        } else {
                            el.classList.remove('border-primary', 'active-thumb');
                        }
                    });
                }

                function changeMainImage(src, index) {
                    document.getElementById('main-product-image').src = src;
                    currentImageIndex = index;
                    updateThumbnails();
                }

                function prevImage() {
                    if (galleryImages.length <= 1) return;
                    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
                    document.getElementById('main-product-image').src = galleryImages[currentImageIndex];
                    updateThumbnails();
                }

                function nextImage() {
                    if (galleryImages.length <= 1) return;
                    currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
                    document.getElementById('main-product-image').src = galleryImages[currentImageIndex];
                    updateThumbnails();
                }
            </script>
        </div>

        <div class="col-md-7">
            <h1 class="fw-bold mb-3"><?= htmlspecialchars($product->proname) ?></h1>

            <div class="d-flex align-items-center mb-4 text-muted">
                <span class="me-4"><i class="bi bi-tag-fill me-1"></i> Thương hiệu: <a
                        href="<?= BASE_URL ?>brand/<?= $product->brand_slug ?? '' ?>"
                        class="text-decoration-none text-primary fw-bold"><?= htmlspecialchars($product->brandName ?? '') ?></a></span>
                <span><i class="bi bi-box-seam-fill me-1"></i> Tình trạng:
                    <?php if ($product->quantity > 0): ?>
                        <span class="text-success fw-bold">Còn hàng (<?= $product->quantity ?>)</span>
                    <?php else: ?>
                        <span class="text-danger fw-bold">Hết hàng</span>
                    <?php endif; ?>
                </span>
            </div>

            <div class="mb-4 bg-light p-4 rounded border-start border-warning border-4">
                <?php if ($product->discount_price < $product->price): ?>
                    <div class="fs-5 text-muted text-decoration-line-through mb-1"><?= number_format($product->price) ?> đ
                    </div>
                    <div class="display-5 fw-bold text-danger"><?= number_format($product->discount_price) ?> đ</div>
                <?php else: ?>
                    <div class="display-5 fw-bold text-danger"><?= number_format($product->price) ?> đ</div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold text-uppercase mb-3">Thông tin sản phẩm</h6>
                <div class="row text-muted" style="font-size: 0.95rem;">
                    <div class="col-6 mb-2"><strong>Nhãn hiệu:</strong> <span
                            class="text-dark"><?= htmlspecialchars($product->brandName ?? 'Đang cập nhật') ?></span>
                    </div>
                    <div class="col-6 mb-2"><strong>Giới tính:</strong> <span
                            class="text-dark"><?= strpos(strtolower($product->cateName ?? ''), 'nam') !== false ? 'Nam' : (strpos(strtolower($product->cateName ?? ''), 'nữ') !== false ? 'Nữ' : 'Unisex') ?></span>
                    </div>
                    <div class="col-6 mb-2"><strong>Xuất xứ:</strong> <span class="text-dark">Pháp (France)</span></div>
                    <div class="col-6 mb-2"><strong>Phát hành:</strong> <span class="text-dark">2023</span></div>
                    <div class="col-6 mb-2"><strong>Nồng độ:</strong> <span class="text-dark">Eau de Parfum (EDP)</span>
                    </div>
                    <div class="col-6 mb-2"><strong>Nhóm hương:</strong> <span class="text-dark">Hương gỗ phương
                            Đông</span></div>
                    <div class="col-12 mt-1"><strong>Phong cách:</strong> <span class="text-dark">Sang trọng, Cuốn hút,
                            Tinh tế</span></div>
                </div>
            </div>

            <hr class="mb-4">

            <?php if ($product->quantity > 0): ?>
                <div class="d-flex gap-3 align-items-center mb-4">
                    <div class="input-group" style="width: 130px;">
                        <button class="btn btn-outline-secondary" type="button" id="btn-qty-minus"><i
                                class="bi bi-dash"></i></button>
                        <input type="text" class="form-control text-center" value="1" id="qty-detail" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="btn-qty-plus"><i
                                class="bi bi-plus"></i></button>
                    </div>
                    <button type="button" class="btn btn-danger btn-lg flex-grow-1 px-4 fw-bold btn-add-cart"
                        data-productid="<?= $product->id ?>">
                        <i class="bi bi-bag-check-fill me-2"></i> THÊM VÀO GIỎ HÀNG
                    </button>
                </div>
            <?php else: ?>
                <div class="d-flex gap-3 align-items-center mb-4">
                    <button type="button" class="btn btn-secondary btn-lg flex-grow-1 px-4 fw-bold" disabled
                        style="cursor: not-allowed; opacity: 0.7;">
                        <i class="bi bi-x-circle-fill me-2"></i> SẢN PHẨM TẠM HẾT HÀNG
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4 p-4">
    <h4 class="fw-bold mb-4 border-bottom pb-3"><i class="bi bi-info-circle-fill text-primary me-2"></i>Chi tiết sản
        phẩm</h4>
    <div class="product-description-content lh-lg" style="color: #444;">
        <!-- Đây là nội dung từ Summernote, không được dùng htmlspecialchars -->
        <?= $product->description ?>
    </div>
</div>

<style>
    /* Chỉnh lại CSS cho nội dung Summernote hiển thị đẹp hơn hehe */
    .product-description-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .product-description-content h1,
    .product-description-content h2,
    .product-description-content h3 {
        margin-top: 20px;
        font-weight: bold;
    }
</style>