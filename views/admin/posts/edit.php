<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Sửa bài viết</h2>
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
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post->title) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Đường dẫn tĩnh (Slug)</label>
                        <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($post->slug) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả ngắn (Summary)</label>
                        <textarea name="summary" class="form-control" rows="3"><?= htmlspecialchars($post->summary) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung chi tiết (Summernote)</label>
                        <textarea name="content" id="summernote" class="form-control"><?= htmlspecialchars($post->content) ?></textarea>
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
                        <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($post->category_name) ?>">
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="status" <?= $post->status == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status">Hiển thị bài viết</label>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Ảnh bìa</div>
                <div class="card-body">
                    <?php if (!empty($post->image)): ?>
                        <div class="mb-3 text-center">
                            <img src="/MiniShop_NguyenNghiaNhan/uploads/posts/<?= $post->image ?>" alt="Ảnh bìa" class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <input type="file" id="image" name="image" class="form-control form-control-sm" accept="image/*">
                        <small class="text-muted">Để trống nếu không muốn đổi ảnh</small>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-warning btn-lg fw-bold"><i class="bi bi-pencil-square"></i> Cập nhật bài viết</button>
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
