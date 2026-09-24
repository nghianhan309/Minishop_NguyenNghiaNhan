<?php
namespace Controllers\Client;

use DAO\CategoryDAO;

class CategoryController
{
    private CategoryDAO $categoryDAO;
    
    public function __construct()
    {
        $this->categoryDAO = new CategoryDAO();
    }
    
    public function index()
    {
        $categories = $this->categoryDAO->getAll(""); 
        
        $title = "Tất cả Danh mục | MiniShop";
        
        ob_start();
        require __DIR__ . '/../../views/client/categories/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
}
?>
