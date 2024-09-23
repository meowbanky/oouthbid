<?php

namespace App\Controllers;

use App\App;
use App\Database;
use App\Validator;

class AuthController {
private $App;
private $validator;
private $database;

private $loginCheck;

    public function __construct(App $App) {
    $this->App = $App;
    $this->validator = new Validator();
    $this->database = new Database($App);
    }

    public function setSession() {
        // Check if the session is not started
        if (session_status() == PHP_SESSION_NONE) {
            // Start the session
            session_start();
        }
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = [];
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

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

                $response = ['status' => 'success',
                    'message' => 'Login Successful'] ;
                echo json_encode($response);

                // Redirect to user profile or dashboard
                //header("Location: /user/{$user['id']}");
                exit;
                } else {
                // Invalid credentials
                    $response = ['status' => 'error',
                              'message' => 'Invalid credentials'] ;
                    echo json_encode($response);
                }
            } else {
                 $response = ['status' => 'error',
                'message' => 'Please fix the errors below.',
                     'errors' => $this->validator->getErrors()] ;
                echo json_encode($response);
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
