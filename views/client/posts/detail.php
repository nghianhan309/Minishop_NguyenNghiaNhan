<div class="row">
    <!-- Nội dung chính -->
    <div class="col-lg-8 mb-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Góc tư vấn</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($post->title) ?></li>
            </ol>
        </nav>

        <h1 class="fw-bold mb-3"><?= htmlspecialchars($post->title) ?></h1>
        <div class="d-flex align-items-center text-muted mb-4 pb-3 border-bottom">
            <span class="me-3"><i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y', strtotime($post->created_at)) ?></span>
            <span class="me-3"><i class="bi bi-folder2-open me-1"></i> <?= htmlspecialchars($post->category_name) ?></span>
        </div>

        <?php if (!empty($post->image) && file_exists(__DIR__ . "/../../../uploads/posts/" . $post->image)): ?>
            <div class="mb-4 text-center">
                <img src="/MiniShop_NguyenNghiaNhan/uploads/posts/<?= $post->image ?>" alt="<?= htmlspecialchars($post->title) ?>" class="img-fluid rounded shadow-sm w-100" style="max-height: 500px; object-fit: cover;">
            </div>
        <?php endif; ?>

        <div class="lead fw-bold mb-4 text-secondary">
            <?= nl2br(htmlspecialchars($post->summary)) ?>
        </div>

        <div class="post-content lh-lg fs-5">
            <?= $post->content ?>
        </div>
        
        <div class="mt-5 pt-4 border-top text-center">
            <h5 class="fw-bold mb-3">Chia sẻ bài viết này</h5>
            <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="bi bi-facebook"></i> Facebook</a>
            <a href="#" class="btn btn-outline-info btn-sm me-2"><i class="bi bi-twitter"></i> Twitter</a>
            <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-link-45deg"></i> Copy Link</a>
        </div>
    </div>

    <!-- Cột bên phải: Bài viết liên quan -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
            <div class="card-header bg-white border-bottom fw-bold text-uppercase py-3">
                <i class="bi bi-journal-text text-primary me-2"></i> Bài viết mới nhất
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php foreach ($relatedPosts as $rp): ?>
                    <li class="list-group-item p-3">
                        <a href="<?= BASE_URL ?>post/<?= $rp->slug ?>" class="text-decoration-none text-dark d-flex align-items-center">
                            <?php $rpImg = !empty($rp->image) && file_exists(__DIR__ . "/../../../uploads/posts/" . $rp->image) ? "/MiniShop_NguyenNghiaNhan/uploads/posts/" . $rp->image : "https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=150&auto=format&fit=crop"; ?>
                            <img src="<?= $rpImg ?>" alt="img" class="rounded me-3" style="width: 70px; height: 70px; object-fit: cover;">
                            <div>
                                <h6 class="mb-1 fw-bold text-truncate-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($rp->title) ?></h6>
                                <small class="text-muted"><?= date('d/m/Y', strtotime($rp->created_at)) ?></small>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 15px 0;
}
.post-content h1, .post-content h2, .post-content h3, .post-content h4 {
    font-weight: 700;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}
.post-content p {
    margin-bottom: 1.2rem;
}
.post-content blockquote {
    border-left: 5px solid #0d6efd;
    padding-left: 15px;
    font-style: italic;
    color: #6c757d;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 0 8px 8px 0;
}
</style>
