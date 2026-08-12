<?php
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
}
?>
