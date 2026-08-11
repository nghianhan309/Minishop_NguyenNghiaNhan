<?php
$conn = new mysqli('localhost', 'root', '', 'nguyennghianhan_database');
$res = $conn->query("SELECT id, password FROM users");
while($row = $res->fetch_assoc()) {
    $id = $row['id'];
    $pass = $row['password'];
    if (strpos($pass, '$2y$') !== 0) {
        $hashed = password_hash($pass, PASSWORD_BCRYPT);
        if ($conn->query("UPDATE users SET password = '$hashed' WHERE id = $id")) {
            echo "Updated user $id\n";
        } else {
            echo "Failed to update user $id: " . $conn->error . "\n";
        }
    }
}
echo "Done.\n";
?>
