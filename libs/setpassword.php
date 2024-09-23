<?php
require_once __DIR__ . '/../vendor/autoload.php';


use App\App;
use App\Controllers\UserController;

// Create an instance of the App class
$App = new App();

// Create an instance of the UserController and pass the App instance
$userController = new UserController($App);

// Call the registerUser method to handle the request
$userController->setUserPassword();
