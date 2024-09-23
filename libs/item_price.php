<?php
require_once __DIR__ . '/../vendor/autoload.php';


use App\App;
use App\Controllers\Price;

// Create an instance of the App class
$App = new App();

// Create an instance of the UserController and pass the App instance
$Price = new Price($App);

// Call the registerUser method to handle the request
if(($_SERVER["REQUEST_METHOD"] == "POST") & $_POST["action"] === 'insert'){
    $item_id = $_POST["item_id"];
    $company_id = $_SESSION["company_id"];
    $user_id = $_SESSION["user_id"];
    $Price->insertItem($company_id, $item_id, $user_id);
}
if(($_SERVER["REQUEST_METHOD"] == "POST") & $_POST["action"] === 'total_bidsec'){
    $company_id = $_SESSION["company_id"];
    $rate = floatval(0.05);
    $price =  $Price->showTotalPriceItems($company_id);
    echo number_format(($price * $rate),2);
}
if(($_SERVER["REQUEST_METHOD"] == "POST") & $_POST["action"] === 'bidtotal'){
    $company_id = $_SESSION["company_id"];
   echo  $price =  number_format($Price->showTotalPriceItems($company_id),2);
}

if(($_SERVER["REQUEST_METHOD"] == "POST") & $_POST["action"] === 'delete'){

        $itemPriceId = $_POST['itemPriceId'];
        echo $Price->deletePriceItem($itemPriceId);

}

if(($_SERVER["REQUEST_METHOD"] == "POST") & $_POST["action"] === 'update'){
    $company_id = $_SESSION["company_id"];
    $user_id = $_SESSION["user_id"];
    $item_price_id = $_POST['item_price_id'];
    $column = $_POST['column'];
    $value = $_POST['value'];
    echo  $price =  $Price->updateItem($item_price_id,$column,$value,$company_id,$user_id);
}
