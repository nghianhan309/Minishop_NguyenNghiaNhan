<?php
namespace Controllers\Admin;

use Models\Product;

use Middleware\CsrfMiddleware;

use DAO\ProductDAO;

class ProductController
{
    public function index()
    {
        // Gán dữ liệu cho tiêu đề trang
        $pageTitle = "Danh sách sản phẩm";
        
        $dao = new ProductDAO();

        // Xóa sản phẩm nếu có Request POST
        if (isset($_POST["btnDelete"])) {
            // Yêu cầu Lab 11 không nhắc vụ CSRF ở Controller lúc này, nhưng để nguyên logic cũ
            $dao->delete((int)$_POST["id"]);
        }

        // Đọc request từ URL
        $keyword = trim($_GET["keyword"] ?? "");
        $limit = (int)($_GET["limit"] ?? 10);
        $page = (int)($_GET["page"] ?? 1);
        $sort = trim($_GET["sort"] ?? "");

        // Xử lý offset
        $offset = ($page - 1) * $limit;
        
        // Gọi Dao
        $totalRecords = $dao->count("products", "proname", $keyword);
        $totalPages = ceil($totalRecords / $limit);
        $products = $dao->getPage($limit, $offset, $keyword, $sort);

        // Gọi View
        require __DIR__ . "/../../views/admin/products/index.php";
    }


