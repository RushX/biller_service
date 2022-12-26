<?php
require('../api/RazorPay/Razorpay.php');
include "../php/api_includes.php";

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;


$key_id = "rzp_test_rhMIjUVvMXbyMb";
$key_secret = "Uyr1YPlxO92oFAVI75IMf5dH";
error_reporting(0);
$error = "Payment Failed";
$success = false;
if (empty($_POST['razorpay_payment_id']) === false) {
    $api = new Api($keyId, $keySecret);

    try {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)

        $attributes = array(
            'razorpay_order_id' => $_SESSION['orderid'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );
        $api->utility->verifyPaymentSignature($attributes);
        $success = true;
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}


if ($success === true) {
    
    $query="UPDATE bills SET status='paid',pay_id='{$_POST['razorpay_payment_id']}' WHERE bid='{$_POST['bid']}'" ;
    mysqli_query($con, $query);
    echo "<h1>Payment Verified</h1>";
    header("Location: billdownload.php");
}