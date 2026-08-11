<?php
require_once __DIR__ . "/../../../dao/UserDAO.php";
$id = $_GET['id'] ?? 0;
$dao = new UserDAO();
$dao->delete($id);
header("Location: index.php");
?>