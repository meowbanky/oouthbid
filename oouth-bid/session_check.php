<?php 
session_start();
    if ((!isset($_SESSION['company_id']))||(!isset($_SESSION['SESS_MEMBER_ID']))){
                header("location: index.php");
		exit();
        
    }

?>