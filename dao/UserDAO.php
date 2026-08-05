<?php
require_once __DIR__ . "/BaseDAO.php";

class UserDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array { return []; }
    public function findById(int $id) { return null; }
    public function insert($user): bool { return false; }
    public function update($user): bool { return false; }
    public function delete(int $id): bool { return false; }
}
?>
