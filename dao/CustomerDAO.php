<?php
namespace DAO;

use Config\Database;
use Models\Customer;


class CustomerDAO extends BaseDAO {
    public function getPage(int $limit, int $offset, string $keyword = "", string $sort = ""): array {
        $list = [];
        $sql = "SELECT * FROM customers";
        if ($keyword !== "") {
            $sql .= " WHERE fullname LIKE ? OR phone LIKE ?";
        }
        
        if ($sort === "name_asc") $sql .= " ORDER BY fullname ASC";
        elseif ($sort === "name_desc") $sql .= " ORDER BY fullname DESC";
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
            $b = new Customer($row["fullname"], $row["phone"], $row["email"] ?? null, $row["address"] ?? null);
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
            $b->id = $row["id"];
            return $b;
        }
        return null;
    }
    public function insert(Customer $b): bool {
        $sql = "INSERT INTO customers (fullname, phone, email, address) VALUES (?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssss", $b->fullname, $b->phone, $b->email, $b->address);
        return $stmt->execute();
    }
    public function update(Customer $b): bool {
        $sql = "UPDATE customers SET fullname=?, phone=?, email=?, address=? WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssi", $b->fullname, $b->phone, $b->email, $b->address, $b->id);
        return $stmt->execute();
    }
    public function delete(int $id): bool {
        return $this->executeQuery("DELETE FROM customers WHERE id = $id") !== false;
    }
}
?>