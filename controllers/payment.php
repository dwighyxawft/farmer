<?php
require('../paystack/src/autoload.php');
use Yabacon\Paystack;
require("../middleware/objects.php");
$objects = new Objects;
$user_id = $_SESSION["user_id"];
$objects->query = "SELECT * FROM orders WHERE buyer_id = '$user_id' AND status = 'pending'";
if($objects->total_rows() > 0){
    $orders = $objects->query_all();
    $all_total = 0;
    foreach($orders as $order){
        $all_total += $order["total"];
    }
}

$objects->query = "SELECT * FROM users WHERE id = '$user_id'";
$user = $objects->query_result();

// Set your Paystack secret key
$secretKey = 'sk_live_58af92d67a993c890713ac20e639ec442169b2ec';

$paystack = new Paystack($secretKey);

// Example: Initialize a transaction
try {
    $transaction = $paystack->transaction->initialize([
        'email' => $user["email"],
        'amount' => $all_total.'00', // Amount in kobo
        'callback_url' => 'http://localhost/farmer/templates/cart.php', 
    ]);

    // Redirect the user to the payment page
    header('Location: ' . $transaction->data->authorization_url);
    exit();
} catch (\Yabacon\Paystack\Exception\ApiException $e) {
    // Handle API errors
    echo 'Error: ' . $e->getMessage();
}

?>


