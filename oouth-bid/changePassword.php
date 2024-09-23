<?php require_once('Connections/bid.php'); ?>
<?php

	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	include('session_check.php');
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
//$_POST["submitf"] = 'ok';
//$_POST['new_password'] = 'test1';
//$_POST['confirm_password']= 'test1';

if ((isset($_POST["MM_update"]))) {
   
  $updateSQL = sprintf("UPDATE tblusers SET UPassword=password(%s), CPassword=password(%s),PlainPassword=%s, first_login=1 WHERE UserID=%s",
                       GetSQLValueString($_POST['new_password'], "text"),
                       GetSQLValueString($_POST['confirm_password'], "text"),
					   GetSQLValueString($_POST['confirm_password'], "text"),
                       GetSQLValueString($_SESSION['SESS_MEMBER_ID'], "int"));

  mysql_select_db($database_bid, $bid);
  $Result1 = mysql_query($updateSQL, $bid) or die(mysql_error());
}


	

?>
<!DOCTYPE html>
<!-- saved from url=(0055)http://www.optimumlinkup.com.ng/pos/index.php/customers -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>OOUTH BID -- OOUTH ICT</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!--<base href="http://www.optimumlinkup.com.ng/pos/">--><base href=".">
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
				<li class="btn  hidden-xs"><a title="" href="changePassword.php" data-toggle="modal" data-target="#myModal"><i class="icon fa fa-user fa-2x"></i> <span class="text">	Welcome <b> <?php echo $_SESSION['SESS_FIRST_NAME']; ?> </b></span></a></li>
				<li class="btn  hidden-xs disabled">
					<a title="" href="pos/" onclick="return false;"><i class="icon fa fa-clock-o fa-2x"></i> <span class="text">
				  <?php
								$Today = date('y:m:d',mktime());
								$new = date('l, F d, Y', strtotime($Today));
								echo $new;
								?>				</span></a>
				</li>
									<li class="btn "><a href="#"><i class="icon fa fa-cog"></i><span class="text">Settings</span></a></li>
				        <li class="btn  ">
					<a href="index.php"><i class="fa fa-power-off"></i><span class="text">Logout</span></a>				</li>
			</ul>
		</div>
		<div id="content"  class="clearfix " >
		  
  <div id="content-header" class="hidden-print">
	<h1 > <i class="fa fa-pencil"></i>  Change Password	</h1>
</div>

<div id="breadcrumb" class="hidden-print">
	</div>
<div class="clear"></div>
<div class="row" id="form">
	<div class="col-md-12">
		Fields in red are required		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5>Change Password</h5>
			</div>
			<div class="widget-content ">
				<form action="<?php echo $editFormAction; ?>" name="customer_form" method="POST" accept-charset="utf-8" id="customer_form" class="form-horizontal" enctype="multipart/form-data">					<div class="row">
	<div class="col-md-12">
					<div class="form-group">
			<label for="current_password" class="required col-sm-3 col-md-3 col-lg-2 control-label ">Current Password:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
				<input type="password" name="current_password" class="form-inps" id="current_password"  />			</div>
		</div>

					<div class="form-group">
			<label for="confirm_password" class="required col-sm-3 col-md-3 col-lg-2 control-label ">New Password:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<input type="password" name="new_password" class="form-inps" id="new_password"  />			</div>
		</div>
					

	<div class="form-group">
			<label for="confirm_password" class="required col-sm-3 col-md-3 col-lg-2 control-label ">Confirm  Password:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<input type="password" name="confirm_password" class="form-inps" id="confirm_password"  />			</div>
		</div>					
						
						
<input name="password_save" type="hidden" id="password_save" value="<?php echo $_SESSION['password']; ?>" />

						<div class="form-actions">
				  <input type="submit" name="submitf" value="Submit" id="submitf" class=" btn btn-primary"  />						</div>
						
						
						<input type="hidden" name="MM_update" value="customer_form">
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


					$('#customer_form').validate({

        // Specify the validation rules
        rules:
        {
            current_password:
				{
				 required:true,
				 equalTo: "#password_save"
				  },
           new_password:
				{
				 required:true,
				 minlength: 5
				  },
            
            confirm_password:
				{
				 equalTo: "#new_password"
				  },

        },

        // Specify the validation error messages
        messages:
        {
            current_password:
            {
                required: "Current password is a required field",
                equalTo: "Currrent password does not match"     		},
            new_password:
            {
                required:"Password is required",
                minlength: "Passwords must be at least 5 characters"			},
            confirm_password:
            {
                equalTo: "Passwords do not match"     		},
            
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
									gritter("Success","Record Saved Successfully. Please log-in with your new Password",'gritter-item-success',false,true);
							setTimeout(function()
							{
								window.location.href = 'index.php';								
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