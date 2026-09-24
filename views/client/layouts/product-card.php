<div class="card h-100 shadow-sm border-0 product-card">
    <div class="position-relative">
        <a href="<?= BASE_URL ?>product/<?= $product->slug ?>">
            <img src="<?= PRODUCT_IMAGE_URL . ($product->image ?: 'nuoc-hoa.png') ?>" class="card-img-top p-3 <?= $product->quantity <= 0 ? 'opacity-50' : '' ?>" alt="<?= htmlspecialchars($product->proname) ?>" style="height: 220px; object-fit: contain;">
        </a>
        <?php if ($product->quantity <= 0): ?>
            <span class="badge bg-secondary position-absolute top-50 start-50 translate-middle px-3 py-2 fs-6 shadow">
                HẾT HÀNG
            </span>
        <?php elseif ($product->discount_price < $product->price): ?>
            <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-2 py-1 fs-6">
                Sale <?= round((($product->price - $product->discount_price) / $product->price) * 100) ?>%
            </span>
        <?php endif; ?>
    </div>
    
    <div class="card-body d-flex flex-column">
        <h6 class="card-title text-truncate mb-2">
            <a href="<?= BASE_URL ?>product/<?= $product->slug ?>" class="text-decoration-none text-dark fw-bold">
                <?= htmlspecialchars($product->proname) ?>
            </a>
        </h6>
        
        <div class="mt-auto">
            <div class="d-flex flex-column mb-3">
                <?php if ($product->discount_price < $product->price): ?>
                    <span class="text-danger fw-bold fs-5"><?= number_format($product->discount_price) ?> đ</span>
                    <small class="text-muted text-decoration-line-through"><?= number_format($product->price) ?> đ</small>
                <?php else: ?>
                    <span class="text-danger fw-bold fs-5"><?= number_format($product->price) ?> đ</span>
                    <small class="invisible">0 đ</small>
                <?php endif; ?>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <a href="<?= BASE_URL ?>product/<?= $product->slug ?>" class="btn btn-outline-secondary btn-sm rounded-circle p-2" title="Xem chi tiết" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-eye"></i>
                </a>
                <?php if ($product->quantity > 0): ?>
                    <button type="button" class="btn btn-primary btn-sm btn-buy px-3 btn-add-cart" data-productid="<?= $product->id ?>" title="Mua hàng">
                        <i class="bi bi-cart-plus me-1"></i> Chọn mua
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-secondary btn-sm px-3" disabled style="cursor: not-allowed;">
                        <i class="bi bi-x-circle me-1"></i> Hết hàng
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
