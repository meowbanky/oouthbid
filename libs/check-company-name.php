<?php
require_once __DIR__ . '/../vendor/autoload.php';


use App\App;
use App\Controllers\UserController;
use App\Validator;

// Create an instance of the App class
$App = new App();
$Validator = new Validator($App);

// Create an instance of the UserController and pass the App instance
$userController = new UserController($App);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
$baseurl = $_ENV['BASE_URL'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["companyName"])) {
        $companyName = $_POST["companyName"];
        $Validator->validateExisting('tbl_company', 'company_name', $companyName, 'company_name');
        if (!$Validator->hasErrors()) {
            $response = [
                'status' => 'success',
                'message' => 'Company name available'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Company already exists',
                'errors' => $Validator->getErrors()
            ];
        }
        echo json_encode($response);
    }

    if (isset($_POST["comp_email"])) {
        $comp_email = $_POST["comp_email"];
        $Validator->validateExisting('tbl_company', 'email', $comp_email, 'email');
        if (!$Validator->hasErrors()) {
            $response = [
                'status' => 'success',
                'message' => 'Company email available'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Company email exists',
                'errors' => $Validator->getErrors()
            ];
        }
        echo json_encode($response);
    }
}

