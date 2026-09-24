<!-- Hero Banner -->
<div class="mb-5 position-relative" style="margin-top: -1.5rem; margin-left: -1.5rem; margin-right: -1.5rem;">
    <div class="text-center bg-dark text-white shadow-sm" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1615634260167-c8cdede054de?q=80&w=2000&auto=format&fit=crop') center/cover; min-height: 450px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <h1 class="display-3 fw-bold mb-3" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.8); letter-spacing: 2px;">MINISHOP</h1>
        <p class="fs-4 mb-4 fw-light" style="text-shadow: 1px 1px 8px rgba(0,0,0,0.8); max-width: 600px;">Tinh hoa nước hoa chính hãng từ những thương hiệu hàng đầu thế giới</p>
        <a href="#san-pham-moi" class="btn btn-warning btn-lg px-5 py-3 shadow rounded-pill fw-bold text-uppercase" style="letter-spacing: 1px; transition: 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">Khám phá ngay</a>
    </div>
</div>

<!-- Include Slick CSS for Brands -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<style>
    .brand-item { padding: 10px; margin: 0 10px; text-align: center; }
    .brand-item img {
        margin: 0 auto;
        opacity: 0.5;
        transition: 0.3s all;
        height: 100px;
        object-fit: contain;
        filter: grayscale(100%);
    }
    .slick-center .brand-item img, .brand-item:hover img {
        opacity: 1;
        transform: scale(1.1);
        filter: grayscale(0%);
    }
    .slick-prev:before, .slick-next:before {
        color: #0d6efd; /* Bootstrap primary color */
    }
</style>

<!-- Thương hiệu nổi bật (Center Mode) -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
        <h2 class="h3 fw-bold text-dark mb-0">Thương hiệu nổi bật</h2>
    </div>
    
    <div class="center slider mt-4">
        <?php foreach ($brands as $brand): ?>
            <div class="brand-item">
                <a href="<?= BASE_URL ?>brand/<?= $brand->slug ?>">
                    <img src="<?= BASE_URL ?>uploads/brands/<?= $brand->image ?: 'default-brand.png' ?>" class="img-fluid" alt="<?= htmlspecialchars($brand->name) ?>">
                </a>
                <h6 class="text-center mt-3 text-dark fw-bold"><?= htmlspecialchars($brand->name) ?></h6>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Danh mục nổi bật -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
        <h2 class="h3 fw-bold text-dark mb-0">Danh mục nổi bật</h2>
        <a href="<?= BASE_URL ?>categories" class="text-decoration-none text-primary">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="center-category slider mt-4">
        <?php foreach ($categories as $category): ?>
        <div class="px-2">
            <div class="card h-100 border-0 shadow-sm text-center product-card bg-light">
                <div class="card-body p-4 d-flex flex-column align-items-center">
                    <div class="mb-3 text-primary">
                        <i class="bi bi-grid-fill fs-1"></i>
                    </div>
                    <h5 class="card-title fw-bold w-100 text-truncate">
                        <a href="<?= BASE_URL ?>category/<?= $category->slug ?>" class="text-decoration-none text-dark stretched-link" title="<?= htmlspecialchars($category->name) ?>">
                            <?= htmlspecialchars($category->name) ?>
                        </a>
                    </h5>
                    <p class="text-muted small mb-0 w-100" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 40px;"><?= htmlspecialchars($category->description) ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Giới thiệu (Về chúng tôi) -->
<div class="mb-5 bg-white rounded shadow-sm overflow-hidden border">
    <div class="row g-0 align-items-stretch">
        <div class="col-lg-5" style="background: url('https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=1000&auto=format&fit=crop') center/cover; min-height: 300px;">
        </div>
        <div class="col-lg-7 d-flex align-items-center">
            <div class="p-5">
                <h6 class="text-uppercase text-warning fw-bold mb-2" style="letter-spacing: 2px;">Câu chuyện của chúng tôi</h6>
                <h2 class="h1 fw-bold text-dark mb-4" style="line-height: 1.3;">Nghệ thuật của<br>Sự quyến rũ</h2>
                <p class="text-muted mb-4 fs-5" style="line-height: 1.8;">
                    MiniShop tự hào là điểm đến lý tưởng cho những tín đồ đam mê hương thơm. Chúng tôi mang đến những bộ sưu tập nước hoa cao cấp, chính hãng từ các thương hiệu đình đám nhất thế giới, giúp bạn tự tin thể hiện cá tính riêng.
                </p>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-shield-check fs-2 text-primary me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Chính hãng</h6>
                                <small class="text-muted">Cam kết 100%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-truck fs-2 text-success me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Giao hàng</h6>
                                <small class="text-muted">Nhanh chóng & An toàn</small>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>products" class="btn btn-dark btn-lg px-5 py-3 rounded-pill shadow-sm fw-bold transition-all" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    Khám phá ngay <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Sản phẩm giảm giá -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
        <h2 class="h3 fw-bold text-danger mb-0"><i class="bi bi-tags-fill me-2"></i>Sản phẩm Khuyến mãi</h2>
    </div>
    <div class="row g-4" id="discount-list">
        <?php foreach ($discountProducts as $index => $product): ?>
        <div class="col-6 col-md-3 discount-item <?= $index >= 4 ? 'd-none' : '' ?>">
            <?php require __DIR__ . '/../layouts/product-card.php'; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($discountProducts) > 4): ?>
    <div class="text-center mt-4">
        <button type="button" onclick="toggleProducts('discount')" id="btn-discount" class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm fw-bold">
            Xem thêm sản phẩm khuyến mãi <i class="bi bi-chevron-down ms-1"></i>
        </button>
    </div>
    <?php endif; ?>
