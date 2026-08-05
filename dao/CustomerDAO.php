<?php
require_once __DIR__ . "/BaseDAO.php";

class CustomerDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalCount(): int
    {
        $sql = "SELECT COUNT(*) as total FROM customers";
        $result = $this->executeQuery($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }

    public function getAll(): array { return []; }
    public function findById(int $id) { return null; }
    public function insert($customer): bool { return false; }
    public function update($customer): bool { return false; }
    public function delete(int $id): bool { return false; }
}
?>
