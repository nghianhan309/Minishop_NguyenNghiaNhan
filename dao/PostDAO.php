<?php
namespace DAO;
use Models\Post;

class PostDAO extends BaseDAO {
    public function getAll() {
        $sql = "SELECT * FROM posts ORDER BY id DESC";
        $result = $this->conn->query($sql);
        $list = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_object('\Models\Post')) {
                $list[] = $row;
            }
        }
        return $list;
    }

    public function getActive($limit = 3) {
        $sql = "SELECT * FROM posts WHERE status = 1 ORDER BY id DESC LIMIT $limit";
        $result = $this->conn->query($sql);
        $list = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_object('\Models\Post')) {
                $list[] = $row;
            }
        }
        return $list;
    }

    public function getById($id) {
        $sql = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            return $result->fetch_object('\Models\Post');
        }
        return null;
    }

    public function getBySlug($slug) {
        $sql = "SELECT * FROM posts WHERE slug = ? AND status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            return $result->fetch_object('\Models\Post');
        }
        return null;
    }

    public function insert(Post $post) {
        $sql = "INSERT INTO posts (title, slug, category_name, summary, content, image, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssi", $post->title, $post->slug, $post->category_name, $post->summary, $post->content, $post->image, $post->status);
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return 0;
    }

    public function update(Post $post) {
        $sql = "UPDATE posts SET title=?, slug=?, category_name=?, summary=?, content=?, image=?, status=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssii", $post->title, $post->slug, $post->category_name, $post->summary, $post->content, $post->image, $post->status, $post->id);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
