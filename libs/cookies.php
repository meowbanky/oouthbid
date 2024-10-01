<?php
require_once __DIR__ . '/../vendor/autoload.php';


use App\App;
use App\Controllers\AuthController;

// Create an instance of the App class
$App = new App();

// Create an instance of the UserController and pass the App instance
$authController = new AuthController($App);

// Call the registerUser method to handle the request
$authController->login();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['act']) & $_POST['act'] === 'tokenlogin') {
        $authController->tokenVerify();
    }

    if(isset($_POST['act']) & $_POST['act'] === 'checkToken') {
        $token = $_POST['token'];
       echo $authController->checkToken($token);
    }
}
