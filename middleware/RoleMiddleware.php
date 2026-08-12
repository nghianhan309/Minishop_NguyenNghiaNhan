<?php
namespace Middleware;

use DAO\UserDAO;

class RoleMiddleware
{
    public static function checkAdmin()
    {
        // Must require User class BEFORE session_start to correctly unserialize User object
        require_once __DIR__ . '/../dao/UserDAO.php';
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION["user"] ?? null;
        if (!$user || $user->role != 1) {
            echo "<script>alert('Từ chối truy cập! Bạn không có quyền Admin.'); window.location.href='/MiniShop_NguyenNghiaNhan/views/admin/dashboard.php';</script>";
            exit;
        }
    }
}
?>
