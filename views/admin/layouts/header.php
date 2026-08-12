<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : "Trang quản trị" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar { min-height: 100vh; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="bi bi-cart3"></i> Mini Shop</a>
<?php
$user = $_SESSION["user"] ?? null;
?>
            <div class="d-flex text-white align-items-center gap-2">
                <i class="bi bi-person-circle fs-3"></i> 
                <span>
                    <?= $user ? htmlspecialchars($user->fullname) : "Admin" ?>
                </span>
                <a href="/MiniShop_NguyenNghiaNhan/index.php?area=admin&controller=auth&action=logout" class="text-decoration-none text-light">
                    | Đăng xuất
                </a>
            </div>
        </div>
    </nav>
