<?php
namespace DAO;

use Config\Database;
use Models\Order;


class OrderDAO extends BaseDAO {
    public function __construct() { parent::__construct(); }

    
    public function countOrder(string $keyword = "", string $status = ""): int {
        $sql = "SELECT COUNT(*) AS total FROM orders o JOIN customers c ON o.customer_id = c.id WHERE 1=1";
        $types = ""; $params = [];
        if ($keyword !== "") {
            $sql .= " AND (o.order_code LIKE ? OR c.fullname LIKE ?)";
            $types .= "ss";
            $kw = "%".$keyword."%";
            $params[] = $kw; $params[] = $kw;
        }
        if ($status !== "") {
            $sql .= " AND o.status = ?";
            $types .= "i";
            $params[] = (int)$status;
        }
        if ($types !== "") {
            $stmt = $this->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            if($row = $result->fetch_assoc()) return (int)$row["total"];
        } else {
            $result = $this->executeQuery($sql);
            if($row = $result->fetch_assoc()) return (int)$row["total"];
        }
        return 0;
    }

    public function getPage(int $limit, int $offset, string $keyword = "", string $status = "", string $sort = ""): array {
        $list = [];
        $sql = "SELECT o.*, c.fullname as customer_name FROM orders o JOIN customers c ON o.customer_id = c.id WHERE 1=1";
        $types = ""; $params = [];
        if ($keyword !== "") {
            $sql .= " AND (o.order_code LIKE ? OR c.fullname LIKE ?)";
            $types .= "ss";
            $kw = "%".$keyword."%";
            $params[] = $kw; $params[] = $kw;
        }
        if ($status !== "") {
            $sql .= " AND o.status = ?";
            $types .= "i";
            $params[] = (int)$status;
        }
        
        if ($sort === "amount_asc") $sql .= " ORDER BY o.total_amount ASC";
        elseif ($sort === "amount_desc") $sql .= " ORDER BY o.total_amount DESC";
        elseif ($sort === "date_asc") $sql .= " ORDER BY o.created_at ASC";
        elseif ($sort === "date_desc") $sql .= " ORDER BY o.created_at DESC";
        else $sql .= " ORDER BY o.id DESC";

        $sql .= " LIMIT ? OFFSET ?";
        $types .= "ii";
        $params[] = $limit; $params[] = $offset;

        $stmt = $this->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) $list[] = $row;
        return $list;
    }
    public function getTotalCount(): int {
        $result = $this->executeQuery("SELECT COUNT(*) as total FROM orders");
        if ($result && $row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }

    public function getNewestOrders(int $limit = 5): array {
        $list = [];
        $sql = "SELECT o.*, c.fullname as customer_name FROM orders o JOIN customers c ON o.customer_id = c.id ORDER BY o.created_at DESC LIMIT ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) $list[] = $row;
        return $list;
    }

    public function getAll($keyword = "", $status = ""): array {
        $list = [];
        $sql = "SELECT o.*, c.fullname as customer_name FROM orders o JOIN customers c ON o.customer_id = c.id WHERE 1=1";
        $types = ""; $params = [];
        if ($keyword !== "") {
            $sql .= " AND (o.order_code LIKE ? OR c.fullname LIKE ?)";
            $types .= "ss";
            $kw = "%".$keyword."%";
            $params[] = $kw; $params[] = $kw;
        }
        if ($status !== "") {
            $sql .= " AND o.status = ?";
            $types .= "i";
            $params[] = (int)$status;
        }
        $sql .= " ORDER BY o.id DESC";

        if ($types !== "") {
            $stmt = $this->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->executeQuery($sql);
        }

        while ($row = $result->fetch_assoc()) $list[] = $row;
        return $list;
    }

    public function findById(int $id) {
        $sql = "SELECT o.*, c.fullname as customer_name, c.phone, c.address FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getOrderDetails(int $orderId): array {
        $list = [];
        $sql = "SELECT od.*, p.proname FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $res = $stmt->get_result();
        while($r = $res->fetch_assoc()) $list[] = $r;
        return $list;
    }

    public function updateStatus(int $orderId, int $status): bool {
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $status, $orderId);
        return $stmt->execute();
    }
}
?>