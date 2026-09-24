<div class="row justify-content-center my-5">
    <div class="col-md-8 text-center">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-5">
                <div class="mb-4">
                    <div class="d-inline-block bg-success bg-opacity-10 p-4 rounded-circle mb-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h1 class="fw-bold text-success mb-3">Đặt Hàng Thành Công!</h1>
                    <p class="fs-5 text-muted">Cảm ơn bạn đã tin tưởng và mua sắm tại <strong>MiniShop</strong>.</p>
                </div>

                <div class="bg-light rounded-3 p-4 mb-4 text-start d-inline-block text-center w-100" style="max-width: 400px;">
                    <p class="mb-2 text-muted">Mã đơn hàng của bạn:</p>
                    <h3 class="fw-bold text-dark mb-0">#<?= htmlspecialchars($orderCode) ?></h3>
                </div>

                <p class="text-muted mb-5 px-md-5">
                    Chúng tôi sẽ sớm liên hệ với bạn để xác nhận đơn hàng và tiến hành giao hàng. 
                    Thông tin chi tiết về đơn hàng đã được gửi vào email (nếu có).
                </p>

                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="<?= BASE_URL ?>" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm fw-bold">
                        <i class="bi bi-house-door me-2"></i> Trở về Trang chủ
                    </a>
                    <a href="<?= BASE_URL ?>category" class="btn btn-outline-secondary btn-lg px-4 rounded-pill fw-bold">
                        Tiếp tục mua sắm <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="card-footer bg-light border-0 py-3 text-muted small">
                Nếu bạn cần hỗ trợ, vui lòng gọi Hotline: <strong class="text-dark">0123 456 789</strong>
            </div>
        </div>
    </div>
</div>
