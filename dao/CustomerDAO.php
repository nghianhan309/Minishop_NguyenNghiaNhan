<?php
namespace DAO;

use Config\Database;
use Models\Customer;


class CustomerDAO extends BaseDAO {
    public function getPage(int $limit, int $offset, string $keyword = "", string $sort = ""): array {
        $list = [];
        $sql = "SELECT c.*, u.username FROM customers c LEFT JOIN users u ON c.phone = u.phone AND u.role = 2";
        if ($keyword !== "") {
            $sql .= " WHERE c.fullname LIKE ? OR c.phone LIKE ?";
        }
        
        if ($sort === "name_asc") $sql .= " ORDER BY c.fullname ASC";
        elseif ($sort === "name_desc") $sql .= " ORDER BY c.fullname DESC";
        else $sql .= " ORDER BY c.id DESC";

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
            $b = new Customer($row["fullname"], $row["phone"], $row["email"] ?? null, $row["address"] ?? null);
            $b->note = $row["note"] ?? null;
            $b->username = $row["username"] ?? null;
            $b->id = $row["id"];
            $list[] = $b;
        }
        return $list;
    }

    public function getTotalCount(): int {
        $result = $this->executeQuery("SELECT COUNT(*) as total FROM customers");
        if ($result && $row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }

    public function findById(int $id): ?Customer {
        $result = $this->executeQuery("SELECT * FROM customers WHERE id = $id");
        if ($row = $result->fetch_assoc()) {
            $b = new Customer($row["fullname"], $row["phone"], $row["email"] ?? null, $row["address"] ?? null);
            $b->note = $row["note"] ?? null;
            $b->id = $row["id"];
            return $b;
        }
        return null;
    }

    public function findByPhone(string $phone): ?Customer {
        $sql = "SELECT * FROM customers WHERE phone = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $b = new Customer($row["fullname"], $row["phone"], $row["email"] ?? null, $row["address"] ?? null);
            $b->note = $row["note"] ?? null;
            $b->id = $row["id"];
            return $b;
        }
        return null;
    }
    public function insert(Customer $b): bool {
        $sql = "INSERT INTO customers (fullname, phone, email, address, note) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssss", $b->fullname, $b->phone, $b->email, $b->address, $b->note);
        return $stmt->execute();
    }
    public function update(Customer $b): bool {
        $sql = "UPDATE customers SET fullname=?, phone=?, email=?, address=?, note=? WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssi", $b->fullname, $b->phone, $b->email, $b->address, $b->note, $b->id);
        return $stmt->execute();
    }
    public function delete(int $id): bool {
        return $this->executeQuery("DELETE FROM customers WHERE id = $id") !== false;
    }
}
?>