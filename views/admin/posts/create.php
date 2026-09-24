<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Thêm bài viết mới</h2>
    <a href="/MiniShop_NguyenNghiaNhan/admin/post" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> <?= implode("<br>", $errors) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? "") ?>">
    
    <div class="row">
        <!-- Cột trái: Nội dung -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Nội dung bài viết</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Đường dẫn tĩnh (Slug)</label>
                        <input type="text" name="slug" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả ngắn (Summary)</label>
                        <textarea name="summary" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung chi tiết (Summernote)</label>
                        <textarea name="content" id="summernote" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột phải: Cài đặt & Ảnh -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Cài đặt</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Chuyên mục</label>
                        <input type="text" name="category_name" class="form-control" placeholder="VD: Kinh nghiệm, Kiến thức...">
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                        <label class="form-check-label" for="status">Hiển thị bài viết</label>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Ảnh bìa</div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="file" id="image" name="image" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg fw-bold"><i class="bi bi-floppy"></i> Đăng bài viết</button>
            </div>
        </div>
    </div>
</form>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Viết nội dung bài viết ở đây...',
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
