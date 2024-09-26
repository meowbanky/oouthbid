<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (!defined('HOST')) {
    define('HOST', $_ENV['HOST']);
}
if (!defined('DBNAME')) {
    define('DBNAME', $_ENV['DBNAME']);
}
if (!defined('DB_USER')) {
    define('DB_USER', $_ENV['DB_USER']);
}
if (!defined('PASS')) {
    define('PASS', $_ENV['PASS']);
}

if (!defined('HOST_MAIL')) {
    define('HOST_MAIL', $_ENV['HOST_MAIL']);
}
if (!defined('USERNAME_MAIL')) {
    define('USERNAME_MAIL', $_ENV['USERNAME_MAIL']);
}
if (!defined('PASSWORD_MAIL')) {
    define('PASSWORD_MAIL', $_ENV['PASSWORD_MAIL']);
}
if(!defined('FROM_EMAIL')) {
    define('FROM_EMAIL',$_ENV['FROM_EMAIL']);
}
// config.php
//define('BASE_URL', 'http://localhost:8000/tascesalary/');


?>
