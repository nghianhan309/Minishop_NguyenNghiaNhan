<?php
namespace Controllers\Client;

use DAO\ProductDAO;
use DAO\OrderDAO;
use DAO\CustomerDAO;

class CartController
{
    private ProductDAO $productDAO;
    
    public function __construct()
    {
        $this->productDAO = new ProductDAO();
    }
    
    public function index()
    {
        $cart = $_SESSION[CART_SESSION_KEY] ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item["price"] * $item["quantity"];
        }
        
        $title = "Giỏ hàng";
        
        ob_start();
        require __DIR__ . "/../../views/client/cart/index.php";
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
    
    public function add()
    {
        if (!isset($_SESSION[CART_SESSION_KEY])) {
            $_SESSION[CART_SESSION_KEY] = [];
        }
        
        $productid = $_POST["productid"] ?? null;
        if (!$productid) {
            echo json_encode(["success" => false, "message" => "Sản phẩm không hợp lệ"]);
            exit;
        }
        
        $product = $this->productDAO->findById($productid);
        if (!$product) {
            echo json_encode(["success" => false, "message" => "Không tìm thấy sản phẩm"]);
            exit;
        }
        
        $quantity = isset($_POST["quantity"]) ? (int)$_POST["quantity"] : 1;
        if ($quantity <= 0) $quantity = 1;
        
        $price = $product->discount_price > 0 && $product->discount_price < $product->price ? $product->discount_price : $product->price;
        
        if (isset($_SESSION[CART_SESSION_KEY][$productid])) {
            $newQuantity = $_SESSION[CART_SESSION_KEY][$productid]["quantity"] + $quantity;
            if ($newQuantity > $product->quantity) {
                echo json_encode(["success" => false, "message" => "Không thể thêm! Trong kho chỉ còn " . $product->quantity . " sản phẩm."]);
                exit;
            }
            $_SESSION[CART_SESSION_KEY][$productid]["quantity"] = $newQuantity;
        } else {
            if ($quantity > $product->quantity) {
                echo json_encode(["success" => false, "message" => "Không thể thêm! Trong kho chỉ còn " . $product->quantity . " sản phẩm."]);
                exit;
            }
            $_SESSION[CART_SESSION_KEY][$productid] = [
                "productid" => $product->id,
                "productname" => $product->proname,
                "slug" => $product->slug,
                "image" => $product->image,
                "price" => $price,
                "quantity" => $quantity
            ];
        }
        
        $cartCount = $this->getCartCount();
        
        echo json_encode([
            "success" => true,
            "message" => "Đã thêm sản phẩm vào giỏ hàng",
            "cartCount" => $cartCount
        ]);
        exit;
    }
    
    public function update()
    {
        if (!isset($_SESSION[CART_SESSION_KEY])) {
            $_SESSION[CART_SESSION_KEY] = [];
        }
        
        $productid = $_POST["productid"] ?? null;
        $quantity = (int)($_POST["quantity"] ?? 0);
        
        if (!$productid || !isset($_SESSION[CART_SESSION_KEY][$productid])) {
            echo json_encode(["success" => false, "message" => "Sản phẩm không có trong giỏ hàng"]);
            exit;
        }
        
        if ($quantity <= 0) {
            unset($_SESSION[CART_SESSION_KEY][$productid]);
            $itemTotal = 0;
        } else {
            $product = $this->productDAO->findById($productid);
            if ($quantity > $product->quantity) {
                echo json_encode(["success" => false, "message" => "Không thể cập nhật! Trong kho chỉ còn " . $product->quantity . " sản phẩm."]);
                exit;
            }
            $_SESSION[CART_SESSION_KEY][$productid]["quantity"] = $quantity;
            $itemTotal = $_SESSION[CART_SESSION_KEY][$productid]["price"] * $quantity;
        }
        
        $cartCount = $this->getCartCount();
        
        $cartTotal = 0;
        foreach ($_SESSION[CART_SESSION_KEY] as $item) {
            $cartTotal += $item["price"] * $item["quantity"];
        }
        
        echo json_encode([
            "success" => true,
            "message" => "Đã cập nhật giỏ hàng",
            "cartCount" => $cartCount,
            "itemTotal" => number_format($itemTotal) . ' đ',
            "cartTotal" => number_format($cartTotal) . ' đ'
        ]);
        exit;
    }
    
