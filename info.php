<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//echo $dbHost = getenv('DBNAME');
// or
echo $dbUser = $_ENV['DBNAME'];


?>