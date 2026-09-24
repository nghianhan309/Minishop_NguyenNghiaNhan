<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-3"><i class="bi bi-bar-chart-line-fill text-primary me-2"></i> Báo cáo tổng quan</h2>
            <p class="text-muted">Xem thống kê doanh thu và hoạt động kinh doanh của MiniShop.</p>
        </div>
    </div>

    <!-- Metrics row -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Tổng Doanh Thu</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= number_format($overview['total_revenue']) ?> ₫</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-cash-stack text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success small fw-bold"><i class="bi bi-arrow-up-short"></i> Các đơn đã hoàn tất</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Tổng Đơn Hàng</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= number_format($overview['total_orders']) ?></h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-cart-check text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Tất cả trạng thái</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Khách Hàng</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= number_format($overview['total_customers']) ?></h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-people text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Khách hàng đã đặt mua</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">Sản Phẩm</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= number_format($overview['total_products']) ?></h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-box-seam text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Đang bán trên cửa hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart & Top Products -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold">Biểu đồ doanh thu năm nay</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="revenueChart" height="120"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold">Top 5 Sản Phẩm Bán Chạy</h5>
                </div>
                <div class="card-body p-4">
                    <?php if (empty($topProducts)): ?>
                        <p class="text-muted text-center py-4">Chưa có dữ liệu bán hàng.</p>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($topProducts as $idx => $p): ?>
                                <div class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                    <h4 class="text-muted mb-0 me-3 fw-bold">#<?= $idx + 1 ?></h4>
                                    <img src="<?= PRODUCT_IMAGE_URL . ($p['image'] ?: 'nuoc-hoa.png') ?>" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-truncate" style="max-width: 150px;" title="<?= htmlspecialchars($p['proname']) ?>"><?= htmlspecialchars($p['proname']) ?></h6>
                                        <small class="text-muted">Đã bán: <span class="fw-bold text-success"><?= $p['total_sold'] ?></span> chai</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Gradient for line chart
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(13, 110, 253, 0.5)'); // primary color with opacity
        gradient.addColorStop(1, 'rgba(13, 110, 253, 0.0)');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($months) ?>,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: <?= json_encode($revenueData) ?>,
                    borderColor: '#0d6efd',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#0d6efd',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#e9ecef', drawBorder: false },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return (value / 1000000) + ' Tr';
                                return value;
                            }
                        }
                    },
                    x: { grid: { display: false, drawBorder: false } }
                },
                interaction: { intersect: false, mode: 'index' },
            }
        });
    });
</script>
<style>
    .hover-bg-light:hover { background-color: #f8f9fa; }
</style>
