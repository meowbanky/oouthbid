<?php
// Remita API Credentials
$merchantId = '2547916'; // Replace with your Merchant ID
$apiKey = '1946'; // Replace with your API Key

// RRR from the payment response
$rrr = $_GET['RRR']; // This is returned by Remita

// Generate hash for verification
$hashString = $rrr . $apiKey . $merchantId;
$hash = hash('sha512', $hashString);

// Prepare cURL request to check the payment status
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://remitademo.net/remita/ecomm/v1/exapp/api/v1/send/api/echannelsvc/merchant/api/payment/query/" . $rrr . "/" . $merchantId . "/" . $hash);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Process the response
$responseData = json_decode($response, true);

if ($responseData['status'] == "00") {
    echo "Payment successful!";
    // You can now update your database with the payment success information
} else {
    echo "Payment failed or pending. Please try again.";
}
?>