    public function create()
    {
        $pageTitle = "Thêm sản phẩm";



$dao = new \DAO\ProductDAO();
$catDao = new \DAO\CategoryDAO();
$brandDao = new \DAO\BrandDAO();

$categories = $catDao->getAll();
$brands = $brandDao->getAll();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $proname = trim($_POST["productName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $categoryId = (int)($_POST["categoryId"] ?? 0);
    $brandId = (int)($_POST["brandId"] ?? 0);
    $price = (float)($_POST["price"] ?? 0);
    $discount_price = (float)($_POST["discount_price"] ?? 0);
    $quantity = (int)($_POST["quantity"] ?? 0);

    $fileName = $_FILES["image"]["name"] ?? "";
    $tmpName = $_FILES["image"]["tmp_name"] ?? "";
    $fileSize = $_FILES["image"]["size"] ?? 0;
    $error = $_FILES["image"]["error"] ?? 0;
    $image = "";

    if ($proname == "") $errors[] = "Tên không được trống";
    if ($categoryId == 0) $errors[] = "Chọn danh mục";
    if ($brandId == 0) $errors[] = "Chọn thương hiệu";

    if ($fileName != "") {
        if ($error != UPLOAD_ERR_OK) {
            $errors[] = "Upload hình ảnh không thành công.";
        }
        $allowExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowExtensions)) {
            $errors[] = "Chỉ cho phép file JPG, JPEG, PNG hoặc WEBP.";
        }
        $maxSize = 200 * 1024;
        if ($fileSize > $maxSize) {
            $errors[] = "Kích thước hình ảnh <= 200 KB.";
        }
    }

    if (empty($errors)) {
        if ($fileName != "") {
            $image = time() . "_" . $slug . "." . $extension;
            $uploadPath = __DIR__ . "/../../../uploads/products/" . $image;
            move_uploaded_file($tmpName, $uploadPath);
        }

        $p = new Product($categoryId, $brandId, $proname, $slug, $price, $discount_price, $quantity, "", $image, 1);
        $insertedId = $dao->insert($p);
        if ($insertedId > 0) {
            // Upload gallery
            if (!empty($_FILES["images"]["name"][0])) {
                foreach ($_FILES["images"]["name"] as $key => $gName) {
                    if ($_FILES["images"]["error"][$key] == UPLOAD_ERR_OK) {
                        $gExt = strtolower(pathinfo($gName, PATHINFO_EXTENSION));
                        $gImage = time() . "_" . $key . "_" . $slug . "." . $gExt;
                        $gPath = __DIR__ . "/../../../uploads/products/" . $gImage;
                        if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $gPath)) {
                            $dao->insertImage($insertedId, $gImage);
                        }
                    }
                }
            }
            header("Location: /MiniShop_NguyenNghiaNhan/admin/product"); exit;
        } else $errors[] = "Thêm thất bại.";
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/products/create.php';
    }

    public function edit()
    {
        $pageTitle = "Cập nhật sản phẩm";



$dao = new \DAO\ProductDAO();
$catDao = new \DAO\CategoryDAO();
$brandDao = new \DAO\BrandDAO();

$id = $_GET["id"] ?? 0;
$product = $dao->findById($id);
if (!$product) die("Không tìm thấy sản phẩm");

if (isset($_GET["del_img"])) {
    $imgId = (int)$_GET["del_img"];
    $dao->deleteImage($imgId);
    header("Location: /MiniShop_NguyenNghiaNhan/admin/product"); exit;
}

$categories = $catDao->getAll();
$brands = $brandDao->getAll();
$gallery = $dao->getImagesByProductId($id);
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    CsrfMiddleware::verify();
    $proname = trim($_POST["productName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $categoryId = (int)($_POST["categoryId"] ?? 0);
    $brandId = (int)($_POST["brandId"] ?? 0);
    $price = (float)($_POST["price"] ?? 0);
    $discount_price = (float)($_POST["discount_price"] ?? 0);
    $quantity = (int)($_POST["quantity"] ?? 0);

    $fileName = $_FILES["image"]["name"] ?? "";
    $tmpName = $_FILES["image"]["tmp_name"] ?? "";
    $fileSize = $_FILES["image"]["size"] ?? 0;
    $error = $_FILES["image"]["error"] ?? 0;
    $image = $product->image;

    if ($proname == "") $errors[] = "Tên không được trống";
    if ($categoryId == 0) $errors[] = "Chọn danh mục";

    if ($fileName != "") {
        if ($error != UPLOAD_ERR_OK) $errors[] = "Upload hình ảnh không thành công.";
        $allowExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowExtensions)) $errors[] = "Chỉ cho phép file JPG, JPEG, PNG hoặc WEBP.";
        $maxSize = 200 * 1024;
        if ($fileSize > $maxSize) $errors[] = "Kích thước hình ảnh <= 200 KB.";
    }

    if (empty($errors)) {
        if ($fileName != "") {
            $image = time() . "_" . $slug . "." . $extension;
            $uploadPath = __DIR__ . "/../../../uploads/products/" . $image;
            if (!empty($product->image)) {
                $oldImage = __DIR__ . "/../../../uploads/products/" . $product->image;
                if (file_exists($oldImage)) unlink($oldImage);
            }
            move_uploaded_file($tmpName, $uploadPath);
        }

        $product->proname = $proname;
        $product->slug = $slug;
        $product->category_id = $categoryId;
        $product->brand_id = $brandId;
        $product->price = $price;
        $product->discount_price = $discount_price;
        $product->quantity = $quantity;
        $product->image = $image;
        
        if ($dao->update($product)) {
            if (!empty($_FILES["images"]["name"][0])) {
                foreach ($_FILES["images"]["name"] as $key => $gName) {
                    if ($_FILES["images"]["error"][$key] == UPLOAD_ERR_OK) {
                        $gExt = strtolower(pathinfo($gName, PATHINFO_EXTENSION));
                        $gImage = time() . "_" . $key . "_" . $slug . "." . $gExt;
                        $gPath = __DIR__ . "/../../../uploads/products/" . $gImage;
                        if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $gPath)) {
                            $dao->insertImage($id, $gImage);
                        }
                    }
                }
            }
            header("Location: /MiniShop_NguyenNghiaNhan/admin/product"); exit;
        } else $errors[] = "Cập nhật thất bại.";
    }
}
ob_start();
        require __DIR__ . '/../../views/admin/products/edit.php';
    }

    public function detail()
    {
        $pageTitle = "Chi tiết sản phẩm";

$dao = new \DAO\ProductDAO();
$product = $dao->findById($_GET["id"] ?? 0);
if (!$product) die("Không tìm thấy");
$gallery = $dao->getImagesByProductId($product->id);
ob_start();
        require __DIR__ . '/../../views/admin/products/detail.php';
    }
}