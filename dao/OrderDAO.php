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
            $sql .= " AND (o.order_code LIKE ? OR c.fullname LIKE ? OR c.phone LIKE ?)";
            $types .= "sss";
            $kw = "%".$keyword."%";
            $params[] = $kw; $params[] = $kw; $params[] = $kw;
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
            $sql .= " AND (o.order_code LIKE ? OR c.fullname LIKE ? OR c.phone LIKE ?)";
            $types .= "sss";
            $kw = "%".$keyword."%";
            $params[] = $kw; $params[] = $kw; $params[] = $kw;
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

    public function getByUserId(int $userId): array {
        $list = [];
        $sql = "SELECT o.*, c.fullname as customer_name, c.phone, c.address FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.user_id = ? ORDER BY o.created_at DESC";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
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

    public function findByOrderCode(string $code) {
        $sql = "SELECT o.*, c.fullname as customer_name, c.phone, c.address FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.order_code = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $code);
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

    public function updateStatus(int $id, int $status): bool {
        $sql = "UPDATE orders SET status=? WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $status, $id);
        return $stmt->execute();
    }

    public function updateOrder(int $orderId, int $status, string $note): bool {
        $sql = "UPDATE orders SET status = ?, note = ? WHERE id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("isi", $status, $note, $orderId);
        return $stmt->execute();
    }
    
    public function cancelOrder(int $id, string $reason): bool {
        // Status 4 for Cancelled
        $sql = "UPDATE orders SET status=4, note=CONCAT(COALESCE(note, ''), ?) WHERE id=?";
        $stmt = $this->prepare($sql);
        $cancelNote = "\n[Khách hủy]: " . $reason;
        $stmt->bind_param("si", $cancelNote, $id);
        return $stmt->execute();
    }

    public function checkoutTransaction(array $customerData, array $cart, float $total, string $note, ?int $user_id = null, string $order_code = ""): ?string {
        try {
            $this->beginTransaction();

            // 1. Check or create Customer
            $customer_id = null;
            $stmt = $this->prepare("SELECT id FROM customers WHERE phone = ?");
            $stmt->bind_param("s", $customerData['phone']);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $customer_id = $row['id'];
            } else {
                $stmtInsertCus = $this->prepare("INSERT INTO customers (fullname, phone, address) VALUES (?, ?, ?)");
                $stmtInsertCus->bind_param("sss", $customerData['fullname'], $customerData['phone'], $customerData['address']);
                if (!$stmtInsertCus->execute()) {
                    throw new \Exception("Cannot create customer");
                }
                $customer_id = $stmtInsertCus->insert_id;
            }

            // 2. Create Order
            $order_code = "TEMP";
            
            if ($user_id !== null) {
                $stmtInsertOrder = $this->prepare("INSERT INTO orders (order_code, customer_id, user_id, total_amount, note, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, 0, NOW(), NOW())");
                $stmtInsertOrder->bind_param("siids", $order_code, $customer_id, $user_id, $total, $note);
            } else {
                $stmtInsertOrder = $this->prepare("INSERT INTO orders (order_code, customer_id, total_amount, note, status, created_at, updated_at) VALUES (?, ?, ?, ?, 0, NOW(), NOW())");
                $stmtInsertOrder->bind_param("sids", $order_code, $customer_id, $total, $note);
            }
            if (!$stmtInsertOrder->execute()) {
                throw new \Exception("Cannot create order: " . $this->conn->error);
            }
            $order_id = $stmtInsertOrder->insert_id;
            
            // Generate real order code
            $real_order_code = sprintf("ORD%03d", $order_id);
            $stmtUpdateOrderCode = $this->prepare("UPDATE orders SET order_code = ? WHERE id = ?");
            $stmtUpdateOrderCode->bind_param("si", $real_order_code, $order_id);
            $stmtUpdateOrderCode->execute();
            
            // 3. Create Order Details
            $stmtInsertDetail = $this->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
            $stmtUpdateStock = $this->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
            
            foreach ($cart as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                $stmtInsertDetail->bind_param("iiidd", $order_id, $item['productid'], $item['quantity'], $item['price'], $subtotal);
                if (!$stmtInsertDetail->execute()) {
                    throw new \Exception("Cannot insert order details: " . $this->conn->error);
                }
                
                $stmtUpdateStock->bind_param("ii", $item['quantity'], $item['productid']);
                if (!$stmtUpdateStock->execute()) {
                    throw new \Exception("Cannot update product quantity: " . $this->conn->error);
                }
            }

            $this->commit();
            return $real_order_code;
        } catch (\Exception $e) {
            $this->rollback();
            file_put_contents(__DIR__ . '/../error_log.txt', $e->getMessage() . "\n", FILE_APPEND);
            return null;
        }
    }
}
?>