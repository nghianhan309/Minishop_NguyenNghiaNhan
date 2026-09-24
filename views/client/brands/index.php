<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Thương hiệu</li>
    </ol>
</nav>

<!-- Beautiful Hero Section -->
<div class="mb-5 position-relative rounded-4 overflow-hidden shadow-sm" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1615529182904-14819c35db37?q=80&w=2000&auto=format&fit=crop') center/cover; min-height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem;">
    <h2 class="display-5 fw-bold text-white mb-3 text-center" style="letter-spacing: 2px;">THƯƠNG HIỆU ĐẲNG CẤP</h2>
    <p class="fs-5 text-white-50 text-center mb-0" style="max-width: 700px;">Khám phá bộ sưu tập nước hoa đến từ những thương hiệu xa xỉ hàng đầu thế giới</p>
</div>

<div class="row g-4 mb-5">
    <?php foreach ($brands as $brand): ?>
    <div class="col-6 col-md-4 col-lg-3">
        <div class="brand-card h-100 position-relative bg-white rounded-4 overflow-hidden border">
            <a href="<?= BASE_URL ?>brand/<?= $brand->slug ?>" class="text-decoration-none d-block w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center">
                <div class="brand-logo-wrapper mb-2 d-flex align-items-center justify-content-center">
                    <img src="<?= BASE_URL ?>uploads/brands/<?= $brand->image ?: 'default-brand.png' ?>" class="img-fluid brand-logo" alt="<?= htmlspecialchars($brand->name) ?>">
                </div>
                <hr class="w-25 border-secondary my-3 brand-divider">
                <h6 class="fw-bold text-dark text-uppercase mb-0 brand-name text-center" style="letter-spacing: 1.5px; font-size: 0.9rem;">
                    <?= htmlspecialchars($brand->name) ?>
                </h6>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
    .brand-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-color: #e9ecef !important;
    }
    .brand-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #0d6efd !important;
    }
    .brand-logo-wrapper {
        height: 100px;
        width: 100%;
    }
    .brand-logo {
        max-height: 70px;
        max-width: 80%;
        object-fit: contain;
        filter: grayscale(100%) opacity(0.6);
        transition: all 0.5s ease;
    }
    .brand-card:hover .brand-logo {
        filter: grayscale(0%) opacity(1);
        transform: scale(1.15);
    }
    .brand-divider {
        transition: all 0.4s ease;
        opacity: 0.2;
    }
    .brand-card:hover .brand-divider {
        width: 60% !important;
        border-color: #0d6efd !important;
        opacity: 1;
    }
    .brand-name {
        transition: all 0.3s ease;
    }
    .brand-card:hover .brand-name {
        color: #0d6efd !important;
    }
</style>
