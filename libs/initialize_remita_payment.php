<?php
// Remita API Credentials
$merchantId = '2547916'; // Replace with your Merchant ID
$apiKey = '1946'; // Replace with your API Key
$serviceTypeId = '4430731'; // Replace with your Service Type ID

// Payment details from the form
$orderId = uniqid(); // Generate a unique order ID
$amount = 3000; //$_POST['amount']; // Payment amount from form
$payerName = 'bankole abiodun';//$_POST['name']; // Payer's name
$payerEmail = 'bankole.adesoji@gmail.com';//$_POST['email']; // Payer's email
$payerPhone = '07039394218';//$_POST['phone']; // Payer's phone number

// Generate the hash (Remita requires this for security)
$hashString = $merchantId . $serviceTypeId . $orderId . $amount . $apiKey;
$hash = hash('sha512', $hashString);

// Prepare the data for the API request
$paymentData = array(
    "merchantId" => $merchantId,
    "serviceTypeId" => $serviceTypeId,
    "totalAmount" => $amount,
    "hash" => $hash,
    "orderId" => $orderId,
    "payerName" => $payerName,
    "payerEmail" => $payerEmail,
    "payerPhone" => $payerPhone,
    "responseurl" => "https://yourwebsite.com/remita_payment_response.php", // URL to handle payment response
);


// Initialize cURL for API request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

// Execute the request
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

// Process the response
$responseData = json_decode($response, true);


if (isset($responseData['RRR'])) {
    // Redirect user to Remita Payment Gateway with the RRR
    $remitaPaymentUrl = "https://remitademo.net/remita/ecomm/finalize.reg?rrr=" . $responseData['RRR'] . "&merchantId=" . $merchantId;
    header("Location: $remitaPaymentUrl");
    exit();
} else {
    echo "Error initializing payment: " . $responseData['message'];
}



function call_getRRRDetails(){
    $credentials = new Credentials();
    $credentials->publicKey = "dC5vbW9udWJpQGdtYWlsLmNvbXxiM2RjMDhjZDRlZTc5ZDIxZDQwMjdjOWM3MmI5ZWY0ZDA3MTk2YTRkNGRkMjY3NjNkMGZkYzA4MjM1MzI4OWFhODE5OGM4MjM0NTI2YWI2ZjZkYzNhZmQzNDNkZmIzYmUwNTkxODlmMmNkOTkxNmM5MjVhNjYwZjk0ZTk1OTkwNw==";
    $billers = new BillerService($credentials);
    $param =new ServiceParam();
    $param->setRequestId(rand());
    $param->setRRR("340007740378");
    $get_billers = $billers->getRRRDetails($param);
    echo json_encode($get_billers);

}
call_getRRRDetails()

?>
