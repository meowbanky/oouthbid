<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers;
use App\App;

$App = new App();
$company_id = $_SESSION['company_id'];
$Subscription = new Controllers\SubscriptionController($App);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$baseurl = $_ENV['BASE_URL'];

// Include Flutterwave API details
$flutterwaveSecretKey = "FLWSECK_TEST-c2422d3d33df001cb20c77bdf78ffb77-X";

// Check if Flutterwave redirected with transaction_id
if (!isset($_GET['transaction_id'])) {
    die('No transaction ID provided');
}

$transactionId = $_GET['transaction_id'];

// Verify the transaction using Flutterwave's API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.flutterwave.com/v3/transactions/$transactionId/verify");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $flutterwaveSecretKey"
]);

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);

if ($responseData['status'] === 'success' && $responseData['data']['status'] === 'successful') {
    // Payment was successful
    $amountPaid = $responseData['data']['amount'];
    $currency = $responseData['data']['currency'];
    $txRef = $responseData['data']['tx_ref'];

    $parts = explode("-sub-", $txRef);
    $subscription_id = end($parts);
    $company_id = $_SESSION['company_id'];


    // TODO: Update your database with the payment status

    $amounts = $Subscription->showSubscriptionDetailsById($subscription_id);
    $amount = $amounts['price'];
    if(($amountPaid == $amount)&& ($currency == 'NGN')) {
        $Subscription->saveSubscription($subscription_id, $company_id, $txRef);

        // Redirect the user to a success page or show a success message
//    header("Location: https://your-website.com/payment-success.php?tx_ref=$txRef");
//        echo "<h1>Payment Successful!</h1>";
//        echo "<p>Thank you for your payment. Your transaction reference is $txRef.</p>";
//        exit();
    }else{
//        echo "<h1>Payment Unsuccessful!</h1>";
//        echo "<p>Error Processing your Payment</p>";
//        exit();
    }
} else {
    // Payment failed or was not successful
    // Redirect the user to a failure page or show an error message
    header("Location: https://your-website.com/payment-failure.php");
//    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Callback</title>
    <script>
        window.onload = function() {
            // Get the original tab reference (if any)
            const originalTab = window.opener;

            // Check if the original tab exists
            if (originalTab) {
                // Send a message to the original tab indicating payment success
                originalTab.postMessage('payment_success', '*');

                // Optionally, close the current tab
                window.close();
            } else {
                alert('Original tab not found. Please return to the previous tab.');
            }
        };
    </script>
</head>
<body>
<h1>Payment Successful!</h1>
</body>
</html>
