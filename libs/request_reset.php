<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers;
use App\App;
$App = new App();
$Auth = new Controllers\AuthController($App);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$baseurl = $_ENV['BASE_URL'];
$Auth->requestPasswordReset($baseurl);


?>