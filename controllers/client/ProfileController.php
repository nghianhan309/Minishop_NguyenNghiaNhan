<?php
namespace Controllers\Client;

use DAO\OrderDAO;
use DAO\CustomerDAO;
use DAO\UserDAO;

class ProfileController
{
    private OrderDAO $orderDAO;
    private CustomerDAO $customerDAO;
    private UserDAO $userDAO;
    
    public function __construct()
    {
        $this->orderDAO = new OrderDAO();
        $this->customerDAO = new CustomerDAO();
        $this->userDAO = new UserDAO();
    }
    
    public function index()
    {
        if (!isset($_SESSION['client_user'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
        
        $userId = $_SESSION['client_user']['id'];
        
        // Cập nhật thông tin nếu có POST request
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullname = $_POST["fullname"] ?? "";
            $phone = $_POST["phone"] ?? "";
            $email = $_POST["email"] ?? "";
            $address = $_POST["address"] ?? "";
            
            $errors = [];
            if (empty($fullname) || empty($phone) || empty($email)) {
                $errors[] = "Họ tên, email và số điện thoại không được để trống!";
            }
            
            if (empty($errors)) {
                $this->userDAO->updateProfile($userId, $fullname, $phone, $email);
                $_SESSION['client_user']['fullname'] = $fullname;
                $_SESSION['client_user']['email'] = $email;
                
                $customer = $this->customerDAO->findByPhone($phone);
                if ($customer) {
                    $customer->fullname = $fullname;
                    $customer->address = $address;
                    $this->customerDAO->update($customer);
                } else {
                    $this->customerDAO->insert($fullname, $phone, $address);
                }
                
                $success_msg = "Cập nhật hồ sơ thành công!";
            }
        }
        
        $user = $this->userDAO->findById($userId);
        
        // Fetch customer address if phone exists
        $customerAddress = "";
        if (!empty($user->phone)) {
            $customer = $this->customerDAO->findByPhone($user->phone);
            if ($customer) {
                $customerAddress = $customer->address;
            }
        }
        $customerEmail = $user->email ?? "";
        
        $orders = $this->orderDAO->getByUserId($userId);
        
        $title = "Hồ sơ cá nhân";
        ob_start();
        require __DIR__ . '/../../views/client/profile/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
    
    public function orderDetail()
    {
        if (!isset($_SESSION['client_user'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
        
        $orderId = $_GET["id"] ?? 0;
        if (!$orderId) {
            header("Location: " . BASE_URL . "profile");
            exit;
        }
        
        $userId = $_SESSION['client_user']['id'];
        $order = $this->orderDAO->findById($orderId);
        
        if (!$order || $order['user_id'] != $userId) {
            $title = "Không tìm thấy đơn hàng";
            ob_start();
            echo "<div class='alert alert-danger'>Đơn hàng không tồn tại hoặc bạn không có quyền xem.</div>";
            $content = ob_get_clean();
            require __DIR__ . "/../../views/client/layouts/master.php";
            return;
        }
        
        $orderDetails = $this->orderDAO->getOrderDetails($orderId);
        
        $title = "Chi tiết đơn hàng #" . htmlspecialchars($order['order_code']);
        ob_start();
        require __DIR__ . '/../../views/client/profile/order_detail.php';
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
    
    public function cancelOrder()
    {
        if (!isset($_SESSION['client_user'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $orderId = (int)($_POST["order_id"] ?? 0);
            $reason = $_POST["cancel_reason"] ?? "Thay đổi ý định";
            
            if ($orderId > 0) {
                $userId = $_SESSION['client_user']['id'];
                $order = $this->orderDAO->findById($orderId);
                
                // Only allow cancellation if order belongs to user and is pending (status 0)
                if ($order && $order['user_id'] == $userId && $order['status'] == 0) {
                    $this->orderDAO->cancelOrder($orderId, $reason);
                    echo "<script>alert('Đã hủy đơn hàng thành công!'); window.location.href='" . BASE_URL . "profile/orderDetail?id=" . $orderId . "';</script>";
                    exit;
                }
            }
        }
        header("Location: " . BASE_URL . "profile");
        exit;
    }
}
?>
