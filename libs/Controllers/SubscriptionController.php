<?php

namespace App\Controllers;


use App\Services\PasswordResetService;
use App\App;
use App\Database;
use App\Emailer;
use App\Validator;

class SubscriptionController {

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

    public function showSubscriptionDetails($companyID){
        return $this->database->getSubscriptionDetailsByCompany($companyID);
    }

    public function saveSubscription($companyID, $subscription,$txRef){
        return $this->database->insertSubscription($companyID, $subscription,$txRef);
    }
    public function showSubscriptionDetailsById($dept_id)
    {
        return $this->database->getSubscriptionById($dept_id);
    }
    public function getAllSubscription($company_id){
        return $this->database->getAvailableSubscriptions($company_id) ;
    }
    public function getAllDeptFromSub($lot_id)
    {
        $dept_lots = $this->database->getDeptFromLot($lot_id);
        $dept = [];
        if ($dept_lots) {
            foreach ($dept_lots as $dept_lot) {
                $dept[] = ['dept_name' => $dept_lot['dept_name']];  // Store each department as an array
            }
        }
        return $dept; // Return an array, not JSON
    }

    public function showCompanyNameById($company_id){
         $company_name = $this->database->getCompanyNameById($company_id);

         return $company_name ? $company_name['company_name'] : null;
    }

    public function showCompanyPhoneById($company_id){
        $Phone = $this->database->getCompanyPhoneById($company_id);

        return $Phone ? $Phone['company_tel'] : null;
    }
    public function showCompanyMailById($company_id){
        $company_mail = $this->database->getCompanyMailById($company_id);

        return $company_mail ? $company_mail['email'] : null;
    }
}
