<?php
// process.php
session_start();

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

$hostname_cov = "localhost";
$database_cov = "oouth_bid";
$username_cov = "root";
$password_cov = "oluwaseyi";

//$_POST['username'] = 'test';
//$_POST['password'] = 'test1';

//Connect to mysql server
	$link = mysql_connect('localhost','root',"oluwaseyi");
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db('oouth_bid', $link);
	if(!$db) {
		die("Unable to select database");
	}



function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$login = clean($_POST['username']);
	$password = clean($_POST['password']);


// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array

    if (empty($_POST['username']))
        $errors['username'] = 'Username is required.';

    if (empty($_POST['password']))
        $errors['password'] = 'Password is required.';

   
// return a response ===========================================================

    // if there are any errors in our errors array, return a success boolean of false

//Create query
	mysql_select_db($database_cov, $link);
	$qry = "SELECT tblusers.lastname, tblusers.UserID,tblusers.first_login,tblusers.Username, tblusers.UPassword FROM tblusers WHERE Username = (UserID = '$login') AND UPassword = password('$password') AND status = 'Active'";
 
	$result = mysql_query($qry,$link) or die(mysql_error());
	$row_qry = mysql_fetch_assoc($result);
	$totalRows_result = mysql_num_rows($result);


    if($result) {
		//echo mysql_num_rows($result);
		if(mysql_num_rows($result) > 0) {
			//Login Successful
			session_regenerate_id();
			//$member = mysql_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $row_qry['UserID'];
			$_SESSION['SESS_FIRST_NAME'] = $row_qry['firstname'];
			$_SESSION['SESS_LAST_NAME'] = $row_qry['lastname'];
			//$_SESSION['role'] = $row_qry['roleid'];
			$_SESSION['password'] = $password;
			//$_SESSION['SESS_PRO_PIC'] = $member['profImage'];
			
			
			if ($row_qry['first_login'] == 0){
				header("location: changePassword.php");
				//exit();
				}
			session_write_close;
			header("location: home.php");
			//exit();
		}else {
			//echo 'Login failed';
			//$errmsg_arr[] = 'Username missing';
//			$errflag = true;
//			if($errflag) {
//		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
//		session_write_close();
//		header("location: index.php");
//		exit();
            
        $data['success'] = false;
        $data['errors']  = $errors;
	}
			//exit();
		}
	

    if ( ! empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process our form, then return a message

        // DO ALL YOUR FORM PROCESSING HERE
        // THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

        // show a message of success and provide a true success variable
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);
?>