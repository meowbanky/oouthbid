<?php
require __DIR__ . '/../vendor/autoload.php' ;
use App\App;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$baseurl = $_ENV['BASE_URL'];

$App = new App();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $comp_name = trim($_POST['comp_name']);
    $comp_tel  = trim($_POST['comp_tel']);
    $comp_address1 = trim($_POST['comp_address1']);
    $comp_address2 = trim($_POST['comp_address2']);
    $comp_state = trim($_POST['comp_state']);
    $comp_lg = trim($_POST['comp_lg']);
    $comp_email = trim($_POST['comp_email']);

    // Validation
    $errors = [];
    $response = [];

    if (empty($comp_email)) {
        $errors[] = 'Company Email is required';
    } elseif (!filter_var($comp_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }

    if (empty($comp_name)) {
        $errors[] = 'Company Name is required';
    }
    if (empty($comp_tel)) {
        $errors[] = 'Company Telephone no is required';
    }
    if (empty($comp_address1)) {
        $errors[] = 'Company Address is required';
    }
    if (empty($comp_state)) {
        $errors[] = 'State is required';
    }
    if (empty($comp_lg)) {
        $errors[] = 'Local Government is required';
    }

    if (empty($errors)) {
        // Check if the company already exists
        $checkQuery = "SELECT * FROM tbl_company WHERE company_name = :company_name";
        $checkParams = [':company_name' => $comp_name];
        $existingCompany = $App->selectOne($checkQuery, $checkParams);

        if ($existingCompany) {
            $response = [
                'status' => 'error',
                'message' => 'Company already in the system.'
            ];
        } else {
            // Insert the new company into the database
            $query = "INSERT INTO tbl_company (company_name, company_tel, company_address, state, lg, email, editTime) 
                      VALUES (:company_name, :company_tel, :company_address, :state, :lg, :email, NOW())";
            $params = [
                ':company_name' => $comp_name,
                ':company_tel' => $comp_tel,
                ':company_address' => $comp_address1 . ' ' . $comp_address2,
                ':state' => $comp_state,
                ':lg' => $comp_lg,
                ':email' => $comp_email
            ];

            $result = $App->executeNonSelect($query, $params);

            if ($result) {
                $lastInsertId = $App->link->lastInsertId();
                $token = bin2hex(random_bytes(50));

                // Store the token in the database with an expiration date
                $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
                $query = "INSERT INTO account_token (email, token, expiry, company_id) 
                          VALUES (:email, :token, :expiry, :company_id) 
                          ON DUPLICATE KEY UPDATE token=:token, expiry=:expiry";
                $params = [
                    ':email' => $comp_email,
                    ':token' => $token,
                    ':expiry' => $expiry,
                    ':company_id' => $lastInsertId
                ];
                $App->executeNonSelect($query, $params);

                // Send the activation email using PHPMailer
                $resetLink = $baseurl."/token_auth_user.php?token=$token";
                $message = "
                    Dear  $comp_name Team,<br><br>
                    I hope this email finds you well.<br>
                    I am writing to confirm that <strong>$comp_name</strong> has successfully registered on the OOUTH bid platform. We are excited about the opportunity to collaborate and participate in upcoming bidding opportunities.<br><br>
                    Click the link to Activate your account and add a user: <a href=\"$resetLink\">$resetLink</a><br><br>
                    We look forward to participating in upcoming bids.<br><br>
                    Best Regards,<br>OOUTH Bid Platform Team
                ";
                $App->sendEmailWithAttachment($comp_email, "Company Registered", $message);

                $response = [
                    'status' => 'success',
                    'message' => 'Company added successfully.<br> Activation mail has been sent to ' . $comp_email
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Error adding company.'
                ];
            }
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Validation errors occurred.',
            'errors' => $errors
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request.'
    ];
}

echo json_encode($response);
