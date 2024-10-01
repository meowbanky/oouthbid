<?php

use App\App;
use App\Controllers\AuthController;
use App\Database;

require_once __DIR__.'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$clientId = $_ENV['GOOGLE_CLIENT_ID'];
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];

$App =  new App();
$database = new Database($App);
$auth = new AuthController($App);


$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri('https://oouthbid.oouth.com/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

// Exchange authorization code for access token
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Get profile info
    $oauth = new Google_Service_Oauth2($client);
    try {
        $userInfo = $oauth->userinfo->get();
    } catch (\Google\Service\Exception $e) {

    }
        $auth->setSession();

        $user = $database->getUserByEmail( $userInfo->email);


        $_SESSION['user_id'] = $user['Id'];
        $_SESSION['user_email'] = $user['contact_mail'];
//        $_SESSION['profilePicture'] = $user['profile_picture'];
        $_SESSION['company_id'] = $user['company_id'];
        $_SESSION['bid_security'] = $database->getSecurityRate();
        $auth->loginCheck = true;
        // Use $userInfo to get user details like email, name, etc.
        $_SESSION['email'] = $userInfo->email;
        $_SESSION['name'] = $userInfo->name;
        $_SESSION['profilePicture'] = $userInfo->picture;



    // Redirect to a welcome page or wherever you need
    header('Location: subscription.php');
    exit();
} else {
    echo 'Authentication failed.';
}
