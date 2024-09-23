<?php
	//Start session
	session_start();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
    $hostname_cov = "localhost";
    $database_cov = "emmaggic_cofv";
    $username_cov = "root";
    $password_cov = "oluwaseyi";
	
	//Connect to mysql server
	$link = mysql_connect('localhost','root',"oluwaseyi");
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db('emmaggic_cofv', $link);
	if(!$db) {
		die("Unable to select database");
	}
	
	//Function to sanitize values received from the form. Prevents SQL injection
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
	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Username missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit();
	}
	
	$hostname_hms = "localhost";
	$database_hms = "emmaggic_cofv";
	$username_hms = "root";
	$password_hms = "oluwaseyi";
	$hms = mysql_pconnect($hostname_hms, $username_hms, $password_hms) or trigger_error(							mysql_error(),E_USER_ERROR); 
	
	//Create query
	mysql_select_db($database_hms, $hms);
	$qry = "SELECT tblusers.lastname, tblusers.Username, tblusers.UPassword FROM tblusers WHERE Username = '' AND UPassword = ''
 WHERE ((UserID = '$login') OR (tbl_personalinfo.MobilePhone = '$login')) AND (Upassword = password('$password') AND tbl_personalinfo.status = 'Active')";
	$result = mysql_query($qry,$hms) or die(mysql_error());
	$row_qry = mysql_fetch_assoc($result);
	$totalRows_result = mysql_num_rows($result);
	
	
	
	// $row1=mysql_fetch_array($result);
	

	//Check whether the query was successful or not
	if($result) {
		
		if(mysql_num_rows($result) > 0) {
			//Login Successful
			session_regenerate_id();
			//$member = mysql_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $row_qry['UserID'];
			$_SESSION['SESS_FIRST_NAME'] = $row_qry['firstname'];
			$_SESSION['SESS_LAST_NAME'] = $row_qry['lastname'];
			$_SESSION['role'] = $row_qry['roleid'];
			$_SESSION['password'] = $password;
			//$_SESSION['SESS_PRO_PIC'] = $member['profImage'];
			
			
			if ($row_qry['first_login'] == 0){
				header("location: changePassword.php");
				exit();
				}
			session_write_close;
			header("location: home.php");
			exit();
		}else {
			//echo 'Login failed';
			$errmsg_arr[] = 'Username missing';
			$errflag = true;
			if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit();
	}
			exit();
		}
	}else {
		die("Query failed");
	}
?>