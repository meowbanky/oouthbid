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