</div>

<!-- Sản phẩm mới nhất -->
<div class="mb-5" id="san-pham-moi">
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
        <h2 class="h3 fw-bold text-primary mb-0"><i class="bi bi-stars me-2"></i>Sản phẩm Mới nhất</h2>
    </div>
    <div class="row g-4" id="new-list">
        <?php foreach ($newProducts as $index => $product): ?>
        <div class="col-6 col-md-3 new-item <?= $index >= 4 ? 'd-none' : '' ?>">
            <?php require __DIR__ . '/../layouts/product-card.php'; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($newProducts) > 4): ?>
    <div class="text-center mt-4">
        <button type="button" onclick="toggleProducts('new')" id="btn-new" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm fw-bold">
            Xem thêm sản phẩm mới <i class="bi bi-chevron-down ms-1"></i>
        </button>
    </div>
    <?php endif; ?>
</div>

<!-- Tin tức & Bài viết -->
<?php if (!empty($posts)): ?>
<div class="mb-5 mt-5 pt-4 border-top">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h2 class="h3 fw-bold text-dark mb-0"><i class="bi bi-newspaper text-primary me-2"></i>Góc tư vấn & Tin tức</h2>
    </div>
    <div class="row g-4">
        <?php foreach ($posts as $post): ?>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <?php $imgUrl = !empty($post->image) && file_exists(__DIR__ . "/../../../uploads/posts/" . $post->image) ? "/MiniShop_NguyenNghiaNhan/uploads/posts/" . $post->image : "https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=600&auto=format&fit=crop"; ?>
                <img src="<?= $imgUrl ?>" class="card-img-top" alt="<?= htmlspecialchars($post->title) ?>" style="height: 200px; object-fit: cover; transition: 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <div class="card-body p-4 bg-white z-1 position-relative">
                    <div class="small text-muted mb-2"><i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y', strtotime($post->created_at)) ?> &nbsp;&bull;&nbsp; <?= htmlspecialchars($post->category_name) ?></div>
                    <h5 class="card-title fw-bold mb-3"><a href="<?= BASE_URL ?>post/<?= $post->slug ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($post->title) ?></a></h5>
                    <p class="card-text text-muted mb-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($post->summary) ?></p>
                    <a href="<?= BASE_URL ?>post/<?= $post->slug ?>" class="text-primary text-decoration-none fw-bold small">Đọc tiếp <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<script>
function toggleProducts(type) {
    const items = document.querySelectorAll(`.${type}-item.d-none`);
    const btn = document.getElementById(`btn-${type}`);
    const isExpanding = items.length > 0;
    
    if (isExpanding) {
        // Show all
        document.querySelectorAll(`.${type}-item`).forEach(el => el.classList.remove('d-none'));
        btn.innerHTML = `Thu gọn <i class="bi bi-chevron-up ms-1"></i>`;
    } else {
        // Hide after 4th
        const allItems = document.querySelectorAll(`.${type}-item`);
        allItems.forEach((el, index) => {
            if (index >= 4) el.classList.add('d-none');
        });
        const text = type === 'discount' ? 'sản phẩm khuyến mãi' : 'sản phẩm mới';
        btn.innerHTML = `Xem thêm ${text} <i class="bi bi-chevron-down ms-1"></i>`;
        
        // Scroll back up slightly
        document.getElementById(`${type === 'discount' ? 'discount-list' : 'san-pham-moi'}`).scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}
</script>
<!-- JQuery & Slick JS cho Slider -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function(){
        // Thương hiệu
        $('.center').slick({
          centerMode: true,
          centerPadding: '60px',
          slidesToShow: 3,
          responsive: [
            { breakpoint: 768, settings: { arrows: false, centerMode: true, centerPadding: '40px', slidesToShow: 3 } },
            { breakpoint: 480, settings: { arrows: false, centerMode: true, centerPadding: '40px', slidesToShow: 1 } }
          ]
        });
        
        // Danh mục nổi bật
        $('.center-category').slick({
          centerMode: true,
          centerPadding: '60px',
          slidesToShow: 3,
          responsive: [
            { breakpoint: 768, settings: { arrows: false, centerMode: true, centerPadding: '40px', slidesToShow: 3 } },
            { breakpoint: 480, settings: { arrows: false, centerMode: true, centerPadding: '40px', slidesToShow: 1 } }
          ]
        });
    });
</script>
