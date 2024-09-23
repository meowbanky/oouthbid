<?php
session_start();
// process.php


    
$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array

    if (empty($_POST['username']))
        $errors['name'] = 'Username is required.';

    if (empty($_POST['password']))
        $errors['password'] = 'Password is required.';

    

// return a response ===========================================================

    // if there are any errors in our errors array, return a success boolean of false
    if ( ! empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process our form, then return a message

        // DO ALL YOUR FORM PROCESSING HERE
        // THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

        // show a message of success and provide a true success variable
        
        
        $hostname_cov = "localhost";
        $database_cov = "oouth_bid";
        $username_cov = "root";
        $password_cov = "Oluwaseyi";

//$_POST['username'] = 'test';
//$_POST['password'] = 'test1';

//Connect to mysql server
	$link = mysqli_connect('localhost','root',"Oluwaseyi");
	if(!$link) {
		die('Failed to connect to server: ' . mysqli_error($link));
	}
	
	//Select database
	$db = mysqli_select_db($link,'oouth_bid');
	if(!$db) {
		die("Unable to select database");
	}



function clean($str,$link) {
		$str = @trim($str);

			$str = stripslashes($str);

		return mysqli_real_escape_string($link,$str);
	}
	
	//Sanitize the POST values
	$login = clean($_POST['username'],$link);
	$password = clean($_POST['password'],$link);


// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array

   
   
// return a response ===========================================================

    // if there are any errors in our errors array, return a success boolean of false

//Create query
	mysqli_select_db($link, $database_cov);
	$qry = "SELECT
tblusers.lastname,
tblusers.firstname,
tblusers.UserID,
tblusers.first_login,
tblusers.company_id,
tblusers.Username,
tblusers.UPassword,
tbl_company.company_name,
tbl_company.company_address,
tbl_role.role
FROM
tblusers
LEFT JOIN tbl_company ON tblusers.company_id = tbl_company.company_id
INNER JOIN tbl_role ON tbl_role.roleid = tblusers.roleid WHERE Username  = '$login'  AND tbl_company.status = 1";
 
	$result = mysqli_query($link,$qry) or die(mysqli_error($link));
	$row_qry = mysqli_fetch_assoc($result);
	$totalRows_result = mysqli_num_rows($result);

         if($result) {
             if(mysqli_num_rows($result) > 0) {
             session_regenerate_id();
            $_SESSION['SESS_MEMBER_ID'] = $row_qry['UserID'];
			$_SESSION['SESS_FIRST_NAME'] = $row_qry['firstname'];
			$_SESSION['SESS_LAST_NAME'] = $row_qry['lastname'];
            $_SESSION['companyName'] =   $row_qry['company_name'];   
			$_SESSION['company_id'] = $row_qry['company_id'];
            $_SESSION['role']   = $row_qry['role']; 
            $_SESSION['password'] = $password;
                 
                 if($row_qry['first_login'] == 0){
                     
                $errors['FirstLogin'] = 'Your need to change your Password';  
                $data['errors']  = $errors;
                 
               $data['success'] = false;
               $data['message'] = 'Your need to change your Password';
                
                 }else{
                 
                 $data['success'] = 'true';
                 $data['message'] = 'Successfully Login';
               } 
             
             }else{
                 
                $errors['InvalidCredentials'] = 'Invalid Username or Password';  
                $data['errors']  = $errors;
                 
               $data['success'] = false;
               $data['message'] = 'Invalid Username/Password';
                 
             }
             
    
         }
        
        
        
        
        
        // = $totalRows_result; //'Success!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);
?>