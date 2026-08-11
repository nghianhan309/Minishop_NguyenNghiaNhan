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
                $p = new Product($row["category_id"], $row["brand_id"], $row["proname"], $row["slug"], $row["price"], $row["discount_price"], $row["quantity"], $row["description"], $row["image"], $row["status"]);
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
            $p = new Product($row["category_id"], $row["brand_id"], $row["proname"], $row["slug"], $row["price"], $row["discount_price"], $row["quantity"], $row["description"], $row["image"], $row["status"]);
            $p->id = $row["id"];
            return $p;
        }
        return null;
    }

    public function insert(Product $p): int {
        $sql = "INSERT INTO products(category_id, brand_id, proname, slug, price, discount_price, quantity, description, image, status) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iissddissi", $p->category_id, $p->brand_id, $p->proname, $p->slug, $p->price, $p->discount_price, $p->quantity, $p->description, $p->image, $p->status);
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return 0;
    }

    public function update(Product $p): bool {
        $sql = "UPDATE products SET category_id=?, brand_id=?, proname=?, slug=?, price=?, discount_price=?, quantity=?, description=?, image=?, status=? WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iissddissii", $p->category_id, $p->brand_id, $p->proname, $p->slug, $p->price, $p->discount_price, $p->quantity, $p->description, $p->image, $p->status, $p->id);
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

    
    public function getPage(int $limit, int $offset, string $keyword = "", string $sort = ""): array {
        $list = [];
        $sql = "SELECT p.*, c.catename as cateName, b.brandname as brandName 
                FROM products p 
                INNER JOIN categories c ON p.category_id = c.id 
                INNER JOIN brands b ON p.brand_id = b.id";
        
        if ($keyword !== "") {
            $sql .= " WHERE p.proname LIKE ?";
        }
        
        if ($sort === "price_asc") $sql .= " ORDER BY p.price ASC";
        elseif ($sort === "price_desc") $sql .= " ORDER BY p.price DESC";
        elseif ($sort === "name_asc") $sql .= " ORDER BY p.proname ASC";
        elseif ($sort === "name_desc") $sql .= " ORDER BY p.proname DESC";
        else $sql .= " ORDER BY p.id DESC";

        $sql .= " LIMIT ? OFFSET ?";

        $stmt = $this->prepare($sql);
        if ($keyword !== "") {
            $kw = "%" . $keyword . "%";
            $stmt->bind_param("sii", $kw, $limit, $offset);
        } else {
            $stmt->bind_param("ii", $limit, $offset);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $p = new Product($row["category_id"], $row["brand_id"], $row["proname"], $row["slug"], $row["price"], $row["discount_price"], $row["quantity"], $row["description"], $row["image"], $row["status"]);
            $p->id = $row["id"];
            $p->cateName = $row["cateName"];
            $p->brandName = $row["brandName"];
            $list[] = $p;
        }
        return $list;
    }
    // GALLERY
    public function insertImage(int $productId, string $image): bool {
        $sql = "INSERT INTO product_images(product_id, image) VALUES (?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("is", $productId, $image);
        return $stmt->execute();
    }

    public function getImagesByProductId(int $productId): array {
        $list = [];
        $sql = "SELECT * FROM product_images WHERE product_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
        return $list;
    }

    public function deleteImage(int $id): bool {
        $sql = "DELETE FROM product_images WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>