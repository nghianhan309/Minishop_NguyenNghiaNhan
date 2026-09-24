<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Giỏ hàng của bạn</li>
    </ol>
</nav>

<h2 class="mb-4 fw-bold">Giỏ hàng của bạn</h2>

<?php if (empty($cart)): ?>
    <div class="alert alert-info shadow-sm py-4 text-center">
        <i class="bi bi-cart-x display-1 d-block mb-3 text-secondary"></i>
        <h4 class="alert-heading">Giỏ hàng đang trống!</h4>
        <p>Có vẻ như bạn chưa chọn mua sản phẩm nào.</p>
        <hr>
        <a href="<?= BASE_URL ?>" class="btn btn-primary mt-2 px-4 py-2">
            <i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4">Sản phẩm</th>
                                <th scope="col" class="text-center">Đơn giá</th>
                                <th scope="col" class="text-center" style="width: 150px;">Số lượng</th>
                                <th scope="col" class="text-end">Thành tiền</th>
                                <th scope="col" class="text-center pe-4">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $id => $item): ?>
                            <tr id="cart-item-<?= $item['productid'] ?>">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= PRODUCT_IMAGE_URL . ($item['image'] ?: 'nuoc-hoa.png') ?>" alt="<?= htmlspecialchars($item['productname']) ?>" class="img-thumbnail me-3" style="width: 64px; height: 64px; object-fit: contain;">
                                        <div>
                                            <a href="<?= BASE_URL ?>product/<?= $item['slug'] ?>" class="text-decoration-none text-dark fw-bold mb-0 d-block">
                                                <?= htmlspecialchars($item['productname']) ?>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted"><?= number_format($item['price']) ?> đ</span>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm mx-auto" style="max-width: 120px;">
                                        <button class="btn btn-outline-secondary px-2" type="button" onclick="updateCart(<?= $item['productid'] ?>, -1)"><i class="bi bi-dash"></i></button>
                                        <input type="text" id="quantity-<?= $item['productid'] ?>" class="form-control text-center px-0" value="<?= $item['quantity'] ?>" readonly>
                                        <button class="btn btn-outline-secondary px-2" type="button" onclick="updateCart(<?= $item['productid'] ?>, 1)"><i class="bi bi-plus"></i></button>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-danger" id="item-total-<?= $item['productid'] ?>">
                                    <?= number_format($item['price'] * $item['quantity']) ?> đ
                                </td>
                                <td class="text-center pe-4">
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeCart(<?= $item['productid'] ?>)" title="Xóa">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="<?= BASE_URL ?>" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm
                </a>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold border-bottom pb-3 mb-4">Tóm tắt đơn hàng</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tạm tính:</span>
                        <strong id="cartTotal" class="fs-5 text-danger"><?= number_format($total) ?> đ</strong>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4 pb-3 border-bottom">
                        <span class="text-muted">Vận chuyển:</span>
                        <span>Được tính ở bước thanh toán</span>
                    </div>
                    
                    <a href="<?= BASE_URL ?>cart/checkout" class="btn btn-danger btn-lg w-100 fw-bold shadow-sm">
                        TIẾN HÀNH ĐẶT HÀNG <i class="bi bi-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
