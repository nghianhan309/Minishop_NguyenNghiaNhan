<style>
    .profile-card { border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s; }
    .profile-card:hover { transform: translateY(-5px); }
    .avatar-wrapper { position: relative; display: inline-block; padding: 5px; background: linear-gradient(135deg, #0d6efd, #0dcaf0); border-radius: 50%; }
    .avatar-wrapper img { border: 4px solid white; }
    .nav-pills .nav-link { border-radius: 10px; color: #555; padding: 12px 20px; font-weight: 500; margin-bottom: 8px; transition: all 0.3s; }
    .nav-pills .nav-link:hover { background-color: #f8f9fa; color: #0d6efd; }
    .nav-pills .nav-link.active { background: linear-gradient(135deg, #0d6efd, #0dcaf0); color: white; box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3); }
    .nav-pills .nav-link i { margin-right: 10px; font-size: 1.1em; }
    .form-floating > .form-control { border-radius: 10px; border: 1px solid #e0e0e0; padding-left: 20px; }
    .form-floating > .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); border-color: #0d6efd; }
    .form-floating > label { padding-left: 20px; color: #777; }
    .btn-premium { background: linear-gradient(135deg, #0d6efd, #0dcaf0); border: none; border-radius: 10px; color: white; font-weight: bold; padding: 12px 30px; box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3); transition: all 0.3s; }
    .btn-premium:hover { transform: scale(1.05); box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4); color: white; }
    .table-premium th { font-weight: 600; color: #555; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; border-bottom: 2px solid #eee; }
    .table-premium td { vertical-align: middle; color: #444; border-bottom: 1px solid #f5f5f5; padding: 15px 10px; }
    .table-premium tbody tr { transition: background 0.3s; }
    .table-premium tbody tr:hover { background-color: #f8f9fa; }
</style>

<div class="row py-4">
    <div class="col-md-3 mb-4">
        <div class="card profile-card">
            <div class="card-body text-center p-4">
                <div class="avatar-wrapper mb-3">
                    <img src="<?= BASE_URL ?>assets/client/images/default-avatar.png" alt="Avatar" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user->fullname) ?>&background=random&color=fff&size=120'">
                </div>
                <h4 class="fw-bold mb-1" style="color: #333;"><?= htmlspecialchars($user->fullname) ?></h4>
                <p class="text-muted small mb-4"><i class="bi bi-person-badge me-1"></i> Thành viên VIP</p>
                <hr style="opacity: 0.1;">
                <div class="nav flex-column nav-pills text-start" role="tablist" aria-orientation="vertical">
                    <a href="#profile-info" class="nav-link active" data-bs-toggle="pill" role="tab"><i class="bi bi-person-lines-fill"></i> Thông tin cá nhân</a>
                    <a href="#order-history" class="nav-link" data-bs-toggle="pill" role="tab"><i class="bi bi-bag-check"></i> Lịch sử mua hàng</a>
                    <a href="<?= BASE_URL ?>auth/logout" class="nav-link text-danger mt-3 bg-light"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="profile-info" role="tabpanel">
                <div class="card profile-card p-4 p-md-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                            <i class="bi bi-person-vcard fs-4"></i>
                        </div>
                        <h3 class="fw-bold mb-0" style="color: #2c3e50;">Hồ sơ cá nhân</h3>
                    </div>
                    
                    <?php if (isset($success_msg)): ?>
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> <?= $success_msg ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger border-0 shadow-sm"><i class="bi bi-exclamation-triangle-fill me-2"></i> <?= implode("<br>", $errors) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="fullname" id="fullnameInput" value="<?= htmlspecialchars($user->fullname) ?>" required placeholder="Họ và tên">
                                    <label for="fullnameInput">Họ và tên</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light" id="usernameInput" value="<?= htmlspecialchars($user->username) ?>" readonly disabled placeholder="Tên đăng nhập">
                                    <label for="usernameInput">Tên đăng nhập (Không thể đổi)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="phone" id="phoneInput" value="<?= htmlspecialchars($user->phone ?? '') ?>" placeholder="Số điện thoại" required>
                                    <label for="phoneInput">Số điện thoại liên hệ</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="emailInput" value="<?= htmlspecialchars($customerEmail ?? '') ?>" placeholder="Email cá nhân" required>
                                    <label for="emailInput">Địa chỉ Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="address" id="addressInput" value="<?= htmlspecialchars($customerAddress ?? '') ?>" placeholder="Địa chỉ giao hàng">
                                    <label for="addressInput">Địa chỉ giao hàng mặc định</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-premium"><i class="bi bi-floppy me-2"></i> Cập nhật hồ sơ</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="tab-pane fade" id="order-history" role="tabpanel">
                <div class="card profile-card p-4 p-md-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle me-3">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <h3 class="fw-bold mb-0" style="color: #2c3e50;">Lịch sử mua hàng</h3>
                    </div>
                    
                    <?php if (empty($orders)): ?>
                        <div class="text-center py-5">
                            <img src="<?= BASE_URL ?>assets/client/images/empty-cart.png" alt="Empty" style="width: 150px; opacity: 0.5;" class="mb-4" onerror="this.style.display='none'">
                            <i class="bi bi-cart-x display-1 text-muted mb-3 d-block" style="<?= isset($no_image) ? '' : 'display:none!important' ?>"></i>
                            <h5 class="text-muted fw-normal">Bạn chưa có đơn hàng nào</h5>
                            <a href="<?= BASE_URL ?>" class="btn btn-premium mt-3"><i class="bi bi-shop me-2"></i> Bắt đầu mua sắm ngay</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-premium align-middle">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th class="text-end">Tổng tiền</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-end">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><span class="badge bg-light text-primary border p-2" style="font-size: 13px;"><i class="bi bi-hash"></i><?= htmlspecialchars($order['order_code']) ?></span></td>
                                        <td class="text-muted"><i class="bi bi-calendar-event me-1"></i> <?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                                        <td class="text-danger fw-bold text-end"><?= number_format($order['total_amount']) ?> đ</td>
                                        <td class="text-center">
                                            <?php 
                                            switch($order['status']) {
                                                case 0: echo '<span class="badge rounded-pill bg-warning text-dark"><i class="bi bi-clock-history me-1"></i>Chờ xác nhận</span>'; break;
                                                case 1: echo '<span class="badge rounded-pill bg-info"><i class="bi bi-clipboard-check me-1"></i>Đã xác nhận</span>'; break;
                                                case 2: echo '<span class="badge rounded-pill bg-primary"><i class="bi bi-truck me-1"></i>Đang giao</span>'; break;
                                                case 3: echo '<span class="badge rounded-pill bg-success"><i class="bi bi-check-circle me-1"></i>Đã giao</span>'; break;
                                                case 4: echo '<span class="badge rounded-pill bg-danger"><i class="bi bi-x-circle me-1"></i>Đã hủy</span>'; break;
                                            }
                                            ?>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?= BASE_URL ?>profile/orderDetail?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">Xem chi tiết</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
