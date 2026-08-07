<?php
class Product {
    public int $id;
    public int $category_id;
    public int $brand_id;
    public string $proname;
    public string $slug;
    public float $price;
    public float $discount_price;
    public int $quantity;
    public ?string $description;
    public ?string $image;
    public int $status;
    public ?string $cateName; 
    public ?string $brandName;

    public function __construct(int $category_id=0, int $brand_id=0, string $proname="", string $slug="", float $price=0, float $discount_price=0, int $quantity=0, ?string $description=null, ?string $image=null, int $status=1) {
        $this->category_id = $category_id;
        $this->brand_id = $brand_id;
        $this->proname = $proname;
        $this->slug = $slug;
        $this->price = $price;
        $this->discount_price = $discount_price;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->image = $image;
        $this->status = $status;
    }
}
?>