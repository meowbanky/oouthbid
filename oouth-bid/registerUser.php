<?php require_once('Connections/bid.php'); ?>
<?php
include ('session_check.php');
	
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$col_Edit_record = "-1";
if (isset($_GET['id'])) {
$col_Edit_record = $_GET['id'];
}




if ((isset($_POST["MM_update"]))&& ($_POST["MM_update"] == "update")) {
  $updateSQL = sprintf("UPDATE people SET first_name=%s, last_name=%s, phone_number=%s, email=%s, address_1=%s, address_2=%s, city=%s, `state`=%s, country=%s, comments=%s WHERE person_id=%s",
                       GetSQLValueString($_POST['first_name'], "text"),
                       GetSQLValueString($_POST['last_name'], "text"),
                       GetSQLValueString($_POST['phone_number'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['address_1'], "text"),
                       GetSQLValueString($_POST['address_2'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($col_Edit_record, "int"));

  mysql_select_db($database_bid, $bid);
  $Result1 = mysql_query($updateSQL, $bid) or die(mysql_error());
  
  

  $updateSQL2 = sprintf("UPDATE employees SET username=%s, password=%s, role=%s, position=%s, deleted=%s WHERE person_id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                        GetSQLValueString($_POST['role'], "text"),
						GetSQLValueString($_POST['role'], "text"),
						GetSQLValueString($_POST['deleted'], "text"),
					   GetSQLValueString($col_Edit_record, "int"));

 // mysql_select_db($database_pos, $pos);
  $Result2 = mysql_query($updateSQL2, $bid) or die(mysql_error());
 

						
	$insertGoTo = "registerUser.php";
  if (isset($_SERVER['QUERY_STRING'])) {
     }
  //header(sprintf("Location: %s", $insertGoTo));
  
}




if ((isset($_POST["MM_insert"]))){ //&& ($_POST["MM_insert"] == "employee_form")) {
  $insertCompanySQL = sprintf("INSERT INTO tbl_company
 (tbl_company.company_name,tbl_company.company_tel,tbl_company.email,tbl_company.company_address,tbl_company.state,tbl_company.lg) VALUES (%s, %s, %s,%s, %s, %s)",
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['company_tel'], "text"),
                       GetSQLValueString($_POST['comp_email'], "text"),
					   GetSQLValueString($_POST['company_address_1'], "text"),
                       GetSQLValueString($_POST['company_state'], "text"),
                       GetSQLValueString($_POST['company_lg'], "text"));

  mysql_select_db($database_bid, $bid);
  $Result1 = mysql_query($insertCompanySQL, $bid) or die(mysql_error());
    
    $company_id = mysql_insert_id();
    
    $insertUserSQL = sprintf("INSERT INTO tblusers
 (tblusers.firstname,tblusers.lastname,tblusers.contact_mail,tblusers.contact_mobile,tblusers.company_id,tblusers.Username,tblusers.UPassword,tblusers.CPassword,tblusers.PlainPassword,tblusers.dateofRegistration ) VALUES (%s, %s, %s,%s, %s, %s,password(%s), password(%s), %s,now())",
                       GetSQLValueString($_POST['Fname'], "text"),
                       GetSQLValueString($_POST['Lname'], "text"),
                       GetSQLValueString($_POST['mail'], "text"),
					   GetSQLValueString($_POST['tel'], "text"),
                       GetSQLValueString($company_id, "int"),
                       GetSQLValueString($_POST['username'], "text"),
                        GetSQLValueString($_POST['password'], "text"),
                         GetSQLValueString($_POST['password'], "text"),
                         GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_bid, $bid);
  $Result1 = mysql_query($insertUserSQL, $bid) or die(mysql_error());
    
    
    
    
  
  
  
  
	
	
						
	$insertGoTo = "registerUser.php";
  if (isset($_SERVER['QUERY_STRING'])) {
     }
  header(sprintf("Location: %s", $insertGoTo));

}








?>
<!DOCTYPE html>
<!-- saved from url=(0055)http://#/pos/index.php/customers -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?php echo $_SESSION['companyName'] ?> -- -- Powered By OOUTH ICT</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!--<base href="http://#/pos/">--><base href=".">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
					<link href="css/bootstrap.min.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/jquery.gritter.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/jquery-ui.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/unicorn.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/custom.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/datepicker.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/bootstrap-select.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/select2.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/font-awesome.min.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/jquery.loadmask.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
					<link href="css/token-input-facebook.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
                    
				<script type="text/javascript">
			var SITE_URL= "index.php";
		</script>
		
					<script src="js/all.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
			<script src="js/jquery.dataTables.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
		
		<script type="text/javascript">
			COMMON_SUCCESS = "Success";
			COMMON_ERROR = "Error";
			$.ajaxSetup ({
				cache: false,
				headers: { "cache-control": "no-cache" }
			});
			
			$(document).ready(function()
			{
				//Ajax submit current location
				$("#employee_current_location_id").change(function()
				{
					$("#form_set_employee_current_location_id").ajaxSubmit(function()
					{
						window.location.reload(true);
					});
				});	
			});
		</script>
		<script>

                    var isNS4=(navigator.appName=="Netscape")?1:0;

                    function auto_logout(iSessionTimeout,iSessTimeOut,sessiontimeout)

                    {

                             window.setTimeout('', iSessionTimeout);

                              window.setTimeout('winClose()', iSessTimeOut);

                    }

                    function winClose() {

                        //alert("Your Application session is expired.");

                   if(!isNS4)

	           {

		          window.navigate("index.php");

	           }

                  else

	          {

		        window.location="index.php";

	           }

             }

            auto_logout(1440000,1500000,1500)

</script>
	<style>@font-face{font-family:uc-nexus-iconfont;src:url(chrome-extension://pogijhnlcfmcppgimcaccdkmbedjkmhi/res/font_1471832554_080215.woff) format('woff'),url(chrome-extension://pogijhnlcfmcppgimcaccdkmbedjkmhi/res/font_1471832554_080215.ttf) format('truetype')}</style></head>
	<body data-color="grey" class="flat" style="zoom: 1;">
		<div class="modal fade hidden-print" id="myModal"></div>
		<div id="wrapper">
		<div id="header" class="hidden-print">
			<h1><a href="index.php"><img src="support/header_logo.png" class="hidden-print header-log" id="header-logo" alt=""></a></h1>		
				<a id="menu-trigger" href="#"><i class="fa fa-bars fa fa-2x"></i></a>	
		<div class="clear"></div>
		</div>
		
		
		
		
		<div id="user-nav" class="hidden-print hidden-xs">
			<ul class="btn-group ">
				<li class="btn  hidden-xs"><a title="" href="switch_user" data-toggle="modal" data-target="#myModal"><i class="icon fa fa-user fa-2x"></i> <span class="text">	Welcome <b> <?php echo $_SESSION['SESS_FIRST_NAME']; ?> </b></span></a></li>
				<li class="btn  hidden-xs disabled">
					<a title="" href="pos/" onclick="return false;"><i class="icon fa fa-clock-o fa-2x"></i> <span class="text">
				  <?php
								$Today = date('y:m:d', time());
								$new = date('l, F d, Y', strtotime($Today));
								echo $new;
								?>				</span></a>
				</li>
									<li class="btn "><a href="#"><i class="icon fa fa-cog"></i><span class="text">Settings</span></a></li>
				        <li class="btn  ">
					<a href="index.php"><i class="fa fa-power-off"></i><span class="text">Logout</span></a>				</li>
			</ul>
		</div>
				<div id="sidebar" class="hidden-print minibar ">
			
			<?php include('menu.php');?>
		</div>
        
       
        
		<div id="content"  class="clearfix " >
		
<div id="content-header" class="hidden-print">
	<h1 > <i class="fa fa-pencil"></i>  New Company	</h1>

</div>

<div id="breadcrumb" class="hidden-print">
	<a href="home.php"><i class="fa fa-home"></i> Dashboard</a><a  class="current" href="new_employee.php">New Company</a></div>
<div class="clear"></div>
<div class="row" id="form">
	<div class="col-md-12">
		Fields in red are required		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5>Item Information</h5>
			</div>
			<div class="widget-content ">
			  <form name="item_form" action="<?php echo $editFormAction; ?>" method="POST" accept-charset="utf-8" id="employee_form" class="form-horizontal" enctype="multipart/form-data">					<div class="row">
	<div class="col-md-12">
					<div class="form-group">
			<label for="company_name" class="rSequired col-sm-3 col-md-3 col-lg-2 control-label ">Company Name:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
				<input type="text" name="company_name" class="form-inps focus" id="company_name">			</div>
		</div>
                    
<div class="form-group">
			<label for="company_tel" class="required col-sm-3 col-md-3 col-lg-2 control-label ">Company Tel.:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<input type="text" name="company_tel" class="form-inps" id="company_tel">			</div>
		</div>

					<div class="form-group">
			<label for="comp_email" class="col-sm-3 col-md-3 col-lg-2 control-label ">Company E-Mail:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<input type="text" name="comp_email" class="form-inps" id="comp_email">			</div>
		</div>
				  <div class="form-group"></div>
	
	</div>
	<div class="form-group">
    <label class="col-sm-3 col-md-3 col-lg-2 control-label ">&nbsp;</label>
	</div>
	
	
</div>
	


<div class="form-group">	
<label for="company_address_1" class="col-sm-3 col-md-3 col-lg-2 control-label ">Address 1:</label>	<div class="col-sm-9 col-md-9 col-lg-10">
	<input type="text" name="company_address_1" class="form-control form-inps" id="company_address_1">	</div>
</div>

			<div class="form-group">	
<label for="company_lg" class="col-sm-3 col-md-3 col-lg-2 control-label ">City:</label>	<div class="col-sm-9 col-md-9 col-lg-10">
	<input type="text" name="company_city" class="form-control form-inps" id="company_city">	</div>
</div>


			<div class="form-group">	
<label for="company_lg" class="col-sm-3 col-md-3 col-lg-2 control-label ">Local Govt:</label>	<div class="col-sm-9 col-md-9 col-lg-10">
	<input type="text" name="company_lg" class="form-control form-inps" id="company_lg">	</div>
</div>

			<div class="form-group">	
<label for="company_state" class="col-sm-3 col-md-3 col-lg-2 control-label ">State/Province:</label>	<div class="col-sm-9 col-md-9 col-lg-10">
	<input type="text" name="company_state" class="form-control form-inps" id="company_state">	</div>
</div>
			<legend class="page-header text-info"> &nbsp; &nbsp; Employee Login Info</legend>
                  
                  <div class="form-group">	
<label for="company_state" class="col-sm-3 col-md-3 col-lg-2 control-label ">First Name:</label>	<div class="col-sm-9 col-md-9 col-lg-10">
	<input type="text" name="Fname" class="form-control form-inps" id="Fname">	</div>
</div>
                  
                  <div class="form-group">	
<label for="company_state" class="col-sm-3 col-md-3 col-lg-2 control-label ">Last Name:</label>	<div class="col-sm-9 col-md-9 col-lg-10">
	<input type="text" name="Lname" class="form-control form-inps" id="Lname">	</div>
</div>
                  
                  <div class="form-group">	
<label for="company_state" class="col-sm-3 col-md-3 col-lg-2 control-label ">Tel:</label>	<div class="col-sm-9 col-md-9 col-lg-10">
	<input type="text" name="tel" class="form-control form-inps" id="tel">	</div>
</div>
                  <div class="form-group">	
<label for="company_state" class="col-sm-3 col-md-3 col-lg-2 control-label ">E-mail:</label>	<div class="col-sm-9 col-md-9 col-lg-10">
	<input type="text" name="mail" class="form-control form-inps" id="mail">	</div>
</div>
                  
				<div class="form-group">	<div class="form-group">	
					<label for="username" class="col-sm-3 col-md-3 col-lg-2 control-label required">Username:</label>					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="username" id="username" class="form-control" autocomplete="off">						</div>
<div class="form-group">					</div>
				<div class="form-group">	
					<label for="password" class="col-sm-3 col-md-3 col-lg-2 control-label">Password:</label>					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="password" name="password" id="password" class="form-control">						</div>
					</div>

					<div class="form-group">	
					<label for="repeat_password" class="col-sm-3 col-md-3 col-lg-2 control-label">Password Again:</label>					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="password" name="repeat_password" id="repeat_password" class="form-control">						</div>
					</div>
					
											

<input type="hidden" name="redirect_code" value="0">
<input type="hidden" name="MM_insert" value="employee_form">
<input type="hidden" name="MM_update" value="<?php if(isset($_GET['id'])){echo 'update';} ?>">
<div class="form-actions">
				<input type="submit" name="submitf" value="<?php if(isset($_GET['id'])){echo 'Update';}else{echo 'Add New';} ?>" id="submitf" class="submit_button btn btn-primary">					</div>
			  </form>					</div>
				</div>
			</div>
		</div>

	
<div id="footer" class="col-md-12 hidden-print">
	Please visit our 
		<a href="#" target="_blank">
			website		</a> 
	to learn the latest information about the project.
		<span class="text-info"> <span class="label label-info"> 14.1</span></span>
</div>
			<script type="text/javascript">
				$('#image_id').imagePreview({ selector : '#avatar' }); // Custom preview container

				$( "#category" ).autocomplete({
		 source: 'search.php',
		delay: 10,
		autoFocus: false,
		minLength: 0
	});
				//validation and submit handling
				$(document).ready(function()
				{

					setTimeout(function(){$(":input:visible:first","#customer_form").focus();},100);
					$(".module_checkboxes").change(function()
					{
						if ($(this).prop('checked'))
						{
							$(this).parent().find('input[type=checkbox]').not(':disabled').prop('checked', true);
						}
						else
						{
							$(this).parent().find('input[type=checkbox]').not(':disabled').prop('checked', false);
						}
					});


					$('#employee_form').validate({

						// Specify the validation rules
						
						
						rules:
						{
							
            Lname: "required",
            Fname: "required",
             tel:
            {
                required:true,
                maxlength: 11,
                minlength: 11,
                digits: true
            },
              company_tel:
            {
                required:false,
                maxlength: 11,
                minlength: 11,
                digits: true
            },               
              password:
            {
                required:true,
                minlength: 5
            },               
            repeat_password:
            {
                equalTo: "#password"

            },
            comp_email: {
                "required": false,
                "email": true
            },
             mail: {
                "required": false,
                "email": true
            },               
                            
            email: {
                "required": false,
                "email": true
            },
			company_name:
                {
                    remote: 
			         { 
				        url: "company_exists.php", 
				        type: "post"
			         }, 
											
				    required:true
				},	 
							
								
							
						},

						// Specify the validation error messages
						messages:
						{
							company_name: {
				            required:   "Company Name is a required field.",	
				            remote:     "Company already Existing"
							
							}, 
							
							
							Fname: "Contact Person First Name is a required field.",
                            
							tel:{ 
                                integer: "Only number allowed",
                                required: "Contact Person Mobile No. is a required field.",
                                minlength : "Digit must be 11"
                                },
                            company_tel:{ 
                                integer:    "Only number allowed",
                                minlength : "Digit must be 11"
                                },
                            
							Lname: "Contact Person Last Name is a required field",
                            comp_email: "Put proper email address",
                            mail: "Put proper email address",
						},

						errorClass: "text-danger",
						errorElement: "span",
						highlight:function(element, errorClass, validClass) {
							$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
						},
						unhighlight: function(element, errorClass, validClass) {
							$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
						},

						submitHandler: function(form) {
							//form.submit();
							doEmployeeSubmit(form);
						}
					});


				});



				var submitting = true;

				function doEmployeeSubmit(form)
				{
					$("#form").mask("Please wait...");
					//if (submitting) return;
					//submitting = true;

					$(form).ajaxSubmit({
						success:function(response,message)
						{
							$("#form").unmask();
							submitting = false;
							
								if (message == 'success')
								{
									gritter("Success",'New Company Created Successfully','gritter-item-success',false,true);
							setTimeout(function()
							{
								window.location.href =' <?php echo $_SESSION['currentPage'];?>'//'new_receiving.php';								
							}, 1200);
								}
								else
								{
									gritter("Error",message,'gritter-item-error',false,false);

								}
							
							
						}
					});
				}
			</script>
</div><!--end #content-->
</div><!--end #wrapper-->
</body>
</html>
<?php
//mysql_free_result($Edit_record);
?>
