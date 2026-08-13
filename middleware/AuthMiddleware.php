<?php
namespace Middleware;

use DAO\UserDAO;

class AuthMiddleware
{
    public static function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Tự động đăng nhập bằng Cookie nếu Session không tồn tại
        if (!isset($_SESSION["user"]) && isset($_COOKIE["remember_user"]) && isset($_COOKIE["remember_token"])) {
            $userDAO = new UserDAO();
            $u = $userDAO->findByUsername($_COOKIE["remember_user"]);
            if ($u && md5($u->username . $u->password) === $_COOKIE["remember_token"]) {
                $_SESSION["user"] = $u;
            }
        }

        if (!isset($_SESSION["user"])) {
            header("Location: /MiniShop_NguyenNghiaNhan/admin/auth/login");
            exit;
        }
    }
}
?>
