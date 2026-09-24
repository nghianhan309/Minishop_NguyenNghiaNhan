<?php
namespace Controllers\Client;

use DAO\PostDAO;

class PostController
{
    private PostDAO $postDAO;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
    }

    public function detail()
    {
        $slug = $_GET['slug'] ?? '';
        
        $post = $this->postDAO->getBySlug($slug);
        
        if (!$post) {
            die("Bài viết không tồn tại hoặc đã bị ẩn.");
        }
        
        $title = $post->title;
        $heading = $post->title;
        
        // Lấy bài viết liên quan
        $relatedPosts = $this->postDAO->getActive(4);
        
        ob_start();
        require __DIR__ . '/../../views/client/posts/detail.php';
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
}
?>
