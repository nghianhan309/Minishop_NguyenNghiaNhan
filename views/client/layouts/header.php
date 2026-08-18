<?php
use Composers\HeaderComposer;

$headerData = HeaderComposer::compose();
$categories = $headerData['categories'];
$brands = $headerData['brands'];
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 text-warning" href="<?= BASE_URL ?>">
            <i class="bi bi-shop me-2"></i>MiniShop
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= BASE_URL ?>">Trang chủ</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu shadow" aria-labelledby="categoryDropdown">
                        <?php foreach ($categories as $category): ?>
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>category/<?= $category->slug ?>">
                                <?= htmlspecialchars($category->name) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item fw-bold text-primary" href="#">Xem tất cả</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="brandDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Thương hiệu
                    </a>
                    <ul class="dropdown-menu shadow" aria-labelledby="brandDropdown">
                        <?php foreach ($brands as $brand): ?>
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>brand/<?= $brand->slug ?>">
                                <?= htmlspecialchars($brand->name) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item fw-bold text-primary" href="#">Xem tất cả</a></li>
                    </ul>
                </li>
            </ul>
            
            <form class="d-flex w-50" action="<?= BASE_URL ?>" method="GET">
                <input type="hidden" name="area" value="client">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="search">
                <div class="input-group">
                    <input class="form-control border-warning" type="search" name="q" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" required>
                    <button class="btn btn-warning px-3" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
            
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ms-3">
                    <a class="nav-link text-white position-relative" href="#">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span class="position-absolute top-25 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            0
                        </span>
                    </a>
                </li>
                <li class="nav-item ms-3">
                    <a class="nav-link text-white" href="<?= BASE_URL ?>admin">
                        <i class="bi bi-person-circle fs-5"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
