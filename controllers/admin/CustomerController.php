<?php
namespace Controllers\Admin;

use Models\Customer;

use Middleware\CsrfMiddleware;

use DAO\CustomerDAO;

class CustomerController
{
    public function index()
    {
        $pageTitle = "Quản lý khách hàng";

$dao = new CustomerDAO();

$keyword = trim($_GET["keyword"] ?? "");
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = trim($_GET["sort"] ?? "");

$offset = ($page - 1) * $limit;
$totalRecords = $dao->count("customers", "fullname", $keyword);
$totalPages = ceil($totalRecords / $limit);
$customers = $dao->getPage($limit, $offset, $keyword, $sort);

ob_start();

        require __DIR__ . '/../../views/admin/customers/index.php';
    }

    public function create()
    {
        $pageTitle = "Thêm Khách Hàng";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $fullname = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    if ($fullname != '') {
        $dao = new \DAO\CustomerDAO();
        $b = new Customer($fullname, $phone, null, null);
        $dao->insert($b);
        header("Location: /MiniShop_NguyenNghiaNhan/admin/customer"); exit;
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/customers/create.php';
    }

    public function edit()
    {
        $pageTitle = "Sửa Khách Hàng";

$id = $_GET['id'] ?? 0;
$dao = new \DAO\CustomerDAO();
$b = $dao->findById($id);
if (!$b) die("Not found");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $fullname = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    if ($fullname != '') {
        $b->fullname = $fullname;
        $b->phone = $phone;
        $dao->update($b);
        header("Location: /MiniShop_NguyenNghiaNhan/admin/customer"); exit;
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/customers/edit.php';
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { CsrfMiddleware::verify(); }
else { die('Invalid Request'); }

$id = $_POST['id'] ?? 0;
$dao = new \DAO\CustomerDAO();
$dao->delete($id);
header("Location: /MiniShop_NguyenNghiaNhan/admin/customer");    }
}