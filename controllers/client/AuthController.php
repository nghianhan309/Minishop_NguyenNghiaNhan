<?php
namespace Controllers\Client;

use DAO\UserDAO;
use Models\User;

class AuthController
{
    public function login()
    {
        if (isset($_SESSION['client_user'])) {
            header("Location: " . BASE_URL);
            exit;
        }
        
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $dao = new UserDAO();
            $user = $dao->findByUsername($username);
            
            if ($user && $user->password === $password) { // Using plain text to match existing admin logic if it does
                $_SESSION['client_user'] = [
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address
                ];
                header("Location: " . BASE_URL);
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
            }
        }
        
        $pageTitle = "Đăng nhập";
        ob_start();
        require __DIR__ . '/../../views/client/auth/login.php';
        $content = ob_get_clean();
        
        require __DIR__ . '/../../views/client/layouts/master.php';
    }

    public function register()
    {
        if (isset($_SESSION['client_user'])) {
            header("Location: " . BASE_URL);
            exit;
        }

        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';

            if (empty($username) || empty($password) || empty($fullname) || empty($phone)) {
                $error = "Vui lòng nhập đầy đủ thông tin bắt buộc!";
            } else {
                $dao = new UserDAO();
                $existing = $dao->findByUsername($username);
                if ($existing) {
                    $error = "Tên đăng nhập đã tồn tại!";
                } else {
                    $user = new User($fullname, $username, $email, $phone, 2, 1);
                    $user->password = $password;
                    // Insert into users for login
                    if ($dao->insert($user)) {
                        // Also insert into customers so Admin can see them in Customer list
                        $customerDAO = new \DAO\CustomerDAO();
                        $cus = new \Models\Customer($fullname, $phone, $email, $address);
                        $customerDAO->insert($cus);

                        header("Location: " . BASE_URL . "login?success=1");
                        exit;
                    } else {
                        $error = "Có lỗi xảy ra, vui lòng thử lại!";
                    }
                }
            }
        }

        $pageTitle = "Đăng ký";
        ob_start();
        require __DIR__ . '/../../views/client/auth/register.php';
        $content = ob_get_clean();
        
        require __DIR__ . '/../../views/client/layouts/master.php';
    }

    public function logout()
    {
        unset($_SESSION['client_user']);
        header("Location: " . BASE_URL);
        exit;
    }
}
?>
