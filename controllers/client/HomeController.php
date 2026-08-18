<?php
namespace Controllers\Client;

use DAO\ProductDAO;
use DAO\CategoryDAO;

class HomeController
{
    private ProductDAO $productDAO;
    private CategoryDAO $categoryDAO;
    
    public function __construct()
    {
        $this->productDAO = new ProductDAO();
        $this->categoryDAO = new CategoryDAO();
    }
    
    public function index()
    {
        $title = "MiniShop | Trang chủ";
        
        // Danh mục nổi bật
        $categories = $this->categoryDAO->getByLimit(4);
        
        // Sản phẩm giảm giá
        $discountProducts = $this->productDAO->getDiscountProducts(8);
        
        // Sản phẩm mới
        $newProducts = $this->productDAO->getNewProducts(8);
        
        ob_start();
        require __DIR__ . "/../../views/client/home/index.php";
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
}
?>