    public function remove()
    {
        if (!isset($_SESSION[CART_SESSION_KEY])) {
            $_SESSION[CART_SESSION_KEY] = [];
        }
        
        $productid = $_POST["productid"] ?? null;
        if ($productid && isset($_SESSION[CART_SESSION_KEY][$productid])) {
            unset($_SESSION[CART_SESSION_KEY][$productid]);
        }
        
        $cartCount = $this->getCartCount();
        $cartTotal = 0;
        foreach ($_SESSION[CART_SESSION_KEY] as $item) {
            $cartTotal += $item["price"] * $item["quantity"];
        }
        
        echo json_encode([
            "success" => true,
            "message" => "Đã xóa sản phẩm khỏi giỏ hàng",
            "cartCount" => $cartCount,
            "cartTotal" => number_format($cartTotal) . ' đ'
        ]);
        exit;
    }
    
    private function getCartCount()
    {
        $cartCount = 0;
        if (isset($_SESSION[CART_SESSION_KEY])) {
            foreach ($_SESSION[CART_SESSION_KEY] as $item) {
                $cartCount += $item["quantity"];
            }
        }
        return $cartCount;
    }
    
    public function count()
    {
        echo json_encode(["cartCount" => $this->getCartCount()]);
        exit;
    }
    
    public function checkout()
    {
        $cart = $_SESSION[CART_SESSION_KEY] ?? [];
        if (empty($cart)) {
            $message = "Giỏ hàng rỗng!";
            echo "<script>alert('$message'); window.location.href='".BASE_URL."cart';</script>";
            return;
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item["price"] * $item["quantity"];
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $customerName = $_POST['customer_name'] ?? '';
            $customerPhone = $_POST['customer_phone'] ?? '';
            $customerAddress = $_POST['customer_address'] ?? '';
            $orderNote = $_POST['order_note'] ?? '';
            $paymentMethod = $_POST['payment_method'] ?? 'COD';
            
            if (empty($customerName) || empty($customerPhone) || empty($customerAddress)) {
                $message = "Vui lòng nhập đầy đủ thông tin!";
                echo "<script>alert('$message'); window.history.back();</script>";
                return;
            }
            
            $shippingMethod = $_POST['shipping_method'] ?? 'standard';
            $shippingFee = ($shippingMethod === 'express') ? 30000 : 0;
            
            $customerEmail = $_POST['customer_email'] ?? '';
            
            $note = "Giao hàng: " . ($shippingMethod === 'express' ? 'Hỏa tốc' : 'Tiêu chuẩn') . " | Phương thức: " . $paymentMethod . " | " . $orderNote;

            $customerData = [
                'fullname' => $customerName,
                'phone' => $customerPhone,
                'address' => $customerAddress,
                'email' => $customerEmail
            ];
            
            $finalTotal = $total + $shippingFee;
            
            $user_id = $_SESSION['client_user']['id'] ?? null;
            $orderDAO = new OrderDAO();
            
            $success_code = $orderDAO->checkoutTransaction($customerData, $cart, $finalTotal, $note, $user_id);
            
            if ($success_code) {
                // Save email to session for email sending later
                if (!empty($customerEmail)) {
                    $_SESSION['temp_order_email'] = $customerEmail;
                    $_SESSION['temp_order_name'] = $customerName;
                }
                
                unset($_SESSION[CART_SESSION_KEY]);
                
                if ($paymentMethod === 'VNPAY') {
                    $returnUrl = "http://" . $_SERVER['HTTP_HOST'] . BASE_URL . "vnpay_return";
                    $vnpUrl = \Config\VNPAY::createPaymentUrl($success_code, $finalTotal, "Thanh toan don hang " . $success_code, $returnUrl);
                    header("Location: " . $vnpUrl);
                    exit;
                } else {
                    // Send Email for COD
                    if (isset($_SESSION['temp_order_email'])) {
                        require_once __DIR__ . "/../../config/mail.php";
                        \Config\MailService::sendOrderConfirmation($_SESSION['temp_order_email'], $_SESSION['temp_order_name'], $success_code, number_format($finalTotal, 0, ',', '.'));
                        unset($_SESSION['temp_order_email']);
                        unset($_SESSION['temp_order_name']);
                    }
                    
                    // Redirect to success page
                    header("Location: " . BASE_URL . "cart/success?orderCode=" . $success_code);
                    exit;
                }
            } else {
                $message = "Lỗi khi đặt hàng! Vui lòng thử lại sau.";
                echo "<script>alert('$message'); window.history.back();</script>";
            }
            return;
        }

        // GET request -> Show Checkout view
        $title = "Thanh toán";
        ob_start();
        require __DIR__ . "/../../views/client/cart/checkout.php";
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
    
    public function vnpayReturn()
    {
        $vnpayData = $_GET;
        $isValid = \Config\VNPAY::verifyReturnUrl($vnpayData);
        
        $title = "Kết quả thanh toán VNPAY";
        ob_start();
        
        if ($isValid) {
            if ($vnpayData['vnp_ResponseCode'] == '00') {
                $orderCode = htmlspecialchars($vnpayData['vnp_TxnRef']);
                $amount = number_format($vnpayData['vnp_Amount'] / 100, 0, ',', '.') . ' VNĐ';
                $bankCode = htmlspecialchars($vnpayData['vnp_BankCode']);
                $transNo = htmlspecialchars($vnpayData['vnp_TransactionNo']);
                
                $payDateRaw = $vnpayData['vnp_PayDate']; // Format: YYYYMMDDHHmmss
                $payDate = date('H:i:s d/m/Y', strtotime(preg_replace('/^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})$/', '$1-$2-$3 $4:$5:$6', $payDateRaw)));

                // Send email if session exists
                if (isset($_SESSION['temp_order_email'])) {
                    require_once __DIR__ . "/../../config/mail.php";
                    \Config\MailService::sendOrderConfirmation($_SESSION['temp_order_email'], $_SESSION['temp_order_name'], $orderCode, $amount);
                    unset($_SESSION['temp_order_email']);
                    unset($_SESSION['temp_order_name']);
                }

                // Optionally update order status to "Paid" via OrderDAO
                $orderDAO = new OrderDAO();
                // We can set status = 2 (Processing/Paid) by finding the order via orderCode
                
                echo "<div class='container mt-5'>
                        <div class='card shadow-sm border-0' style='max-width: 600px; margin: 0 auto;'>
                            <div class='card-body text-center p-5'>
                                <i class='bi bi-check-circle-fill text-success' style='font-size: 4rem;'></i>
                                <h3 class='fw-bold mt-3 text-success'>Thanh toán thành công!</h3>
                                <p class='text-muted mb-4'>Cảm ơn bạn đã mua sắm tại MiniShop. Đơn hàng của bạn đã được ghi nhận.</p>
                                
                                <div class='text-start bg-light p-4 rounded mb-4'>
                                    <h6 class='fw-bold border-bottom pb-2 mb-3'>Thông tin giao dịch</h6>
                                    <div class='d-flex justify-content-between mb-2'>
                                        <span class='text-muted'>Mã đơn hàng:</span>
                                        <span class='fw-bold text-primary'>{$orderCode}</span>
                                    </div>
                                    <div class='d-flex justify-content-between mb-2'>
                                        <span class='text-muted'>Tổng tiền:</span>
                                        <span class='fw-bold text-danger'>{$amount}</span>
                                    </div>
                                    <div class='d-flex justify-content-between mb-2'>
                                        <span class='text-muted'>Ngân hàng thanh toán:</span>
                                        <span class='fw-bold'>{$bankCode}</span>
                                    </div>
                                    <div class='d-flex justify-content-between mb-2'>
                                        <span class='text-muted'>Mã GD VNPAY:</span>
                                        <span>{$transNo}</span>
                                    </div>
                                    <div class='d-flex justify-content-between'>
                                        <span class='text-muted'>Thời gian GD:</span>
                                        <span>{$payDate}</span>
                                    </div>
                                </div>
                                
                                <div class='d-grid gap-2 d-md-flex justify-content-md-center'>
                                    <a href='".BASE_URL."profile' class='btn btn-outline-primary px-4'>Xem đơn hàng</a>
                                    <a href='".BASE_URL."' class='btn btn-success px-4'>Tiếp tục mua sắm</a>
                                </div>
                            </div>
                        </div>
                      </div>";
            } else {
                echo "<div class='alert alert-danger mt-5'>
                        <h4 class='alert-heading'><i class='bi bi-x-circle-fill'></i> Thanh toán thất bại!</h4>
                        <p>Mã lỗi: " . htmlspecialchars($vnpayData['vnp_ResponseCode']) . "</p>
                        <hr>
                        <a href='".BASE_URL."cart' class='btn btn-danger'>Quay lại giỏ hàng</a>
                      </div>";
            }
        } else {
            echo "<div class='alert alert-danger mt-5'>Chữ ký không hợp lệ! Dữ liệu có thể đã bị giả mạo.</div>";
        }
        
        $content = ob_get_clean();
        require __DIR__ . "/../../views/client/layouts/master.php";
    }

    public function success()
    {
        $orderCode = $_GET['orderCode'] ?? '';
        
        $title = "Đặt hàng thành công";
        ob_start();
        require __DIR__ . "/../../views/client/cart/success.php";
        $content = ob_get_clean();
        
        require __DIR__ . "/../../views/client/layouts/master.php";
    }
}
?>
