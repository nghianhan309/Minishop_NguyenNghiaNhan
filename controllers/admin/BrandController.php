<?php
namespace Controllers\Admin;

use Models\Brand;

use Middleware\CsrfMiddleware;

use DAO\BrandDAO;

class BrandController
{
    public function index()
    {
        $pageTitle = "Quản lý thương hiệu";

$dao = new BrandDAO();

$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = trim($_GET["sort"] ?? "");

$offset = ($page - 1) * $limit;
$totalRecords = $dao->count("brands", "brandname", $keyword);
$totalPages = ceil($totalRecords / $limit);
$brands = $dao->getPage($limit, $offset, $keyword, $sort);

ob_start();

        require __DIR__ . '/../../views/admin/brands/index.php';
    }

    public function create()
    {
        $pageTitle = "Thêm Thương Hiệu";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    if ($name != '') {
        $dao = new \DAO\BrandDAO();
        $b = new Brand($name, $slug, null, null, 1);
        $dao->insert($b);
        header("Location: /MiniShop_NguyenNghiaNhan/admin/brand"); exit;
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/brands/create.php';
    }

    public function edit()
    {
        $pageTitle = "Sửa Thương Hiệu";

$id = $_GET['id'] ?? 0;
$dao = new \DAO\BrandDAO();
$b = $dao->findById($id);
if (!$b) die("Not found");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    if ($name != '') {
        $b->name = $name;
        $b->slug = $slug;
        $dao->update($b);
        header("Location: /MiniShop_NguyenNghiaNhan/admin/brand"); exit;
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/brands/edit.php';
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { CsrfMiddleware::verify(); }
else { die('Invalid Request'); }

$id = $_POST['id'] ?? 0;
$dao = new \DAO\BrandDAO();
$dao->delete($id);
header("Location: /MiniShop_NguyenNghiaNhan/admin/brand");    }
}