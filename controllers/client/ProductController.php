<?php
namespace Controllers\Client;

use DAO\ProductDAO;

class ProductController
{
    private ProductDAO $productDAO;
    
    public function __construct()
    {
        $this->productDAO = new ProductDAO();
    }
    
    public function category()
    {
        $slug = $_GET['slug'] ?? '';
        $products = $this->productDAO->getByCategory($slug);
        
        $title = "Sản phẩm theo Danh mục";
        $heading = "Sản phẩm theo Danh mục: " . htmlspecialchars($slug);
        
        ob_start();
        require __DIR__ . '/../../views/client/products/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
    
    public function brand()
    {
        $slug = $_GET['slug'] ?? '';
        $products = $this->productDAO->getByBrand($slug);
        
        $title = "Sản phẩm theo Thương hiệu";
        $heading = "Sản phẩm theo Thương hiệu: " . htmlspecialchars($slug);
        
        ob_start();
        require __DIR__ . '/../../views/client/products/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
    
    public function detail()
    {
        $slug = $_GET['slug'] ?? '';
        $product = $this->productDAO->getBySlug($slug);
        
        if (!$product) {
            $title = "Không tìm thấy sản phẩm";
            ob_start();
            echo "<div class='alert alert-danger'>Sản phẩm không tồn tại hoặc đã bị xóa.</div>";
            $content = ob_get_clean();
            require __DIR__ . "/../../views/client/layouts/master.php";
            return;
        }
        
        $title = $product->proname . " | MiniShop";
        
        ob_start();
        require __DIR__ . '/../../views/client/products/detail.php';
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
    
    public function search()
    {
        $keyword = $_GET['q'] ?? '';
        $products = [];
        
        if (!empty(trim($keyword))) {
            $products = $this->productDAO->search(trim($keyword));
        }
        
        $title = "Tìm kiếm: " . htmlspecialchars($keyword);
        $heading = "Kết quả tìm kiếm cho: \"" . htmlspecialchars($keyword) . "\"";
        
        ob_start();
        require __DIR__ . '/../../views/client/products/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
}
?>
