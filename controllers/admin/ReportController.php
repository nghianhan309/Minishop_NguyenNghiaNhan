<?php
namespace Controllers\Admin;

use DAO\ReportDAO;
use Middleware\RoleMiddleware;

class ReportController
{
    public function __construct()
    {
        RoleMiddleware::checkAdmin();
    }

    public function index()
    {
        $pageTitle = "Báo cáo thống kê";
        
        $dao = new ReportDAO();
        $overview = $dao->getOverview();
        
        // Prepare data for Chart.js
        $monthlyRevenueRaw = $dao->getRevenueByMonth();
        $months = [];
        $revenues = [];
        // Init 12 months with 0
        for ($i = 1; $i <= 12; $i++) {
            $months[] = "Tháng $i";
            $revenues[$i] = 0;
        }
        
        foreach ($monthlyRevenueRaw as $row) {
            $revenues[(int)$row['month']] = (float)$row['revenue'];
        }
        $revenueData = array_values($revenues);
        
        $topProducts = $dao->getTopSellingProducts();
        
        ob_start();
        require __DIR__ . '/../../views/admin/reports/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . '/../../views/admin/layouts/master.php';
    }
}
?>
