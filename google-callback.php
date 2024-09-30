<?php
session_start();
require_once __DIR__.'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$clientId = $_ENV('GOOGLE_CLIENT_ID');
$clientSecret = $_ENV('GOOGLE_CLIENT_SECRET');


$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri('http://oouthbid.oouth.com/google-callback.php');
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

    // Use $userInfo to get user details like email, name, etc.
    $_SESSION['email'] = $userInfo->email;
    $_SESSION['name'] = $userInfo->name;
    $_SESSION['picture'] = $userInfo->picture;

    // Redirect to a welcome page or wherever you need
    header('Location: subscription.php');
    exit();
} else {
    echo 'Authentication failed.';
}
