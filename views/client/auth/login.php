<div class="row justify-content-center my-5">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <h3 class="text-center mb-4 fw-bold">Đăng Nhập Khách Hàng</h3>
                
                <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success">Đăng ký thành công! Vui lòng đăng nhập.</div>
                <?php endif; ?>

                <?php if($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>login" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Đăng Nhập</button>
                </form>
                
                <div class="text-center mt-4">
                    <p class="mb-0">Chưa có tài khoản? <a href="<?= BASE_URL ?>register" class="text-decoration-none">Đăng ký ngay</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
