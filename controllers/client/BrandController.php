<?php
namespace Controllers\Client;

use DAO\BrandDAO;

class BrandController
{
    private BrandDAO $brandDAO;
    
    public function __construct()
    {
        $this->brandDAO = new BrandDAO();
    }
    
    public function index()
    {
        $brands = $this->brandDAO->getAll(""); 
        
        $title = "Tất cả Thương hiệu | MiniShop";
        
        ob_start();
        require __DIR__ . '/../../views/client/brands/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
}
?>
