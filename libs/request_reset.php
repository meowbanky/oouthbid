<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers;
use App\App;
$App = new App();
$Auth = new Controllers\AuthController($App);
$Auth->requestPasswordReset();


?>