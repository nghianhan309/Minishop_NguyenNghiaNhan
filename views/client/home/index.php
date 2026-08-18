<!-- Hero Banner -->
<div class="row mb-5">
    <div class="col-12">
        <div class="p-5 text-center bg-dark text-white rounded shadow-sm" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1596462502278-27bfdc403348?q=80&w=2000&auto=format&fit=crop') center/cover;">
            <h1 class="display-4 fw-bold mb-3">Chào mừng đến MiniShop</h1>
            <p class="lead mb-4">Nước hoa chính hãng - Tinh hoa từ những thương hiệu hàng đầu thế giới</p>
            <a href="#san-pham-moi" class="btn btn-warning btn-lg px-4 shadow-sm">Khám phá ngay</a>
        </div>
    </div>
</div>

<!-- Danh mục nổi bật -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
        <h2 class="h3 fw-bold text-dark mb-0">Danh mục nổi bật</h2>
        <a href="<?= BASE_URL ?>category" class="text-decoration-none text-primary">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-4">
        <?php foreach ($categories as $category): ?>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm text-center product-card bg-light">
                <div class="card-body p-4">
                    <div class="mb-3 text-primary">
                        <i class="bi bi-grid-fill fs-1"></i>
                    </div>
                    <h5 class="card-title fw-bold">
                        <a href="<?= BASE_URL ?>category/<?= $category->slug ?>" class="text-decoration-none text-dark stretched-link">
                            <?= htmlspecialchars($category->catename) ?>
                        </a>
                    </h5>
                    <p class="text-muted small mb-0"><?= htmlspecialchars($category->description) ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Sản phẩm giảm giá -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
        <h2 class="h3 fw-bold text-danger mb-0"><i class="bi bi-tags-fill me-2"></i>Sản phẩm Khuyến mãi</h2>
    </div>
    <div class="row g-4">
        <?php foreach ($discountProducts as $product): ?>
        <div class="col-6 col-md-3">
            <?php require __DIR__ . '/../layouts/product-card.php'; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Sản phẩm mới nhất -->
<div class="mb-5" id="san-pham-moi">
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
        <h2 class="h3 fw-bold text-primary mb-0"><i class="bi bi-stars me-2"></i>Sản phẩm Mới nhất</h2>
    </div>
    <div class="row g-4">
        <?php foreach ($newProducts as $product): ?>
        <div class="col-6 col-md-3">
            <?php require __DIR__ . '/../layouts/product-card.php'; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
