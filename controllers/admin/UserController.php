<?php
namespace Controllers\Admin;

use Models\User;

use Middleware\CsrfMiddleware;

use DAO\UserDAO;
use Middleware\RoleMiddleware;

class UserController
{
    public function index()
    {
        RoleMiddleware::checkAdmin();
$pageTitle = "Quản lý nhân viên";

$dao = new UserDAO();

$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = trim($_GET["sort"] ?? "");

$offset = ($page - 1) * $limit;
$totalRecords = $dao->count("users", "fullname", $keyword);
$totalPages = ceil($totalRecords / $limit);
$users = $dao->getPage($limit, $offset, $keyword, $sort);

ob_start();

        require __DIR__ . '/../../views/admin/users/index.php';
    }

    public function create()
    {
        RoleMiddleware::checkAdmin();

$pageTitle = "Thêm User";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    if ($fullname != '') {
        $dao = new \DAO\UserDAO();
        $b = new User($fullname, $username, null, null, 1, 1);
        $dao->insert($b);
        header("Location: /MiniShop_NguyenNghiaNhan/admin/user"); exit;
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/users/create.php';
    }

    public function edit()
    {
        RoleMiddleware::checkAdmin();

$pageTitle = "Sửa User";

$id = $_GET['id'] ?? 0;
$dao = new \DAO\UserDAO();
$b = $dao->findById($id);
if (!$b) die("Not found");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    if ($fullname != '') {
        $b->fullname = $fullname;
        $b->username = $username;
        $dao->update($b);
        header("Location: /MiniShop_NguyenNghiaNhan/admin/user"); exit;
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/users/edit.php';
    }

    public function delete()
    {
        RoleMiddleware::checkAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { CsrfMiddleware::verify(); }
else { die('Invalid Request'); }

$id = $_POST['id'] ?? 0;
$dao = new \DAO\UserDAO();
$dao->delete($id);
header("Location: /MiniShop_NguyenNghiaNhan/admin/user");    }
}