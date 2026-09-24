<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách Sản phẩm</li>
    </ol>
</nav>

<?php
use DAO\CategoryDAO;
use DAO\BrandDAO;
$allCategories = (new CategoryDAO())->getAll("");
$allBrands = (new BrandDAO())->getAll("");
$currentSort = $_GET['sort'] ?? '';
$currentQ = $_GET['q'] ?? '';
?>

<div class="row">
    <!-- Left Sidebar -->
    <div class="col-lg-3 mb-4 mb-lg-0">
        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0 text-uppercase"><i class="bi bi-grid-fill text-warning me-2"></i> Danh mục</h6>
            </div>
            <div class="list-group list-group-flush border-top">
                <a href="<?= BASE_URL ?>products" class="list-group-item list-group-item-action border-0 py-2 <?= (!isset($_GET['action']) || $_GET['action'] == 'index') && !isset($_GET['q']) ? 'fw-bold text-primary bg-light' : 'text-muted' ?>">
                    <i class="bi bi-chevron-right me-2 small"></i> Tất cả sản phẩm
                </a>
                <?php foreach ($allCategories as $cat): ?>
                <a href="<?= BASE_URL ?>category/<?= $cat->slug ?>" class="list-group-item list-group-item-action border-0 py-2 <?= (isset($_GET['slug']) && $_GET['slug'] == $cat->slug && isset($_GET['action']) && $_GET['action'] == 'category') ? 'fw-bold text-primary bg-light' : 'text-muted' ?>">
                    <i class="bi bi-chevron-right me-2 small"></i> <?= htmlspecialchars($cat->name) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0 text-uppercase"><i class="bi bi-tags-fill text-success me-2"></i> Thương hiệu</h6>
            </div>
            <div class="list-group list-group-flush border-top custom-scrollbar" style="max-height: 350px; overflow-y: auto;">
                <?php foreach ($allBrands as $brand): ?>
                <a href="<?= BASE_URL ?>brand/<?= $brand->slug ?>" class="list-group-item list-group-item-action border-0 py-2 <?= (isset($_GET['slug']) && $_GET['slug'] == $brand->slug && isset($_GET['action']) && $_GET['action'] == 'brand') ? 'fw-bold text-primary bg-light' : 'text-muted' ?>">
                    <i class="bi bi-tag me-2 small"></i> <?= htmlspecialchars($brand->name) ?>
                </a>
                <?php endforeach; ?>
            </div>
            <style>
                .custom-scrollbar::-webkit-scrollbar { width: 4px; }
                .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
                .custom-scrollbar::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
                .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #999; }
            </style>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-lg-9">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 border-bottom pb-3">
            <h2 class="h4 fw-bold text-dark mb-3 mb-md-0"><?= $heading ?? "Danh sách sản phẩm" ?></h2>
            
            <!-- Filters -->
            <form method="GET" action="<?= BASE_URL ?>" class="d-flex gap-2">
                <input type="hidden" name="area" value="client">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="search">
                <div class="input-group shadow-sm rounded-pill overflow-hidden" style="width: 280px; border: 1px solid #dee2e6;">
                    <input type="text" class="form-control border-0 shadow-none px-4" name="q" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($currentQ) ?>">
                    <button class="btn btn-white border-0 text-primary px-3 bg-white" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            <?php if (empty($products)): ?>
            <div class="col-12">
                <div class="alert alert-warning shadow-sm border-0 d-flex align-items-center p-4">
                    <i class="bi bi-search fs-1 me-4 text-warning"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Opps! Không tìm thấy sản phẩm.</h5>
                        <p class="mb-0">Có vẻ như chúng tôi không có sản phẩm nào phù hợp với yêu cầu của bạn lúc này.</p>
                        <a href="<?= BASE_URL ?>products" class="btn btn-sm btn-outline-dark mt-3">Xóa bộ lọc và thử lại</a>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                <div class="col-6 col-md-4">
                    <?php require __DIR__ . '/../layouts/product-card.php'; ?>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
