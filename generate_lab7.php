<?php
// Generator for Lab 7

$baseDir = __DIR__ . '/';

function makeDir($dir) {
    if (!is_dir($dir)) mkdir($dir, 0777, true);
}

// 1. Update CategoryDAO
$categoryDaoCode = '<?php
require_once __DIR__ . "/BaseDAO.php";
require_once __DIR__ . "/../models/Category.php";

class CategoryDAO extends BaseDAO
{
    public function __construct() { parent::__construct(); }

    public function getAll($keyword = ""): array {
        $list = [];
        try {
            $sql = "SELECT * FROM categories";
            if (!empty($keyword)) {
                $sql .= " WHERE catename LIKE ? OR slug LIKE ?";
            }
            $sql .= " ORDER BY catename";
            
            if (!empty($keyword)) {
                $stmt = $this->prepare($sql);
                $kw = "%" . $keyword . "%";
                $stmt->bind_param("ss", $kw, $kw);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $this->executeQuery($sql);
            }

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $category = new Category($row["catename"], $row["slug"], $row["image"], $row["description"], $row["status"]);
                    $category->id = $row["id"];
                    $category->createdAt = $row["created_at"];
                    $category->updatedAt = $row["updated_at"];
                    $list[] = $category;
                }
            }
        } catch (Exception $e) { throw $e; }
        return $list;
    }

    public function findById(int $id): ?Category {
        try {
            $sql = "SELECT * FROM categories WHERE id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $category = new Category($row["catename"], $row["slug"], $row["image"], $row["description"], $row["status"]);
                $category->id = $row["id"];
                $category->createdAt = $row["created_at"];
                $category->updatedAt = $row["updated_at"];
                return $category;
            }
        } catch (Exception $e) { throw $e; }
        return null;
    }

    public function insert(Category $category): bool {
        try {
            $sql = "INSERT INTO categories(catename,slug,description,status) VALUES(?,?,?,?)";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("sssi", $category->name, $category->slug, $category->description, $category->status);
            return $stmt->execute();
        } catch (Exception $e) { throw $e; }
    }

    public function update(Category $category): bool {
        try {
            $sql = "UPDATE categories SET catename=?, slug=?, description=?, status=? WHERE id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("sssii", $category->name, $category->slug, $category->description, $category->status, $category->id);
            return $stmt->execute();
        } catch (Exception $e) { throw $e; }
    }

    public function delete(int $id): bool {
        try {
            $sql = "DELETE FROM categories WHERE id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) { throw $e; }
    }

    public function getTotalCount(): int {
        $sql = "SELECT COUNT(*) as total FROM categories";
        $result = $this->executeQuery($sql);
        if ($result && $row = $result->fetch_assoc()) { return (int)$row["total"]; }
        return 0;
    }
}
?>';
file_put_contents($baseDir . 'dao/CategoryDAO.php', $categoryDaoCode);

// 2. Product Model & DAO
$productModelCode = '<?php
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
    public int $status;
    public ?string $cateName; 
    public ?string $brandName;

    public function __construct(int $category_id=0, int $brand_id=0, string $proname="", string $slug="", float $price=0, float $discount_price=0, int $quantity=0, ?string $description=null, int $status=1) {
        $this->category_id = $category_id;
        $this->brand_id = $brand_id;
        $this->proname = $proname;
        $this->slug = $slug;
        $this->price = $price;
        $this->discount_price = $discount_price;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->status = $status;
    }
}
?>';
file_put_contents($baseDir . 'models/Product.php', $productModelCode);

$productDaoCode = '<?php
require_once __DIR__ . "/BaseDAO.php";
require_once __DIR__ . "/../models/Product.php";

class ProductDAO extends BaseDAO {
    public function __construct() { parent::__construct(); }

