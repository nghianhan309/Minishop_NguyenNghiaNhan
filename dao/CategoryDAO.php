<?php
require_once __DIR__ . "/BaseDAO.php";
require_once __DIR__ . "/../models/Category.php";

class CategoryDAO extends BaseDAO
{
    public function __construct() { parent::__construct(); }

    public function getAll($keyword = ""): array {
        $list = [];
        try {
            $sql = "SELECT * FROM categories";
            if (!empty($keyword)) {
                $sql .= " WHERE catename LIKE ? OR slug LIKE ?";
            }
            $sql .= " ORDER BY catename";
            
            if (!empty($keyword)) {
                $stmt = $this->prepare($sql);
                $kw = "%" . $keyword . "%";
                $stmt->bind_param("ss", $kw, $kw);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $this->executeQuery($sql);
            }

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $category = new Category($row["catename"], $row["slug"], $row["image"], $row["description"], $row["status"]);
                    $category->id = $row["id"];
                    $category->createdAt = $row["created_at"];
                    $category->updatedAt = $row["updated_at"];
                    $list[] = $category;
                }
            }
        } catch (Exception $e) { throw $e; }
        return $list;
    }

    public function findById(int $id): ?Category {
        try {
            $sql = "SELECT * FROM categories WHERE id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $category = new Category($row["catename"], $row["slug"], $row["image"], $row["description"], $row["status"]);
                $category->id = $row["id"];
                $category->createdAt = $row["created_at"];
                $category->updatedAt = $row["updated_at"];
                return $category;
            }
        } catch (Exception $e) { throw $e; }
        return null;
    }

    public function insert(Category $category): bool {
        try {
            $sql = "INSERT INTO categories(catename,slug,description,status) VALUES(?,?,?,?)";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("sssi", $category->name, $category->slug, $category->description, $category->status);
            return $stmt->execute();
        } catch (Exception $e) { throw $e; }
    }

    public function update(Category $category): bool {
        try {
            $sql = "UPDATE categories SET catename=?, slug=?, description=?, status=? WHERE id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("sssii", $category->name, $category->slug, $category->description, $category->status, $category->id);
            return $stmt->execute();
        } catch (Exception $e) { throw $e; }
    }

    public function delete(int $id): bool {
        try {
            $sql = "DELETE FROM categories WHERE id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) { throw $e; }
    }

    
    public function getPage(int $limit, int $offset, string $keyword = "", string $sort = ""): array {
        $list = [];
        $sql = "SELECT * FROM categories";
        
        if ($keyword !== "") {
            $sql .= " WHERE catename LIKE ? OR slug LIKE ?";
        }
        
        if ($sort === "name_asc") $sql .= " ORDER BY catename ASC";
        elseif ($sort === "name_desc") $sql .= " ORDER BY catename DESC";
        else $sql .= " ORDER BY id DESC";

        $sql .= " LIMIT ? OFFSET ?";

        $stmt = $this->prepare($sql);
        if ($keyword !== "") {
            $kw = "%" . $keyword . "%";
            $stmt->bind_param("ssii", $kw, $kw, $limit, $offset);
        } else {
            $stmt->bind_param("ii", $limit, $offset);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $c = new Category($row["catename"], $row["slug"], $row["image"], $row["description"], $row["status"]);
            $c->id = $row["id"];
            $c->createdAt = $row["created_at"];
            $list[] = $c;
        }
        return $list;
    }
    public function getTotalCount(): int {
        $sql = "SELECT COUNT(*) as total FROM categories";
        $result = $this->executeQuery($sql);
        if ($result && $row = $result->fetch_assoc()) { return (int)$row["total"]; }
        return 0;
    }
}
?>