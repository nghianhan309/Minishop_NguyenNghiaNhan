<?php
require_once __DIR__ . "/../../../dao/BrandDAO.php";
$id = $_GET['id'] ?? 0;
$dao = new BrandDAO();
$dao->delete($id);
header("Location: index.php");
?>