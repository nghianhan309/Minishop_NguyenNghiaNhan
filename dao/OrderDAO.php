<?php
require_once __DIR__ . "/BaseDAO.php";

class OrderDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalCount(): int
    {
        $sql = "SELECT COUNT(*) as total FROM orders";
        $result = $this->executeQuery($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }

    public function getNewestOrders(int $limit = 5): array
    {
        $list = [];
        try {
            $sql = "SELECT o.*, c.fullname as customer_name 
                    FROM orders o 
                    JOIN customers c ON o.customer_id = c.id 
                    ORDER BY o.created_at DESC LIMIT ?";
            $stmt = $this->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $limit);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $list[] = $row;
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $list;
    }

    public function getAll(): array { return []; }
    public function findById(int $id) { return null; }
    public function insert($order): bool { return false; }
    public function update($order): bool { return false; }
    public function delete(int $id): bool { return false; }
}
?>
