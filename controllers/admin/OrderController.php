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


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnUpdateOrder"])) {
    $status = (int)$_POST["status"];
    $note = trim($_POST["note"] ?? "");
    
    // Update order
    $dao->updateOrder($id, $status, $note);
    
    // Update customer info (fullname, phone, address)
    $customerDAO = new \DAO\CustomerDAO();
    $customer_id = $order['customer_id'];
    $customer = $customerDAO->findById($customer_id);
    if ($customer) {
        $customer->fullname = trim($_POST["customer_name"] ?? "");
        $customer->phone = trim($_POST["phone"] ?? "");
        $customer->address = trim($_POST["address"] ?? "");
        $customerDAO->update($customer);
    }

    $_SESSION["success_msg"] = "Cập nhật đơn hàng thành công!";
    header("Location: /MiniShop_NguyenNghiaNhan/admin/order/detail/$id"); exit;
}

$details = $dao->getOrderDetails($id);
ob_start();
$success_msg = $_SESSION["success_msg"] ?? "";
unset($_SESSION["success_msg"]);
        require __DIR__ . '/../../views/admin/orders/detail.php';
    }
}