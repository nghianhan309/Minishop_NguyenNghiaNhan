<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Danh sách bài viết</h2>
    <a href="/MiniShop_NguyenNghiaNhan/admin/post?action=create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Thêm mới</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0 text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="50">ID</th>
                    <th width="100">Hình ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th width="120">Trạng thái</th>
                    <th width="150">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= $post->id ?></td>
                            <td>
                                <?php if (!empty($post->image) && file_exists(__DIR__ . "/../../../uploads/posts/" . $post->image)): ?>
                                    <img src="/MiniShop_NguyenNghiaNhan/uploads/posts/<?= $post->image ?>" alt="Ảnh" style="height: 50px; width: 50px; object-fit: cover;" class="rounded">
                                <?php else: ?>
                                    <span class="text-muted"><i class="bi bi-image"></i></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-start fw-bold"><?= htmlspecialchars($post->title) ?></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($post->category_name) ?></span></td>
                            <td>
                                <?php if ($post->status == 1): ?>
                                    <span class="badge bg-success">Hiển thị</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Ẩn</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/MiniShop_NguyenNghiaNhan/admin/post?action=edit&id=<?= $post->id ?>" class="btn btn-warning btn-sm" title="Sửa"><i class="bi bi-pencil-square"></i> Sửa</a>
                                <a href="/MiniShop_NguyenNghiaNhan/admin/post?action=delete&id=<?= $post->id ?>" class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');"><i class="bi bi-trash"></i> Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Chưa có bài viết nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
