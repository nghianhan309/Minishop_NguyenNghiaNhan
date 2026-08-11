<?php
class AuthMiddleware
{
    public static function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["user"])) {
            // Absolute path redirect to avoid relative path trap!
            header("Location: /MiniShop_NguyenNghiaNhan/views/admin/login.php");
            exit;
        }
    }
}
?>