    public function getAll($keyword = ""): array {
        $list = [];
        $sql = "SELECT p.*, c.catename as cateName, b.brandname as brandName 
                FROM products p 
                INNER JOIN categories c ON p.category_id = c.id 
                INNER JOIN brands b ON p.brand_id = b.id";
        if (!empty($keyword)) {
            $sql .= " WHERE p.proname LIKE ?";
        }
        $sql .= " ORDER BY p.id DESC";

        if (!empty($keyword)) {
            $stmt = $this->prepare($sql);
            $kw = "%" . $keyword . "%";
            $stmt->bind_param("s", $kw);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->executeQuery($sql);
        }

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $p = new Product($row["category_id"], $row["brand_id"], $row["proname"], $row["slug"], $row["price"], $row["discount_price"], $row["quantity"], $row["description"], $row["status"]);
                $p->id = $row["id"];
                $p->cateName = $row["cateName"];
                $p->brandName = $row["brandName"];
                $list[] = $p;
            }
        }
        return $list;
    }

    public function findById(int $id): ?Product {
        $sql = "SELECT * FROM products WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $p = new Product($row["category_id"], $row["brand_id"], $row["proname"], $row["slug"], $row["price"], $row["discount_price"], $row["quantity"], $row["description"], $row["status"]);
            $p->id = $row["id"];
            return $p;
        }
        return null;
    }

    public function insert(Product $p): bool {
        $sql = "INSERT INTO products(category_id, brand_id, proname, slug, price, discount_price, quantity, description, status) VALUES(?,?,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iissddisi", $p->category_id, $p->brand_id, $p->proname, $p->slug, $p->price, $p->discount_price, $p->quantity, $p->description, $p->status);
        return $stmt->execute();
    }

    public function update(Product $p): bool {
        $sql = "UPDATE products SET category_id=?, brand_id=?, proname=?, slug=?, price=?, discount_price=?, quantity=?, description=?, status=? WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iissddisii", $p->category_id, $p->brand_id, $p->proname, $p->slug, $p->price, $p->discount_price, $p->quantity, $p->description, $p->status, $p->id);
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getTotalCount(): int {
        $result = $this->executeQuery("SELECT COUNT(*) as total FROM products");
        if ($result && $row = $result->fetch_assoc()) return (int)$row["total"];
        return 0;
    }

    public function getNewestProducts(int $limit = 5): array {
        $list = [];
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
        return $list;
    }
}
?>';
file_put_contents($baseDir . 'dao/ProductDAO.php', $productDaoCode);

// 3. Category Views
$catIndexCode = '<?php
$pageTitle = "Danh sách danh mục";
require_once "../../dao/CategoryDAO.php";
$dao = new CategoryDAO();

if (isset($_POST["btnDelete"])) {
    $dao->delete((int)$_POST["id"]);
}

$keyword = trim($_GET["keyword"] ?? "");
$categories = $dao->getAll($keyword);
ob_start();
?>
<h2>Danh sách danh mục</h2>
<a href="create.php" class="btn btn-success mb-3">Thêm mới</a>
<form class="row mb-3" method="GET">
    <div class="col-md-4">
        <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa..." value="<?= htmlspecialchars($keyword) ?>">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </div>
</form>
<table class="table table-bordered">
    <thead><tr><th>STT</th><th>Tên danh mục</th><th>Slug</th><th>Trạng thái</th><th>Chức năng</th></tr></thead>
    <tbody>
        <?php $stt = 1; foreach ($categories as $item): ?>
        <tr>
            <td><?= $stt++ ?></td>
            <td><?= htmlspecialchars($item->name) ?></td>
            <td><?= htmlspecialchars($item->slug) ?></td>
            <td><?= $item->status == 1 ? "<span class=\"badge bg-success\">Hiển thị</span>" : "<span class=\"badge bg-secondary\">Ẩn</span>" ?></td>
            <td>
                <a href="detail.php?id=<?= $item->id ?>" class="btn btn-info btn-sm">Chi tiết</a>
                <a href="edit.php?id=<?= $item->id ?>" class="btn btn-warning btn-sm">Sửa</a>
                <form method="POST" class="d-inline" onsubmit="return confirm(\'Bạn có chắc muốn xóa?\');">
                    <input type="hidden" name="id" value="<?= $item->id ?>">
                    <button type="submit" name="btnDelete" class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>';
file_put_contents($baseDir . 'views/admin/categories/index.php', $catIndexCode);

$catCreateCode = '<?php
$pageTitle = "Thêm danh mục";
require_once "../../dao/CategoryDAO.php";
$dao = new CategoryDAO();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cateName = trim($_POST["cateName"] ?? "");
    $slug = trim($_POST["slug"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $status = $_POST["status"] ?? 1;

    if ($cateName == "") $errors[] = "Tên danh mục không được để trống.";
    if ($slug == "") $errors[] = "Slug không được để trống.";

    if (empty($errors)) {
        $cat = new Category($cateName, $slug, null, $description, $status);
        if ($dao->insert($cat)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Thêm thất bại.";
        }
    }
}
ob_start();
?>
<h2>Thêm danh mục</h2>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
<?php endif; ?>
<form method="POST">
    <div class="mb-3">
        <label>Tên danh mục</label>
        <input type="text" name="cateName" class="form-control" value="<?= htmlspecialchars($_POST["cateName"] ?? "") ?>">
    </div>
    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($_POST["slug"] ?? "") ?>">
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($_POST["description"] ?? "") ?></textarea>
    </div>
    <div class="mb-3">
        <label>Trạng thái</label>
        <input type="radio" name="status" value="1" checked> Hiển thị
        <input type="radio" name="status" value="0"> Ẩn
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</form>
<?php $content = ob_get_clean(); include "../layouts/master.php"; ?>';
file_put_contents($baseDir . 'views/admin/categories/create.php', $catCreateCode);

echo "Basic files generated.";
?>
