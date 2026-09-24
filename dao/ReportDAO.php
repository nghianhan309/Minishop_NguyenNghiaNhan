<?php
namespace DAO;

class ReportDAO extends BaseDAO
{
    public function getOverview()
    {
        $data = [
            'total_revenue' => 0,
            'total_orders' => 0,
            'total_customers' => 0,
            'total_products' => 0
        ];
        
        $sql = "SELECT SUM(total_amount) as rev FROM orders WHERE status = 3";
        $res = $this->executeQuery($sql)->fetch_assoc();
        $data['total_revenue'] = $res['rev'] ?? 0;
        
        $sql = "SELECT COUNT(id) as c FROM orders";
        $data['total_orders'] = $this->executeQuery($sql)->fetch_assoc()['c'] ?? 0;
        
        $sql = "SELECT COUNT(id) as c FROM customers";
        $data['total_customers'] = $this->executeQuery($sql)->fetch_assoc()['c'] ?? 0;
        
        $sql = "SELECT COUNT(id) as c FROM products";
        $data['total_products'] = $this->executeQuery($sql)->fetch_assoc()['c'] ?? 0;
        
        return $data;
    }
    
    public function getRevenueByMonth()
    {
        $sql = "SELECT MONTH(created_at) as month, SUM(total_amount) as revenue 
                FROM orders 
                WHERE YEAR(created_at) = YEAR(CURRENT_DATE()) AND status = 3
                GROUP BY MONTH(created_at) 
                ORDER BY month ASC";
        $res = $this->executeQuery($sql);
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function getTopSellingProducts()
    {
        $sql = "SELECT p.proname, p.image, SUM(od.quantity) as total_sold
                FROM order_details od
                JOIN products p ON od.product_id = p.id
                JOIN orders o ON od.order_id = o.id
                WHERE o.status = 3
                GROUP BY p.id
                ORDER BY total_sold DESC
                LIMIT 5";
        $res = $this->executeQuery($sql);
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
?>
