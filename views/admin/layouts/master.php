<?php 
require_once __DIR__ . '/../../../dao/UserDAO.php';
require_once __DIR__ . '/../../../middleware/AuthMiddleware.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
AuthMiddleware::handle();
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
CsrfMiddleware::generateToken();
include __DIR__ . "/header.php"; 
?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . "/sidebar.php"; ?>
        <div class="col py-3">
            <?= $content ?>
        </div>
    </div>
</div>
<?php include __DIR__ . "/footer.php"; ?>
