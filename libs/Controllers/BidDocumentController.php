<?php

namespace App\Controllers;

use App\App;
use App\Database;
use App\Validator;

class BidDocumentController {

    private $App;
    private $validator;
    private $database;

    public function __construct(App $App) {
        $this->App = $App;
        $this->validator = new Validator($App);
        $this->database = new Database($App);
    }

    public function uploadBidDocument($companyID, $file,$ompany_id) {
        // Validate the file (e.g., file type, size)
        $validationResult = $this->validateFile($file);
        if (!$validationResult['is_valid']) {
            return $validationResult['error'];
        }

        // Generate a unique filename
        $filename = $this->generateUniqueFilename($file['name']);

        // Define the upload path
        $uploadPath = $this->getUploadPath($companyID);

        // Move the file to the upload path
        if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
            // Save the file information to the database
            return $this->database->saveBidDocument($companyID, $filename,$ompany_id);
        } else {
            return 'File upload failed';
        }
    }

    public function deleteDocument($companyID, $documentID) {
        return  $this->database->deleteBidDocument($companyID,$documentID);
    }

    private function validateFile($file) {
        $allowedExtensions =['jpg', 'jpeg', 'png', 'gif'];;
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        // Extract file information
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileSize = $file['size'];

        // Validate file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            return ['is_valid' => false, 'error' => 'Invalid file type'];
        }

        // Validate file size
        if ($fileSize > $maxFileSize) {
            return ['is_valid' => false, 'error' => 'File size exceeds limit'];
        }

        return ['is_valid' => true];
    }

    private function generateUniqueFilename($originalName) {
        return uniqid() . '_' . basename($originalName);
    }

    private function getUploadPath($companyID) {
        // Define the directory path where bid documents will be stored
        $uploadDir = __DIR__ . "/../../uploads/bid_documents/$companyID/";

        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        return $uploadDir;
    }

    public function getBidDocuments($companyID) {
        return $this->database->getBidDocumentsByCompany($companyID);
    }

    public function getBidDocumentTypes() {
        return $this->database->getSelectDocutype();
    }

}
