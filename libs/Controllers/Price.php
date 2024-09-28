<?php

namespace App\Controllers;

use App\App;
use App\Database;
use App\Emailer;
use App\Validator;

class Price
{
    private $App;
    private $validator;
    private $database;
    private $emailer;

    public function __construct(App $App) {
        $this->App = $App;
        $this->validator = new Validator($App);
        $this->database = new Database($App);
        $this->emailer = new Emailer($App);
    }

    public function showPriceItemsByCompany($company_id){
        return $this->database->getCompanyPrice($company_id);
    }

    public function showBiddedDept($company_id){
     return $this->database->getBidedDept($company_id);
    }

    public function insertItem($company_id, $item_id,$user_id){
            return $this->database->insertItemsPrice($company_id, $item_id,$user_id);
    }

    public function showTotalPriceItems($company_id){
        return $this->database->getTotalPriceItems($company_id);
    }
    public function showBidSecurity($company_id,$rate): float|string
    {
        return $this->database->calBidSec($company_id,$rate);
    }
    public function updateItem($item_price_id,$column,$value,$company_id,$user_id){
        return $this->database->updateItem($item_price_id,$column,$value,$company_id,$user_id);
    }

    public function deletePriceItem($itemPriceId){
        return $this->database->deleteItemPrice($itemPriceId);
    }

}