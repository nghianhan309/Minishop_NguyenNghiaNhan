<?php
require_once __DIR__ . '/../../../middleware/CsrfMiddleware.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { CsrfMiddleware::verify(); }
else { die('Invalid Request'); }
require_once __DIR__ . "/../../../dao/UserDAO.php";
$id = $_POST['id'] ?? 0;
$dao = new UserDAO();
$dao->delete($id);
header("Location: index.php");
?>