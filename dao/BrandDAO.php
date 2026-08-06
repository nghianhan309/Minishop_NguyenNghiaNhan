<?php
require_once __DIR__ . "/BaseDAO.php";
class BrandDAO extends BaseDAO {
    public function __construct() { parent::__construct(); }
    public function getTotalCount(): int {
        $result = $this->executeQuery("SELECT COUNT(*) as total FROM brands");
        if ($result && $row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }
    public function getAll(): array {
        $list = [];
        $result = $this->executeQuery("SELECT * FROM brands");
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>