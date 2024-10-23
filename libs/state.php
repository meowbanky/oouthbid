<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers;
use App\App;

$App = new App();
$state = new Controllers\State($App);



$states = $state->showState();

foreach ($states as $state){
    echo $state['id'].' - '.$state['name'].'<br>';
}