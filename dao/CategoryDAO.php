<?php
require_once __DIR__ . "/BaseDAO.php";
require_once __DIR__ . "/../models/Category.php";

class CategoryDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {
        $list = [];
        try {
            $sql = "SELECT * FROM categories ORDER BY catename";
            $result = $this->executeQuery($sql);
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $category = new Category(
                        $row["catename"],
                        $row["slug"],
                        $row["image"],
                        $row["description"],
                        $row["status"]
                    );
                    $category->id = $row["id"];
                    $category->createdAt = $row["created_at"];
                    $category->updatedAt = $row["updated_at"];
                    $list[] = $category;
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $list;
    }

    public function getTotalCount(): int
    {
        $sql = "SELECT COUNT(*) as total FROM categories";
        $result = $this->executeQuery($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }

    // CRUD methods simplified for brevity, following pattern
    public function findById(int $id): ?Category { return null; }
    public function insert(Category $category): bool { return false; }
    public function update(Category $category): bool { return false; }
    public function delete(int $id): bool { return false; }
}
?>
