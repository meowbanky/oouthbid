<?php

namespace App\Controllers;

use App\App;
use App\Database;
use App\Emailer;
use App\Validator;

class Controller {

    private $App;
    private $validator;
    private $database;
    private $emailer;

    public function __construct(App $App) {
        $this->App = $App;
        $this->validator = new Validator($App);
        $this->database = new Database($App);
        $this->emailer = new Emailer($App);
    }

//    public function registerUser() {
//        $response = [];
//
//        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//            $LoggingEmailAddress = trim($_POST['LoggingEmailAddress']);
//            $company_id  = trim($_POST['company_id']);
//            $user_firstname = trim($_POST['user_firstname']);
//            $user_lastname = trim($_POST['user_lastname']);
//            $user_mobile = trim($_POST['user_mobile']);
//            $token  = trim($_POST['token']);
//
//            $this->validator->validateEmail($LoggingEmailAddress);
//            $this->validator->validateNotEmpty($company_id, 'Company ID');
//            $this->validator->validateNotEmpty($user_firstname, 'First name');
//            $this->validator->validateNotEmpty($user_lastname, 'Last name');
//            $this->validator->validateMobile($user_mobile);
//
//            if (!$this->validator->hasErrors()) {
//                $tokenCheck = $this->App->tokenCheck($token);
//                if ($tokenCheck) {
//                    $user_id = $this->database->insertUser($user_lastname, $LoggingEmailAddress, $user_firstname, $user_mobile);
//                    $this->database->insertUserCompany($company_id, $user_id);
//
//                    $newToken = bin2hex(random_bytes(50));
//                    $expiry = date('Y-m-d H:i:s', strtotime('+2 hours'));
//                    $this->database->insertPasswordReset($LoggingEmailAddress, $newToken, $expiry);
//
//                    $this->emailer->sendActivationEmail($LoggingEmailAddress, $newToken);
//
//                    $this->database->passwordToken($LoggingEmailAddress, $newToken, $expiry);
//                    $this->database->updateCompanyToken($newToken);
//
//                    $response = [
//                        'status' => 'success',
//                        'message' => 'User added successfully.<br> Activation mail has been sent to ' . $LoggingEmailAddress
//                    ];
//                } else {
//                    $response = [
//                        'status' => 'error',
//                        'message' => 'Registration could not be completed due to Invalid token'
//                    ];
//                }
//            } else {
//                $response = [
//                    'status' => 'error',
//                    'message' => 'Registration could not be completed due to invalid input',
//                    'errors' => $this->validator->getErrors()
//                ];
//            }
//        } else {
//            $response = [
//                'status' => 'error',
//                'message' => 'Invalid Route',
//            ];
//        }
//
//        echo json_encode($response);
//    }
}
