<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers;
use App\App;
use App\Validator;

$App = new App();
$company_id = $_SESSION['company_id'];
$Subscription = new Controllers\SubscriptionController($App);
$validator = new Validator($App);
$subSelects = $Subscription->getAllSubscription($company_id);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sub_id = trim($_GET['subscriptionId']);
    $validator->validateNotEmpty($sub_id, 'Subscription ID');

if (!$validator->hasErrors()) {

$amounts = $Subscription->showSubscriptionDetailsById($sub_id );
$subDetails = $Subscription->showSubscriptionDetailsById($sub_id );
$subDetail = $subDetails['dept'];

$companyName    = $Subscription->showCompanyNameById($_SESSION['company_id']);
    // process_payment.php

// Include Flutterwave API details
    $flutterwavePublicKey = $_ENV['FLUTTERWAVE_PUBLIC_KEY'];
    $flutterwaveSecretKey = $_ENV['FLUTTERWAVE_SECRET_KEY'];
    $currency = "NGN"; // Example currency
    $amount = $amounts['price']; // Get the price from the form
    $email = $Subscription->showCompanyMailById($_SESSION['company_id']);
    $subscriptionId = $sub_id; // Get the subscription ID
    $tx_ref = "TX-" . uniqid() . "-sub-" . $subscriptionId;

// Generate payment link using Flutterwave API
    $data = [
        "tx_ref" => $tx_ref, // Unique transaction reference
        "amount" => $amount,
        "currency" => $currency,
        "redirect_url" => "http://localhost:3000/oouth_bid/payment-callback.php", // Callback URL after payment
        "customer" => [
            "email" => $email,
            "phonenumber" => "1234567890",
            "name" => $companyName
        ],
        "customizations" => [
            "title" => "Payment for Subscription",
            "description" => "Payment for subscription ID: " . $subDetail
        ]
    ];

// Call Flutterwave API to create a payment link
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.flutterwave.com/v3/payments");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $flutterwaveSecretKey",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if ($responseData['status'] === 'success') {
        $paymentLink = $responseData['data']['link'];
        header("Location: $paymentLink"); // Redirect to the payment link in a new tab
    } else {
        echo "Payment initiation failed. Please try again.";
    }


}else{
    $errors = $validator->getErrors();
}
}



?>
