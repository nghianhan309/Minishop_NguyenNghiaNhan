<?php
require_once __DIR__ . "/BaseDAO.php";
use DAO\BaseDAO;

class User {
    public int $id = 0;
    public ?string $password = null;
    public function __construct(
        public string $fullname,
        public string $username,
        public ?string $email,
        public ?string $phone,
        public int $role,
        public int $status
    ) {}
}

class UserDAO extends BaseDAO {
    public function getPage(int $limit, int $offset, string $keyword = "", string $sort = ""): array {
        $list = [];
        $sql = "SELECT * FROM users";
        if ($keyword !== "") {
            $sql .= " WHERE fullname LIKE ? OR username LIKE ?";
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
            $b = new User($row["fullname"], $row["username"], $row["email"] ?? null, $row["phone"] ?? null, $row["role"], $row["status"]);
            $b->id = $row["id"];
            $list[] = $b;
        }
        return $list;
    }

    public function getTotalCount(): int {
        $result = $this->executeQuery("SELECT COUNT(*) as total FROM users");
        if ($result && $row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }

    public function findByUsername(string $username): ?User {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (!$row) {
            return null;
        }
        $u = new User(
            $row["fullname"],
            $row["username"],
            $row["email"] ?? null,
            $row["phone"] ?? null,
            $row["role"],
            $row["status"]
        );
        $u->id = $row["id"];
        $u->password = $row["password"];
        return $u;
    }

    public function findById(int $id): ?User {
        $result = $this->executeQuery("SELECT * FROM users WHERE id = $id");
        if ($row = $result->fetch_assoc()) {
            $b = new User($row["fullname"], $row["username"], $row["email"] ?? null, $row["phone"] ?? null, $row["role"], $row["status"]);
            $b->id = $row["id"];
            return $b;
        }
        return null;
    }
    public function insert(User $b): bool {
        $sql = "INSERT INTO users (fullname, username, email, phone, role, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssii", $b->fullname, $b->username, $b->email, $b->phone, $b->role, $b->status);
        return $stmt->execute();
    }
    public function update(User $b): bool {
        $sql = "UPDATE users SET fullname=?, username=?, email=?, phone=?, role=?, status=? WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssiii", $b->fullname, $b->username, $b->email, $b->phone, $b->role, $b->status, $b->id);
        return $stmt->execute();
    }
    public function delete(int $id): bool {
        return $this->executeQuery("DELETE FROM users WHERE id = $id") !== false;
    }
}
?>