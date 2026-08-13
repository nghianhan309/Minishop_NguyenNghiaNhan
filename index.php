<?php
require_once __DIR__ . '/autoload.php';

session_start();

// Xóa session bị lỗi do đổi Namespace (sửa lỗi __PHP_Incomplete_Class cho người dùng)
if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof __PHP_Incomplete_Class) {
    unset($_SESSION["user"]);
}


// URL Routing (Parse URI if using .htaccess)
$uri = $_SERVER['REQUEST_URI'];
$basePath = '/MiniShop_NguyenNghiaNhan/';
if (strpos($uri, $basePath) === 0) {
    $path = substr($uri, strlen($basePath));
    $path = parse_url($path, PHP_URL_PATH);
    if ($path && $path !== 'index.php') {
        $segments = explode('/', trim($path, '/'));
        if (isset($segments[0])) $_GET['area'] = $segments[0];
        if (isset($segments[1])) $_GET['controller'] = $segments[1];
        if (isset($segments[2])) $_GET['action'] = $segments[2];
        if (isset($segments[3])) $_GET['id'] = $segments[3];
    }
}

$area = $_GET["area"] ?? "admin"; // default to admin for this lab context, although PDF says client
$controller = $_GET["controller"] ?? "dashboard";
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
