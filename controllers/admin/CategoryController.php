<?php
namespace Controllers\Admin;

use Models\Category;

use Middleware\CsrfMiddleware;

use DAO\CategoryDAO;

class CategoryController
{
    public function index()
    {
        $pageTitle = "Danh sách danh mục";

$dao = new CategoryDAO();

if (isset($_POST["btnDelete"])) {
    $dao->delete((int)$_POST["id"]);
}

$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = trim($_GET["sort"] ?? "");

$offset = ($page - 1) * $limit;

// CategoryDAO count function can just use catename for search
$totalRecords = $dao->count("categories", "catename", $keyword);
$totalPages = ceil($totalRecords / $limit);

$categories = $dao->getPage($limit, $offset, $keyword, $sort);
ob_start();

        require __DIR__ . '/../../views/admin/categories/index.php';
    }

    public function create()
    {
        $pageTitle = "Thêm danh mục";

$dao = new \DAO\CategoryDAO();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $cateName = trim($_POST["cateName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? 1;

    if ($cateName == "") $errors[] = "Tên danh mục không được để trống.";
    if ($slug == "") $errors[] = "Slug không được để trống.";

    if (empty($errors)) {
        $cat = new Category($cateName, $slug, null, $description, $status);
        if ($dao->insert($cat)) {
            header("Location: /MiniShop_NguyenNghiaNhan/admin/category");
            exit;
        } else {
            $errors[] = "Thêm thất bại.";
        }
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/categories/create.php';
    }

    public function edit()
    {
        $pageTitle = "Cập nhật danh mục";

$dao = new \DAO\CategoryDAO();
$id = $_GET["id"] ?? 0;
$category = $dao->findById($id);

if (!$category) die("Không tìm thấy danh mục");

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $cateName = trim($_POST["cateName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? 1;

    if ($cateName == "") $errors[] = "Tên không để trống.";
    if ($slug == "") $errors[] = "Slug không để trống.";

    if (empty($errors)) {
        $category->name = $cateName;
        $category->slug = $slug;
        $category->description = $description;
        $category->status = $status;
        if ($dao->update($category)) {
            header("Location: /MiniShop_NguyenNghiaNhan/admin/category");
            exit;
        } else {
            $errors[] = "Cập nhật thất bại.";
        }
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/categories/edit.php';
    }

    public function detail()
    {
        $pageTitle = "Chi tiết danh mục";

$dao = new \DAO\CategoryDAO();
$category = $dao->findById($_GET["id"] ?? 0);
if (!$category) die("Không tìm thấy");
ob_start();
        require __DIR__ . '/../../views/admin/categories/detail.php';
    }
}