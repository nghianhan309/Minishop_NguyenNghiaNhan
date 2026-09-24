<div class="row justify-content-center my-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <h3 class="text-center mb-4 fw-bold">Đăng Ký Tài Khoản</h3>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>register" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Đăng Ký</button>
                </form>
                
                <div class="text-center mt-4">
                    <p class="mb-0">Đã có tài khoản? <a href="<?= BASE_URL ?>login" class="text-decoration-none">Đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
