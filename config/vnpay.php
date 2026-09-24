<?php
namespace Config;

class VNPAY {
    const TMN_CODE = "HNBOLQGD";
    const HASH_SECRET = "EQUKCJTBOALKMJJVWTBPUTMYCQWWMJAF";
    const URL = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    
    // Tạo link thanh toán
    public static function createPaymentUrl(string $orderId, float $amount, string $orderInfo, string $returnUrl) {
        $vnp_TmnCode = self::TMN_CODE;
        $vnp_HashSecret = self::HASH_SECRET;
        $vnp_Url = self::URL;
        $vnp_Returnurl = $returnUrl;
        
        $vnp_TxnRef = $orderId; 
        $vnp_OrderInfo = $orderInfo;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $amount * 100;
        $vnp_Locale = "vn";
        $vnp_IpAddr = "127.0.0.1"; // $_SERVER['REMOTE_ADDR'] can be ::1 which might cause issues

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis', strtotime('+7 hours', strtotime(gmdate('Y-m-d H:i:s')))),
            "vnp_ExpireDate" => date('YmdHis', strtotime('+7 hours +15 minutes', strtotime(gmdate('Y-m-d H:i:s')))),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        
        return $vnp_Url;
    }
    
    // Kiểm tra checksum khi VNPAY trả về
    public static function verifyReturnUrl(array $vnpayData) {
        $vnp_SecureHash = $vnpayData['vnp_SecureHash'];
        $inputData = array();
        foreach ($vnpayData as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, self::HASH_SECRET);
        return $secureHash === $vnp_SecureHash;
    }
}
?>
