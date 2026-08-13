<h2>Chi tiết sản phẩm</h2>
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center">
                <h5 class="card-title text-muted mb-3">Hình ảnh chính</h5>
                <?php if ($product->image != "") { ?>
                    <img src="/MiniShop_NguyenNghiaNhan/uploads/products/<?= $product->image ?>" class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: cover;">
                <?php } else { ?>
                    <div class="p-5 bg-light rounded text-muted"><i class="bi bi-image" style="font-size: 3rem;"></i><br>Không có hình ảnh</div>
                <?php } ?>
            </div>
        </div>
        
        <?php if (!empty($gallery)): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title text-muted mb-3">Thư viện ảnh</h5>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach($gallery as $g): ?>
                        <img src="/MiniShop_NguyenNghiaNhan/uploads/products/<?= $g["image"] ?>" class="img-thumbnail rounded shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="card-title text-primary fw-bold mb-4"><?= htmlspecialchars($product->proname) ?></h3>
                
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 30%;" class="text-muted">Mã sản phẩm (ID)</th>
                            <td class="fw-bold">#<?= $product->id ?></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Đường dẫn (Slug)</th>
                            <td><code><?= htmlspecialchars($product->slug) ?></code></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Danh mục</th>
                            <td><span class="badge bg-info text-dark px-3 py-2"><?= htmlspecialchars($product->cateName ?? "ID: ".$product->category_id) ?></span></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Thương hiệu</th>
                            <td><span class="badge bg-secondary px-3 py-2"><?= htmlspecialchars($product->brandName ?? "ID: ".$product->brand_id) ?></span></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Giá gốc</th>
                            <td><span class="text-decoration-line-through text-muted"><?= number_format($product->price) ?> đ</span></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Giá khuyến mãi</th>
                            <td><span class="text-danger fw-bold fs-5"><?= number_format($product->discount_price) ?> đ</span></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tồn kho</th>
                            <td>
                                <?php if($product->quantity > 0): ?>
                                    <span class="badge bg-success px-3 py-2"><?= $product->quantity ?> sản phẩm</span>
                                <?php else: ?>
                                    <span class="badge bg-danger px-3 py-2">Hết hàng</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Trạng thái</th>
                            <td>
                                <?php if($product->status == 1): ?>
                                    <span class="badge bg-primary px-3 py-2"><i class="bi bi-eye"></i> Đang hiển thị</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-eye-slash"></i> Đang ẩn</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <hr class="text-muted">
                
                <h5 class="text-muted mt-3 mb-3">Mô tả sản phẩm</h5>
                <div class="p-3 bg-light rounded text-dark" style="min-height: 100px;">
                    <?= nl2br(htmlspecialchars($product->description)) ?>
                </div>
                
                <div class="mt-4">
                    <a href="/MiniShop_NguyenNghiaNhan/admin/product/edit/<?= $product->id ?>" class="btn btn-warning px-4 py-2 me-2 shadow-sm"><i class="bi bi-pencil-square"></i> Cập nhật</a>
                    <a href="/MiniShop_NguyenNghiaNhan/admin/product" class="btn btn-outline-secondary px-4 py-2 shadow-sm"><i class="bi bi-arrow-left"></i> Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>