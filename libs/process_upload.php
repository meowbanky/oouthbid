<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\App;
use App\Controllers\BidDocumentController;

$App = new App();

$bidDocumentController = new BidDocumentController($App);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $companyID = $_SESSION['company_id'];
    $docType = $_POST['docType'];
    $result = $bidDocumentController->uploadBidDocument($companyID, $_FILES['file'],$docType);

    if (is_string($result)) {
        echo "Error: " . $result;
    } else {
        echo "Bid document uploaded successfully!";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['document_id'])) {
    $companyID = $_SESSION['company_id'];
    $document_id = $_POST['document_id'];
    $result = $bidDocumentController->deleteDocument($companyID, $document_id);
    if($result){
        $response = ["status" => "success", "message" => "Document deleted successfully"];
       echo json_encode($response);

    }

}


?>