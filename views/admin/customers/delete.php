<?php
require_once __DIR__ . "/../../../dao/CustomerDAO.php";
$id = $_GET['id'] ?? 0;
$dao = new CustomerDAO();
$dao->delete($id);
header("Location: index.php");
?>