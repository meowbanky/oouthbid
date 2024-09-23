<?php
session_start();

// Check for required session variables
if (!isset($_SESSION['SESS_MEMBER_ID']) || trim($_SESSION['SESS_MEMBER_ID']) == '') {
    header("location: index.php");
    exit();
}

if (!isset($_SESSION['company_id'])) {
    header("location: index.php");
    exit();
}

$documentType = $_POST['documentType'] ?? null;

if ($documentType === null) {
    die('Document type not specified.');
}

// Database connection parameters
$hostname_bid = "localhost";
$database_bid = "oouth_bid";
$username_bid = "root";
$password_bid = "Oluwaseyi";

// Create a new mysqli connection
$link = new mysqli($hostname_bid, $username_bid, $password_bid, $database_bid);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Function to escape SQL values
function GetSQLValueString($theValue, $theType, $link)
{
    $theValue = $link->real_escape_string($theValue);

    switch ($theType) {
        case "text":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "long":
        case "int":
            $theValue = ($theValue != "") ? intval($theValue) : "NULL";
            break;
        case "double":
            $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
            break;
        case "date":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "defined":
            $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
            break;
    }
    return $theValue;
}

// File upload logic
if (isset($_FILES["file"]["type"])) {
    $validextensions = array("jpeg", "jpg", "png");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);
    if (in_array($file_extension, $validextensions) && ($_FILES["file"]["size"] < 500000)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            if (file_exists("upload/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
            } else {
                $date = date("Ymds");
                $ext = end($temporary);
                $sourcePath = $_FILES['file']['tmp_name'];
                $targetPath = "upload/" . $date . '.' . $ext;

                if (move_uploaded_file($sourcePath, $targetPath)) {
                    $documentTypeEscaped = GetSQLValueString($documentType, "text", $link);
                    $targetPathEscaped = GetSQLValueString($targetPath, "text", $link);
                    $companyIdEscaped = GetSQLValueString($_SESSION['company_id'], "text", $link);

                    $insertSQL = "INSERT INTO tbl_document (document_path, document_type, company_id) VALUES ($targetPathEscaped, $documentTypeEscaped, $companyIdEscaped)";

                    if ($link->query($insertSQL) === TRUE) {
                        echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
                    } else {
                        echo "Error: " . $insertSQL . "<br>" . $link->error;
                    }
                } else {
                    echo "Error uploading file.";
                }
            }
        }
    } else {
        echo "<span id='invalid'>***Invalid file Size or Type***<span>";
    }
} else {
    echo "No file uploaded.";
}

// Close the connection
$link->close();
?>
