<?php
namespace Models;

class Brand {
    public int $id = 0;
    public function __construct(
        public string $name,
        public ?string $slug,
        public ?string $image,
        public ?string $description,
        public int $status
    ) {}
}
?>