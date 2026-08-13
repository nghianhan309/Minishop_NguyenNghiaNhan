<?php
namespace Controllers\Admin;

use DAO\CategoryDAO;
use DAO\BrandDAO;
use DAO\ProductDAO;
use DAO\CustomerDAO;
use DAO\OrderDAO;

class DashboardController
{
    public function index()
    {
        $categoryDAO = new CategoryDAO();
$brandDAO = new BrandDAO();
$productDAO = new ProductDAO();
$customerDAO = new CustomerDAO();
$orderDAO = new OrderDAO();

$totalCategories = $categoryDAO->getTotalCount();
$totalBrands = $brandDAO->getTotalCount();
$totalProducts = $productDAO->getTotalCount();
$totalCustomers = $customerDAO->getTotalCount();
$totalOrders = $orderDAO->getTotalCount();

$newestProducts = $productDAO->getNewestProducts(5);
$newestOrders = $orderDAO->getNewestOrders(5);

$pageTitle = "Dashboard";
ob_start();

        require __DIR__ . '/../../views/admin/dashboard.php';
    }
}