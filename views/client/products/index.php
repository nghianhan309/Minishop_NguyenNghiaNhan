<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách Sản phẩm</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
    <h2 class="h3 fw-bold text-dark mb-0"><?= $heading ?? "Danh sách sản phẩm" ?></h2>
</div>

<div class="row g-4">
    <?php if (empty($products)): ?>
    <div class="col-12">
        <div class="alert alert-warning shadow-sm border-0 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
            <div>
                <strong>Opps!</strong> Không tìm thấy sản phẩm nào phù hợp với yêu cầu của bạn.
                <br>
                <a href="<?= BASE_URL ?>" class="alert-link">Quay lại trang chủ</a> để tiếp tục mua sắm.
            </div>
        </div>
    </div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
        <div class="col-6 col-md-3">
            <?php require __DIR__ . '/../layouts/product-card.php'; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
