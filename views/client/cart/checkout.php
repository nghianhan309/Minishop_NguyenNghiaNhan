<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none"><i class="bi bi-house-door-fill"></i> Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>cart" class="text-decoration-none">Giỏ hàng</a></li>
        <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
    </ol>
</nav>

<h2 class="mb-4 fw-bold">Thông tin thanh toán</h2>

<div class="row g-5">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="bi bi-person-lines-fill me-2 text-primary"></i> 1. Thông tin giao hàng</h5>
                <?php 
                    $user = $_SESSION['client_user'] ?? null;
                ?>
                <form action="<?= BASE_URL ?>cart/checkout" method="POST" id="checkoutForm">
                    <div class="form-floating mb-3">
                        <input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Nhập họ và tên đầy đủ" value="<?= $user ? htmlspecialchars($user['fullname']) : '' ?>" required>
                        <label for="customer_name">Họ và tên người nhận <span class="text-danger">*</span></label>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="tel" name="customer_phone" class="form-control" id="customer_phone" placeholder="Ví dụ: 0912345678" value="<?= $user ? htmlspecialchars($user['phone']) : '' ?>" required>
                                <label for="customer_phone">Số điện thoại <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="email" name="customer_email" class="form-control" id="customer_email" placeholder="Để nhận thông báo đơn hàng" value="<?= $user ? htmlspecialchars($user['email']) : '' ?>">
                                <label for="customer_email">Email (Tùy chọn)</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-4">
                        <textarea name="customer_address" class="form-control" id="customer_address" style="height: 100px" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..." required></textarea>
                        <label for="customer_address">Địa chỉ nhận hàng chi tiết <span class="text-danger">*</span></label>
                    </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="bi bi-truck me-2 text-primary"></i> 2. Phương thức giao hàng</h5>
                <div class="form-check p-3 border rounded mb-3 bg-light">
                    <input class="form-check-input ms-1" type="radio" name="shipping_method" id="ship1" value="standard" checked>
                    <label class="form-check-label w-100 ms-3 d-flex justify-content-between" for="ship1">
                        <span>Giao hàng tiêu chuẩn (3-5 ngày)</span>
                        <span class="fw-bold text-success">Miễn phí</span>
                    </label>
                </div>
                <div class="form-check p-3 border rounded mb-3">
                    <input class="form-check-input ms-1" type="radio" name="shipping_method" id="ship2" value="express">
                    <label class="form-check-label w-100 ms-3 d-flex justify-content-between" for="ship2">
                        <span>Giao hàng hỏa tốc (Trong ngày)</span>
                        <span class="fw-bold text-danger">30,000 đ</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="bi bi-credit-card-2-front me-2 text-primary"></i> 3. Phương thức thanh toán</h5>
                <div class="form-check p-3 border rounded mb-3">
                    <input class="form-check-input ms-1" type="radio" name="payment_method" id="pay1" value="COD" checked>
                    <label class="form-check-label w-100 ms-3 d-flex align-items-center" for="pay1">
                        <i class="bi bi-cash-stack fs-4 me-3 text-success"></i>
                        <div>
                            <strong>Thanh toán khi nhận hàng (COD)</strong>
                            <p class="text-muted small mb-0">Khách hàng thanh toán bằng tiền mặt khi nhận hàng.</p>
                        </div>
                    </label>
                </div>
                <div class="form-check p-3 border rounded mb-3">
                    <input class="form-check-input ms-1" type="radio" name="payment_method" id="pay2" value="VNPAY">
                    <label class="form-check-label w-100 ms-3 d-flex align-items-center" for="pay2">
                        <img src="<?= BASE_URL ?>assets/client/images/vnpay-logo.png" onerror="this.src='https://vnpay.vn/s1/statics.vnpay.vn/2023/9/06ncktiwd6dc1694418196384.png'" alt="VNPAY" style="height: 30px; margin-right: 15px;">
                        <div>
                            <strong>Thanh toán qua VNPAY</strong>
                            <p class="text-muted small mb-0">Thanh toán an toàn qua Cổng thanh toán VNPAY bằng thẻ ATM, Visa, MasterCard hoặc QR Code.</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-3"><i class="bi bi-pencil-square me-2 text-primary"></i> Ghi chú đơn hàng</h5>
                <div class="form-floating">
                    <textarea name="order_note" class="form-control" id="order_note" style="height: 80px" placeholder="Ghi chú về thời gian giao hàng, yêu cầu gói quà..."></textarea>
                    <label for="order_note">Ghi chú (Tùy chọn)</label>
                </div>
            </div>
        </div>
        </form>
    </div>

    <div class="col-lg-5">
        <div class="card shadow-sm border-0 bg-light sticky-top" style="top: 90px; z-index: 1;">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold border-bottom pb-3 mb-4">Đơn hàng của bạn (<?= count($cart) ?> sản phẩm)</h5>
                
                <div class="mb-4" style="max-height: 400px; overflow-y: auto;">
                    <?php foreach ($cart as $item): ?>
                    <div class="d-flex align-items-center mb-3">
                        <div class="position-relative me-3">
                            <img src="<?= PRODUCT_IMAGE_URL . ($item['image'] ?: 'nuoc-hoa.png') ?>" alt="<?= htmlspecialchars($item['productname']) ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: contain;">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary border border-light">
                                <?= $item['quantity'] ?>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-truncate" style="max-width: 200px;"><?= htmlspecialchars($item['productname']) ?></h6>
                        </div>
                        <div class="fw-bold ms-3">
                            <?= number_format($item['price'] * $item['quantity']) ?> đ
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-top pt-3 mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tạm tính:</span>
                        <span class="fw-bold"><?= number_format($total) ?> đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Phí vận chuyển:</span>
                        <span class="fw-bold text-success" id="shippingFeeText">Miễn phí</span>
                    </div>
                </div>
                
                <div class="border-top pt-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-5 fw-bold">Tổng cộng:</span>
                        <span class="fs-4 fw-bold text-danger" id="finalTotalText"><?= number_format($total) ?> đ</span>
                    </div>
                </div>

                <button type="button" onclick="document.getElementById('checkoutForm').submit();" class="btn btn-danger btn-lg w-100 fw-bold shadow-sm py-3 mb-2" style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    HOÀN TẤT ĐẶT HÀNG <i class="bi bi-check2-circle ms-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
        const shippingFeeText = document.getElementById('shippingFeeText');
        const finalTotalText = document.getElementById('finalTotalText');
        const baseTotal = <?= $total ?>;
        
        shippingRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                let shippingFee = 0;
                if (this.value === 'express') {
                    shippingFee = 30000;
                    shippingFeeText.textContent = '30,000 đ';
                    shippingFeeText.className = 'fw-bold text-danger';
                } else {
                    shippingFeeText.textContent = 'Miễn phí';
                    shippingFeeText.className = 'fw-bold text-success';
                }
                
                const finalTotal = baseTotal + shippingFee;
                finalTotalText.textContent = new Intl.NumberFormat('vi-VN').format(finalTotal) + ' đ';
            });
        });
    });
</script>
