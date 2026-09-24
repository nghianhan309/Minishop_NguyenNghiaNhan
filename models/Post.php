<?php
namespace Models;

class Post {
    public $id;
    public $title;
    public $slug;
    public $category_name;
    public $summary;
    public $content;
    public $image;
    public $created_at;
    public $status;

    public function __construct($title = null, $slug = null, $category_name = null, $summary = null, $content = null, $image = null, $status = null) {
        if ($title !== null) $this->title = $title;
        if ($slug !== null) $this->slug = $slug;
        if ($category_name !== null) $this->category_name = $category_name;
        if ($summary !== null) $this->summary = $summary;
        if ($content !== null) $this->content = $content;
        if ($image !== null) $this->image = $image;
        if ($status !== null) $this->status = $status;
    }
}
?>
