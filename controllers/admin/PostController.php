<?php
namespace Controllers\Admin;

use DAO\PostDAO;
use Models\Post;
use Middleware\CsrfMiddleware;

class PostController
{
    private PostDAO $postDAO;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
    }

    public function index()
    {
        $posts = $this->postDAO->getAll();
        ob_start();
        require __DIR__ . '/../../views/admin/posts/index.php';
        $content = ob_get_clean();
        require __DIR__ . "/../../views/admin/layouts/master.php";
    }

    public function create()
    {
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            CsrfMiddleware::verify();
            $title = trim($_POST["title"] ?? "");
            $slug = trim($_POST["slug"] ?? "");
            $category_name = trim($_POST["category_name"] ?? "");
            $summary = trim($_POST["summary"] ?? "");
            $content = $_POST["content"] ?? "";
            $status = isset($_POST["status"]) ? 1 : 0;
            
            $image = "";
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $image = time() . "_" . $slug . "." . $ext;
                $uploadPath = __DIR__ . "/../../uploads/posts/";
                if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath . $image);
            }

            if (empty($title)) $errors[] = "Tiêu đề không được trống";
            
            if (empty($errors)) {
                $post = new Post($title, $slug, $category_name, $summary, $content, $image, $status);
                if ($this->postDAO->insert($post) > 0) {
                    header("Location: /MiniShop_NguyenNghiaNhan/admin/post");
                    exit;
                } else {
                    $errors[] = "Thêm thất bại";
                }
            }
        }
        ob_start();
        require __DIR__ . '/../../views/admin/posts/create.php';
        $viewContent = ob_get_clean();
        $content = $viewContent;
        require __DIR__ . "/../../views/admin/layouts/master.php";
    }

    public function edit()
    {
        $id = $_GET["id"] ?? 0;
        $post = $this->postDAO->getById($id);
        if (!$post) die("Không tìm thấy bài viết");

        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            CsrfMiddleware::verify();
            $title = trim($_POST["title"] ?? "");
            $slug = trim($_POST["slug"] ?? "");
            $category_name = trim($_POST["category_name"] ?? "");
            $summary = trim($_POST["summary"] ?? "");
            $postContent = $_POST["content"] ?? "";
            $status = isset($_POST["status"]) ? 1 : 0;
            
            $image = $post->image;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $image = time() . "_" . $slug . "." . $ext;
                $uploadPath = __DIR__ . "/../../uploads/posts/";
                if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath . $image);
            }

            if (empty($title)) $errors[] = "Tiêu đề không được trống";
            
            if (empty($errors)) {
                $post->title = $title;
                $post->slug = $slug;
                $post->category_name = $category_name;
                $post->summary = $summary;
                $post->content = $postContent;
                $post->image = $image;
                $post->status = $status;
                if ($this->postDAO->update($post)) {
                    header("Location: /MiniShop_NguyenNghiaNhan/admin/post");
                    exit;
                } else {
                    $errors[] = "Cập nhật thất bại";
                }
            }
        }
        ob_start();
        require __DIR__ . '/../../views/admin/posts/edit.php';
        $viewContent = ob_get_clean();
        $content = $viewContent;
        require __DIR__ . "/../../views/admin/layouts/master.php";
    }

    public function delete()
    {
        $id = $_GET["id"] ?? 0;
        $this->postDAO->delete($id);
        header("Location: /MiniShop_NguyenNghiaNhan/admin/post");
        exit;
    }
}
?>
