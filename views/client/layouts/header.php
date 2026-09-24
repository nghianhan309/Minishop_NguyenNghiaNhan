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
        
        <div class="collapse navbar-collapse align-items-center" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link active text-nowrap" aria-current="page" href="<?= BASE_URL ?>">Trang chủ</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="<?= BASE_URL ?>products">Sản phẩm</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-nowrap" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0 rounded-3 p-2" aria-labelledby="categoryDropdown" style="min-width: 220px;">
                        <?php foreach ($categories as $category): ?>
                        <li>
                            <a class="dropdown-item rounded py-2 px-3 mb-1 d-flex align-items-center custom-dropdown-item" href="<?= BASE_URL ?>category/<?= $category->slug ?>">
                                <i class="bi bi-grid-fill text-warning me-2 small"></i> 
                                <?= htmlspecialchars($category->name) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>

                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-nowrap" href="#" id="brandDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Thương hiệu
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0 rounded-3 p-2" aria-labelledby="brandDropdown" style="min-width: 220px;">
                        <?php foreach ($brands as $brand): ?>
                        <li>
                            <a class="dropdown-item rounded py-2 px-3 mb-1 d-flex align-items-center custom-dropdown-item" href="<?= BASE_URL ?>brand/<?= $brand->slug ?>">
                                <i class="bi bi-tag-fill text-success me-2 small"></i> 
                                <?= htmlspecialchars($brand->name) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item rounded py-2 px-3 fw-bold text-primary text-center bg-light mt-1 custom-dropdown-item" href="<?= BASE_URL ?>brands">
                                <i class="bi bi-collection-fill me-1"></i> Xem tất cả
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            <form class="d-flex mx-auto" style="min-width: 300px; max-width: 500px; width: 100%;" action="<?= BASE_URL ?>" method="GET">
                <input type="hidden" name="area" value="client">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="search">
                <div class="input-group">
                    <input class="form-control border-warning" type="search" name="q" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" required>
                    <button class="btn btn-warning px-3" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
            
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item ms-3">
                    <?php 
                        $cartCount = 0;
                        if(isset($_SESSION[CART_SESSION_KEY])) {
                            foreach($_SESSION[CART_SESSION_KEY] as $item) {
                                $cartCount += $item['quantity'];
                            }
                        }
                    ?>
                    <a class="nav-link text-white position-relative" href="<?= BASE_URL ?>cart">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span id="cartCount" class="position-absolute top-25 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            <?= $cartCount ?>
                        </span>
                    </a>
                </li>
                <?php if(isset($_SESSION['client_user'])): ?>
                <li class="nav-item ms-3">
                    <a class="nav-link text-white fw-bold text-nowrap d-flex align-items-center" href="<?= BASE_URL ?>profile" title="Hồ sơ cá nhân">
                        <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($_SESSION['client_user']['fullname']) ?>
                    </a>
                </li>
                <li class="nav-item ms-3">
                    <a class="nav-link text-white" href="<?= BASE_URL ?>logout" title="Đăng xuất">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item ms-3">
                    <a class="nav-link text-white" href="<?= BASE_URL ?>login" title="Đăng nhập">
                        Đăng nhập
                    </a>
                </li>
                <li class="nav-item ms-3">
                    <a class="nav-link text-white" href="<?= BASE_URL ?>register" title="Đăng ký">
                        Đăng ký
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
