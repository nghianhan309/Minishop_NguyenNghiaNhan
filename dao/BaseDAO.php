<?php
namespace DAO;

use Config\Database;

class BaseDAO extends Database {
    public function __construct() { parent::__construct(); }

    protected function executeQuery(string $sql) { return $this->conn->query($sql); }
    protected function prepare(string $sql) { return $this->conn->prepare($sql); }
    protected function beginTransaction(): void { $this->conn->begin_transaction(); }
    protected function commit(): void { $this->conn->commit(); }
    protected function rollback(): void { $this->conn->rollback(); }
    public function close(): void { if (isset($this->conn)) $this->conn->close(); }

    public function count(string $table, string $column = "", string $keyword = "") {
        if ($keyword == "") {
            $sql = "SELECT COUNT(*) AS total FROM $table";
            $result = $this->conn->query($sql);
            if($result && $row = $result->fetch_assoc()) return (int)$row["total"];
            return 0;
        }
        $sql = "SELECT COUNT(*) AS total FROM $table WHERE $column LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $kw = "%" . $keyword . "%";
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }
}
?>