<?php
namespace Controllers\Admin;

use DAO\OrderDAO;

class OrderController
{
    public function index()
    {
        $pageTitle = "Quản lý đơn hàng";

$dao = new OrderDAO();

$keyword = trim($_GET["keyword"] ?? "");
$status = $_GET["status"] ?? "";
$limit = (int)($_GET["limit"] ?? 10);
$page = (int)($_GET["page"] ?? 1);
$sort = trim($_GET["sort"] ?? "");

$offset = ($page - 1) * $limit;
$totalRecords = $dao->countOrder($keyword, $status);
$totalPages = ceil($totalRecords / $limit);

$orders = $dao->getPage($limit, $offset, $keyword, $status, $sort);
ob_start();

        require __DIR__ . '/../../views/admin/orders/index.php';
    }

    public function detail()
    {
        $pageTitle = "Chi tiết đơn hàng";

$dao = new \DAO\OrderDAO();
$id = $_GET["id"] ?? 0;
$order = $dao->findById($id);
if (!$order) die("Không tìm thấy đơn hàng");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnUpdateStatus"])) {
    $dao->updateStatus($id, (int)$_POST["status"]);
    $_SESSION["success_msg"] = "Cập nhật trạng thái thành công!";
    header("Location: /MiniShop_NguyenNghiaNhan/admin/order"); exit;
}

$details = $dao->getOrderDetails($id);
ob_start();
$success_msg = $_SESSION["success_msg"] ?? "";
unset($_SESSION["success_msg"]);
        require __DIR__ . '/../../views/admin/orders/detail.php';
    }
}