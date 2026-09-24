<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Thêm sản phẩm mới</h2>
    <a href="/MiniShop_NguyenNghiaNhan/admin/product" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> <?= implode("<br>", $errors) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    
    <div class="row">
        <!-- Cột trái: Thông tin chính -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Thông tin chung</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="productName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Đường dẫn tĩnh (Slug)</label>
                        <input type="text" name="slug" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả chi tiết (Summernote)</label>
                        <textarea name="description" id="summernote" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột phải: Phân loại, Giá, Ảnh -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Phân loại & Giá</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="categoryId" class="form-select" required>
                            <option value="">Chọn danh mục...</option>
                            <?php foreach($categories as $c): ?><option value="<?= $c->id ?>"><?= $c->name ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thương hiệu</label>
                        <select name="brandId" class="form-select" required>
                            <option value="">Chọn thương hiệu...</option>
                            <?php foreach($brands as $b): 
                                $bid = is_object($b) ? $b->id : ($b["id"] ?? 0);
                                $bname = is_object($b) ? $b->name : ($b["brandname"] ?? "Brand");
                            ?>
                                <option value="<?= $bid ?>"><?= $bname ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Giá gốc</label>
                            <input type="number" name="price" class="form-control" value="0">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Giá giảm</label>
                            <input type="number" name="discount_price" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kho hàng (Số lượng)</label>
                        <input type="number" name="quantity" class="form-control" value="0">
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Hình ảnh sản phẩm</div>
                <div class="card-body">
                    <div class="text-center mb-3" id="preview"></div>
                    <div class="mb-3">
                        <label class="form-label"> Ảnh đại diện chính </label>
                        <input type="file" id="image" name="image" class="form-control form-control-sm" accept="image/*" required>
                    </div>
                    
                    <hr>

                    <div class="text-center mb-3" id="preview-gallery"></div>
                    <div class="mb-3">
                        <label class="form-label"> Thư viện ảnh (Gallery) </label>
                        <input type="file" id="images" name="images[]" class="form-control form-control-sm" accept="image/*" multiple>
                        <small class="text-muted">Chọn nhiều ảnh cùng lúc</small>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg fw-bold"><i class="bi bi-floppy"></i> Thêm Sản Phẩm</button>
            </div>
        </div>
    </div>
</form>

<!-- Thêm thư viện Summernote CDN -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Nhập mô tả chi tiết sản phẩm...',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

<?php $content = ob_get_clean(); include __DIR__ . "/../layouts/master.php"; ?>