<?php

namespace App\Controllers;

use App\App;
use App\Database;
use App\Validator;

class AuthController {
private $App;
private $validator;
private $database;

public $loginCheck;

    public function __construct(App $App) {
    $this->App = $App;
    $this->validator = new Validator($App);
    $this->database = new Database($App);
    }

    public function setSession() {
        // Check if the session is not started
        if (session_status() == PHP_SESSION_NONE) {
            // Start the session
            session_start();
        }
    }
    public function setCookie($userId){

        $token = bin2hex(random_bytes(16));

        // Store the token in the database with user ID and expiration time
        $expiryTime = time() + (30 * 24 * 60 * 60); // 30 days
        $expiryDateTime = date('Y-m-d H:i:s', $expiryTime);
        $stmt = $this->database->insertCookies($userId, $token, $expiryDateTime);
        $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        $cookieOptions = [
            'expires' => $expiryTime,
            'path' => '/',
            'secure' => $isSecure,  // Set to true if HTTPS
            'httponly' => true
        ];
        setcookie('token', $token, $cookieOptions);
    }
    public function checkToken($token)
    {
        $response = [];
        $check = isset($_COOKIE[$token]) ? true : false;
        $response = ["token" => $check];
        echo json_encode($response);
    }
    public function tokenVerify(){

        $token = $_COOKIE['token'];
        $tokenVerify = $this->database->tokenVerify($token);

        if ($tokenVerify) {

            $user = $this->database->getUserByEmail($tokenVerify['contact_mail']);

            $_SESSION['user_id'] = $user['Id'];
            $_SESSION['user_email'] = $user['contact_mail'];
            $_SESSION['profilePicture'] = $user['profile_picture'];
            $_SESSION['company_id'] = $user['company_id'];
            $_SESSION['bid_security'] = $this->database->getSecurityRate();
            $this->loginCheck = true;
            $response = ['status' => 'success',
                'message' => 'Login Successful'] ;
        }else{
            $response = ['status' => 'error',
                'message' => 'Invalid Token\n Use your username/password to login'] ;
        }
        echo json_encode($response);
    }
    public function requestPasswordReset($baseurl) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);

            $this->validator->validateEmail($email);

            if (!$this->validator->hasErrors()) {
                // Check if user exists
                $user = $this->database->getUserByEmail($email);
                if ($user) {
                    // Generate a reset token
                    $resetToken = bin2hex(random_bytes(16));
                    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    // Save the reset token and expiry in the database
                    $this->database->savePasswordResetToken($email, $resetToken, $expiry);

                    // Send reset email
                    $this->sendPasswordResetEmail($email, $resetToken,$baseurl);

                    $response = ['status' => 'success', 'message' => 'Password reset email sent.'];
                    echo json_encode($response);
                } else {
                    $response = ['status' => 'error', 'message' => 'Email not found.'];
                    echo json_encode($response);
                }
            } else {
                $response = ['status' => 'error', 'errors' => $this->validator->getErrors()];
                echo json_encode($response);
            }
        }
    }

    // Reset password after token verification
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resetToken = trim($_POST['token']);
            $newPassword = trim($_POST['password']);
            // Validate new password
            $this->validator->validateNotEmpty($newPassword, 'Password');

            if (!$this->validator->hasErrors()) {
                // Get the reset request from the database
                $resetRequest = $this->database->getPasswordResetRequest($resetToken);

                if ($resetRequest && new DateTime() < new DateTime($resetRequest['expiry'])) {
                    // Token is valid, update the password
                    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                    $this->database->updateUserPassword($resetRequest['email'], $hashedPassword);

                    // Clear the reset token
                    $this->database->clearPasswordResetToken($resetRequest['email']);

                    $response = ['status' => 'success', 'message' => 'Password reset successfully.'];
                    echo json_encode($response);
                } else {
                    $response = ['status' => 'error', 'message' => 'Invalid or expired token.'];
                    echo json_encode($response);
                }
            } else {
                $response = ['status' => 'error', 'errors' => $this->validator->getErrors()];
                echo json_encode($response);
            }
        }
    }

    private function sendPasswordResetEmail($email, $resetToken,$baseurl) {
    $message = '
    <div style="background-color:#f8f8f8;padding-top:40px;padding-bottom:30px">
        <div style="max-width:600px;margin:auto">
            <div style="background-color:#fff;padding:16px;text-align:center">
                <img style="width:120px" src="'.$baseurl.'/assets/images/apple-touch-icon.png" alt="Logo">
            </div>
            <div style="background-color:#fff;padding:20px;color:#222;font-size:14px;line-height:1.4;text-align:center">
                <p>You have requested a pasword reset.  <br>To reset your password, just click the link below:</p>
                <p><a href="'.$baseurl.'/setpassword.php?token=' . $resetToken . '" target="_blank">Click here to reset your password</a></p>
                <p>This link will expire in 24 hours, so be sure to activate your account soon.</p>
                <p>If you did not make this request, you can ignore this email.</p>
            </div>
        </div>
    </div>';
        $this->App->sendEmailWithAttachment($email, 'Password Reset', $message);



    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['email'])) {
                $response = [];
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $rememberMeCheckbox = trim($_POST['rememberMeCheckbox']);

                $this->validator->validateEmail($email);
                $this->validator->validateNotEmpty($password, 'Password');

                if (!$this->validator->hasErrors()) {
                    // Check credentials
                    $user = $this->database->getUserByEmail($email);

                    if ($user && password_verify($password, $user['UPassword'])) {
                        $this->setSession();
                        $_SESSION['user_id'] = $user['Id'];
                        $_SESSION['user_email'] = $user['contact_mail'];
                        $_SESSION['profilePicture'] = $user['profile_picture'];
                        $_SESSION['company_id'] = $user['company_id'];
                        $_SESSION['bid_security'] = $this->database->getSecurityRate();
                        $this->loginCheck = true;
                        if ($rememberMeCheckbox) {
                            $this->setCookie($_SESSION['user_id']);
                        }

                        $response = ['status' => 'success',
                            'message' => 'Login Successful'];
                        echo json_encode($response);

                        // Redirect to user profile or dashboard
                        //header("Location: /user/{$user['id']}");
                        exit;
                    } else {
                        // Invalid credentials
                        $response = ['status' => 'error',
                            'message' => 'Invalid credentials'];
                        echo json_encode($response);
                    }
                } else {
                    $response = ['status' => 'error',
                        'message' => 'Please fix the errors below.',
                        'errors' => $this->validator->getErrors()];
                    echo json_encode($response);
                }
            }
        }
    }

    public function loginCheck() {
        $this->setSession();
        if(!$_SESSION['user_id']){
            header("Location: index.php");
        }
    }
    public function logout() {
        // Clear session and redirect to login page
        session_destroy();
        header("Location: /");
        exit;
    }
}
