<?php
namespace DAO;

use Config\Database;
use Models\Brand;


class BrandDAO extends BaseDAO {
    public function getPage(int $limit, int $offset, string $keyword = "", string $sort = ""): array {
        $list = [];
        $sql = "SELECT * FROM brands";
        if ($keyword !== "") {
            $sql .= " WHERE brandname LIKE ? OR slug LIKE ?";
        }
        
        if ($sort === "name_asc") $sql .= " ORDER BY brandname ASC";
        elseif ($sort === "name_desc") $sql .= " ORDER BY brandname DESC";
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
            $b = new Brand($row["brandname"], $row["slug"] ?? null, $row["image"] ?? null, $row["description"] ?? null, $row["status"] ?? 1);
            $b->id = $row["id"];
            $list[] = $b;
        }
        return $list;
    }

    public function getTotalCount(): int {
        $result = $this->executeQuery("SELECT COUNT(*) as total FROM brands");
        if ($result && $row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }

    public function getAll(): array {
        $list = [];
        $result = $this->executeQuery("SELECT * FROM brands ORDER BY brandname ASC");
        while ($row = $result->fetch_assoc()) {
            $b = new Brand($row["brandname"], $row["slug"] ?? null, $row["image"] ?? null, $row["description"] ?? null, $row["status"] ?? 1);
            $b->id = $row["id"];
            $list[] = $b;
        }
        return $list;
    }

    public function findById(int $id): ?Brand {
        $result = $this->executeQuery("SELECT * FROM brands WHERE id = $id");
        if ($row = $result->fetch_assoc()) {
            $b = new Brand($row["brandname"], $row["slug"] ?? null, $row["image"] ?? null, $row["description"] ?? null, $row["status"] ?? 1);
            $b->id = $row["id"];
            return $b;
        }
        return null;
    }
    public function insert(Brand $b): bool {
        $sql = "INSERT INTO brands (brandname, slug, image, description, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssi", $b->name, $b->slug, $b->image, $b->description, $b->status);
        return $stmt->execute();
    }
    public function update(Brand $b): bool {
        $sql = "UPDATE brands SET brandname=?, slug=?, image=?, description=?, status=? WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssii", $b->name, $b->slug, $b->image, $b->description, $b->status, $b->id);
        return $stmt->execute();
    }
    public function delete(int $id): bool {
        return $this->executeQuery("DELETE FROM brands WHERE id = $id") !== false;
    }
}
?>