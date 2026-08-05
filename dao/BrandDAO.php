<?php
require_once __DIR__ . "/BaseDAO.php";

class BrandDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalCount(): int
    {
        $sql = "SELECT COUNT(*) as total FROM brands";
        $result = $this->executeQuery($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }

    public function getAll(): array { return []; }
    public function findById(int $id) { return null; }
    public function insert($brand): bool { return false; }
    public function update($brand): bool { return false; }
    public function delete(int $id): bool { return false; }
}
?>
