<?php
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { CsrfMiddleware::verify(); }
else { die('Invalid Request'); }
require_once __DIR__ . "/../../../dao/BrandDAO.php";
$id = $_POST['id'] ?? 0;
$dao = new BrandDAO();
$dao->delete($id);
header("Location: index.php");
?>