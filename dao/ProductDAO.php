<?php
require_once __DIR__ . "/BaseDAO.php";
require_once __DIR__ . "/../models/Product.php";

class ProductDAO extends BaseDAO {
    public function __construct() { parent::__construct(); }

    public function getAll($keyword = ""): array {
        $list = [];
        $sql = "SELECT p.*, c.catename as cateName, b.brandname as brandName 
                FROM products p 
                INNER JOIN categories c ON p.category_id = c.id 
                INNER JOIN brands b ON p.brand_id = b.id";
        if (!empty($keyword)) {
            $sql .= " WHERE p.proname LIKE ?";
        }
        $sql .= " ORDER BY p.id DESC";

        if (!empty($keyword)) {
            $stmt = $this->prepare($sql);
            $kw = "%" . $keyword . "%";
            $stmt->bind_param("s", $kw);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->executeQuery($sql);
        }

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $p = new Product($row["category_id"], $row["brand_id"], $row["proname"], $row["slug"], $row["price"], $row["discount_price"], $row["quantity"], $row["description"], $row["status"]);
                $p->id = $row["id"];
                $p->cateName = $row["cateName"];
                $p->brandName = $row["brandName"];
                $list[] = $p;
            }
        }
        return $list;
    }

    public function findById(int $id): ?Product {
        $sql = "SELECT * FROM products WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $p = new Product($row["category_id"], $row["brand_id"], $row["proname"], $row["slug"], $row["price"], $row["discount_price"], $row["quantity"], $row["description"], $row["status"]);
            $p->id = $row["id"];
            return $p;
        }
        return null;
    }

    public function insert(Product $p): bool {
        $sql = "INSERT INTO products(category_id, brand_id, proname, slug, price, discount_price, quantity, description, status) VALUES(?,?,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iissddisi", $p->category_id, $p->brand_id, $p->proname, $p->slug, $p->price, $p->discount_price, $p->quantity, $p->description, $p->status);
        return $stmt->execute();
    }

    public function update(Product $p): bool {
        $sql = "UPDATE products SET category_id=?, brand_id=?, proname=?, slug=?, price=?, discount_price=?, quantity=?, description=?, status=? WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iissddisii", $p->category_id, $p->brand_id, $p->proname, $p->slug, $p->price, $p->discount_price, $p->quantity, $p->description, $p->status, $p->id);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getTotalCount(): int {
        $result = $this->executeQuery("SELECT COUNT(*) as total FROM products");
        if ($result && $row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }

    public function getNewestProducts(int $limit = 5): array {
        $list = [];
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
        return $list;
    }
}
?>