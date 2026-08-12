<?php
namespace Models;

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
?>
