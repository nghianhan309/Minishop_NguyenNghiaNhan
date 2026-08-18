<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? "Mini Shop" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
        .product-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .btn-buy { transition: all 0.2s; }
        .btn-buy:hover { background-color: #0056b3; color: #fff; }
        /* Dropdown hover cho desktop */
        @media all and (min-width: 992px) {
            .navbar .nav-item .dropdown-menu { display: none; }
            .navbar .nav-item:hover .nav-link { color: #ffc107; }
            .navbar .nav-item:hover .dropdown-menu { display: block; margin-top: 0; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . "/header.php"; ?>
    
    <div class="container-fluid p-4" style="min-height: 80vh;">
        <?= $content ?>
    </div>
    
    <?php include __DIR__ . "/footer.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
