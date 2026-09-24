<?php
namespace Config;

if (file_exists(__DIR__ . '/../libs/PHPMailer/src/Exception.php')) {
    require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
    require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    const SMTP_USER = 'nghianhan3092005hi@gmail.com';
    const SMTP_PASS = 'uzmhyvvjrvpkhyoa';

    public static function sendOrderConfirmation($toEmail, $toName, $orderCode, $amount)
    {
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            return false; 
        }

        // Fetch Order Details
        require_once __DIR__ . '/../dao/OrderDAO.php';
        $orderDAO = new \DAO\OrderDAO();
        $order = $orderDAO->findByOrderCode($orderCode);
        
        $itemsHtml = "";
        if ($order) {
            $orderDetails = $orderDAO->getOrderDetails($order['id']);
            foreach ($orderDetails as $item) {
                $subtotal = number_format($item['subtotal'], 0, ',', '.');
                $price = number_format($item['price'], 0, ',', '.');
                $itemsHtml .= "
                <tr>
                    <td style='padding: 10px; border-bottom: 1px solid #eee;'>{$item['proname']}</td>
                    <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: center;'>{$item['quantity']}</td>
                    <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>{$price}đ</td>
                    <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right; font-weight: bold;'>{$subtotal}đ</td>
                </tr>";
            }
        }

        $orderDate = $order ? date('H:i d/m/Y', strtotime($order['created_at'])) : date('H:i d/m/Y');
        $customerPhone = $order['phone'] ?? '';
        $customerAddress = $order['address'] ?? '';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = self::SMTP_USER;
            $mail->Password = self::SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->CharSet = 'UTF-8';

            
            $mail->setFrom(self::SMTP_USER, 'MiniShop System');
            $mail->addAddress($toEmail, $toName);

            $mail->isHTML(true);
            $mail->Subject = 'Xác nhận đơn hàng #' . $orderCode . ' từ MiniShop';

            $html = "
            <div style='font-family: Arial, sans-serif; max-width: 650px; margin: auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
                <div style='background: linear-gradient(135deg, #0d6efd, #0dcaf0); color: white; padding: 30px; text-align: center;'>
                    <h1 style='margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px;'>Xác nhận đơn hàng</h1>
                    <p style='margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;'>Cảm ơn bạn đã tin tưởng và mua sắm tại MiniShop!</p>
                </div>
                
                <div style='padding: 30px;'>
                    <p style='font-size: 16px; color: #333;'>Xin chào <strong>{$toName}</strong>,</p>
                    <p style='font-size: 15px; color: #555; line-height: 1.5;'>Hệ thống đã nhận được đơn đặt hàng của bạn. Dưới đây là thông tin chi tiết về đơn hàng của bạn:</p>
                    
                    <div style='background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 25px 0; border-left: 4px solid #0d6efd;'>
                        <table style='width: 100%; font-size: 14px;'>
                            <tr>
                                <td style='padding-bottom: 8px; color: #666;'>Mã đơn hàng:</td>
                                <td style='padding-bottom: 8px; font-weight: bold; color: #0d6efd;'>{$orderCode}</td>
                            </tr>
                            <tr>
                                <td style='padding-bottom: 8px; color: #666;'>Thời gian đặt:</td>
                                <td style='padding-bottom: 8px; font-weight: bold;'>{$orderDate}</td>
                            </tr>
                            <tr>
                                <td style='padding-bottom: 8px; color: #666;'>Số điện thoại:</td>
                                <td style='padding-bottom: 8px; font-weight: bold;'>{$customerPhone}</td>
                            </tr>
                            <tr>
                                <td style='color: #666;'>Địa chỉ nhận:</td>
                                <td style='font-weight: bold;'>{$customerAddress}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <h3 style='color: #333; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #eee; padding-bottom: 10px;'>Chi tiết sản phẩm</h3>
                    <table style='width: 100%; border-collapse: collapse; font-size: 14px; margin-bottom: 25px;'>
                        <thead>
                            <tr style='background-color: #f8f9fa;'>
                                <th style='padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd;'>Sản phẩm</th>
                                <th style='padding: 12px 10px; text-align: center; border-bottom: 2px solid #ddd;'>SL</th>
                                <th style='padding: 12px 10px; text-align: right; border-bottom: 2px solid #ddd;'>Đơn giá</th>
                                <th style='padding: 12px 10px; text-align: right; border-bottom: 2px solid #ddd;'>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$itemsHtml}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan='3' style='padding: 15px 10px; text-align: right; font-weight: bold; font-size: 16px;'>Tổng cộng:</td>
                                <td style='padding: 15px 10px; text-align: right; font-weight: bold; font-size: 18px; color: #dc3545;'>{$amount} VNĐ</td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <p style='font-size: 14px; color: #666; text-align: center; line-height: 1.6;'>
                        Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua số hotline hoặc phản hồi lại email này.
                    </p>
                </div>
                
                <div style='background-color: #212529; color: #adb5bd; text-align: center; padding: 20px; font-size: 13px;'>
                    <div style='font-weight: bold; color: white; margin-bottom: 5px; font-size: 15px;'>MiniShop</div>
                    &copy; 2026 MiniShop. All rights reserved.<br>
                    Website: http://localhost/MiniShop_NguyenNghiaNhan
                </div>
            </div>";

            $mail->Body = $html;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
?>