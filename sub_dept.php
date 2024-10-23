<?php


require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers;
use App\App;

$App = new App();
$Auth = new Controllers\AuthController($App);
$Auth->loginCheck();
$company_id = $_SESSION['company_id'];
$Subscription = new Controllers\SubscriptionController($App);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $lot_id = $_POST['lot_id'];
    $deptData = $Subscription->getAllDeptFromSub($lot_id);
    // Check if data is found and return JSON response
    if (!empty($deptData)) {
        echo json_encode([
            'success' => true,
            'data' => $deptData  // Send the array of departments
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => ''
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request. Lot ID is required.'
    ]);
}


