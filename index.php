<?php
require_once __DIR__ . '/autoload.php';

session_start();

// Xóa session bị lỗi do đổi Namespace (sửa lỗi __PHP_Incomplete_Class cho người dùng)
if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof __PHP_Incomplete_Class) {
    unset($_SESSION["user"]);
}


$area = $_GET["area"] ?? "admin"; // default to admin for this lab context, although PDF says client
$controller = $_GET["controller"] ?? "product";
$action = $_GET["action"] ?? "index";

// Xác định tên Controller
if ($area === "admin") {
    $controllerClass = "Controllers\\Admin\\" . ucfirst($controller) . "Controller";
} else {
    $controllerClass = "Controllers\\Client\\" . ucfirst($controller) . "Controller";
}

// *** Kiểm tra Authentication cho Admin
if ($area === "admin" && $controller !== "auth") {
    \Middleware\AuthMiddleware::handle();
}

// *** Kiểm tra Guest
if ($area === "admin" && $controller === "auth" && $action === "login") {
    \Middleware\GuestMiddleware::handle();
}

// *** Tạo CSRF Token
\Middleware\CsrfMiddleware::generateToken();

// Kiểm tra Controller
if (!class_exists($controllerClass)) {
    die("Controller không tồn tại");
}

// Tạo Controller
$controllerObject = new $controllerClass();

// Kiểm tra Action
if (!method_exists($controllerObject, $action)) {
    die("Action không tồn tại");
}

// Gọi Action
$controllerObject->$action();
?>
