<?php
require_once __DIR__ . "/../../dao/CategoryDAO.php";
require_once __DIR__ . "/../../dao/BrandDAO.php";
require_once __DIR__ . "/../../dao/ProductDAO.php";
require_once __DIR__ . "/../../dao/CustomerDAO.php";
require_once __DIR__ . "/../../dao/OrderDAO.php";

$categoryDAO = new CategoryDAO();
$brandDAO = new BrandDAO();
$productDAO = new ProductDAO();
$customerDAO = new CustomerDAO();
$orderDAO = new OrderDAO();

$totalCategories = $categoryDAO->getTotalCount();
$totalBrands = $brandDAO->getTotalCount();
$totalProducts = $productDAO->getTotalCount();
$totalCustomers = $customerDAO->getTotalCount();
$totalOrders = $orderDAO->getTotalCount();

$newestProducts = $productDAO->getNewestProducts(5);
$newestOrders = $orderDAO->getNewestOrders(5);

$pageTitle = "Dashboard";
ob_start();
?>
<h2 class="mb-4">Dashboard</h2>
<div class="alert alert-success">
    Chào mừng bạn đến với hệ thống quản trị Mini Shop.
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white text-center border-0 shadow-sm" style="background-color: #4e73df;">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-list-task"></i> Danh mục</h5>
                <p class="card-text fs-4"><?= $totalCategories ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white text-center border-0 shadow-sm" style="background-color: #1cc88a;">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-tags"></i> Thương hiệu</h5>
                <p class="card-text fs-4"><?= $totalBrands ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white text-center border-0 shadow-sm" style="background-color: #f6c23e;">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-box"></i> Sản phẩm</h5>
                <p class="card-text fs-4"><?= $totalProducts ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white text-center border-0 shadow-sm" style="background-color: #36b9cc;">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Khách hàng</h5>
                <p class="card-text fs-4"><?= $totalCustomers ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white text-center border-0 shadow-sm" style="background-color: #e74a3b;">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-cart"></i> Đơn hàng</h5>
                <p class="card-text fs-4"><?= $totalOrders ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h4 class="mb-3">5 Sản phẩm mới nhất</h4>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($newestProducts as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['proname']) ?></td>
                    <td><?= number_format($p['price'], 0, ',', '.') ?> đ</td>
                    <td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h4 class="mb-3">5 Đơn hàng mới nhất</h4>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Mã Đơn</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($newestOrders as $o): ?>
                <tr>
                    <td><?= htmlspecialchars($o['order_code']) ?></td>
                    <td><?= htmlspecialchars($o['customer_name']) ?></td>
                    <td><?= number_format($o['total_amount'], 0, ',', '.') ?> đ</td>
                    <td><?= date('d/m/Y', strtotime($o['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$content = ob_get_clean();
include "layouts/master.php";
?>
