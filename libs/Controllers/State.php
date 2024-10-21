<?php

namespace App\Controllers;

use App\App;
use App\Database;

class State
{
    private $App;
    private $database;
    public function __construct(App $App){
        $this->App = $App;
        $this->database = new Database($App);
    }

    public function showState(){
        return $this->database->getAllState();
    }

}