<?php
namespace Controllers\Client;

use DAO\ProductDAO;
use DAO\CategoryDAO;
use DAO\PostDAO;
use DAO\BrandDAO;

class HomeController
{
    private ProductDAO $productDAO;
    private CategoryDAO $categoryDAO;
    private PostDAO $postDAO;
    private BrandDAO $brandDAO;
    
    public function __construct()
    {
        $this->productDAO = new ProductDAO();
        $this->categoryDAO = new CategoryDAO();
        $this->postDAO = new PostDAO();
        $this->brandDAO = new BrandDAO();
    }
    
    public function index()
    {
        $title = "MiniShop | Trang chủ";
        
        // Thương hiệu
        $brands = $this->brandDAO->getAll();
        
        // Danh mục nổi bật
        $categories = $this->categoryDAO->getByLimit(4);
        
        // Sản phẩm giảm giá
        $discountProducts = $this->productDAO->getDiscountProducts(12);
        
        // Sản phẩm mới
        $newProducts = $this->productDAO->getNewProducts(12);
        
        // Bài viết
        $posts = $this->postDAO->getActive(3);
        
        ob_start();
        require __DIR__ . "/../../views/client/home/index.php";
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
}
?>
