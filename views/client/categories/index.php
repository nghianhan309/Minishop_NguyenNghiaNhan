<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh mục sản phẩm</li>
    </ol>
</nav>

<div class="mb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark display-5 mb-3">Tất cả Danh mục</h2>
        <p class="text-muted fs-5">Khám phá các dòng nước hoa cao cấp được phân loại dành riêng cho bạn</p>
    </div>

    <div class="row g-4">
        <?php foreach ($categories as $category): ?>
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm text-center product-card bg-light rounded-4 overflow-hidden" style="transition: all 0.3s ease;">
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-3 text-warning">
                        <i class="bi bi-grid-fill" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold w-100 text-truncate mb-3">
                        <a href="<?= BASE_URL ?>category/<?= $category->slug ?>" class="text-decoration-none text-dark stretched-link" title="<?= htmlspecialchars($category->name) ?>">
                            <?= htmlspecialchars($category->name) ?>
                        </a>
                    </h5>
                    <p class="text-muted small mb-0 w-100" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; min-height: 60px;">
                        <?= htmlspecialchars($category->description ?: 'Danh mục các sản phẩm ' . $category->name . ' cao cấp, mang lại trải nghiệm tuyệt vời cho bạn.') ?>
                    </p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<style>
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
