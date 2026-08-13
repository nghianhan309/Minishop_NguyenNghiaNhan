<?php
namespace Models;

class Customer {
    public int $id = 0;
    public function __construct(
        public string $fullname,
        public string $phone,
        public ?string $email,
        public ?string $address
    ) {}
}
?>