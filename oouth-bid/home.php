<?php
	include('session_check.php')
	
?>

<!DOCTYPE html>
<!-- saved from url=(0050)http://#/pos/index.php/home -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?php echo $_SESSION['companyName']; ?> -- Powered By OOUTH ICT</title>
		
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
                    <link href="css/dataTables.tableTools.min.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
<link href="css/dataTables.tableTools.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
				<script type="text/javascript">
			var SITE_URL= "index.php";
		</script>
		
					<script src="support/all.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
			
		
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
				<a id="menu-trigger" href="http://#/pos/#"><i class="fa fa-bars fa fa-2x"></i></a>	
		<div class="clear"></div>
		</div>
		
		
		
		
		<div id="user-nav" class="hidden-print hidden-xs">
			<ul class="btn-group ">
				<li class="btn  hidden-xs"><a title="" href="switch_user" data-toggle="modal" data-target="#myModal"><i class="icon fa fa-user fa-2x"></i> <span class="text">	Welcome <b> <?php echo $_SESSION['SESS_FIRST_NAME']; ?> </b></span></a></li>
				<li class="btn  hidden-xs disabled">
					<a title="" href="pos/" onclick="return false;"><i class="icon fa fa-clock-o fa-2x"></i> <span class="text">
					<?php
								$Today = date('y:m:d',time());
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
			
			<?php include ('menu.php') ;?>
		</div>
        
       
        
		<div id="content" class="clearfix ">
		
<div id="content-header" class="hidden-print">
	<h1><i class="icon fa fa-dashboard"></i> Dashboard</h1>
</div>
<div id="breadcrumb" class="hidden-print">
	<a href="home.php"><i class="fa fa-home"></i> Dashboard</a>	
</div>
<div class="clear"></div>
<div class="text-center">					
	<h3><strong style="font-size: 15px; color: #0000CC;">WELCOME TO OOUTH BID SYSTEM</strong></h3>
	<ul class="quick-actions">
						
        <li> 
			<a class="right" href="upload2.php">	<i class="text-info fa fa-cloud-download left fa-5x "></i><br> Uplod Bid Document</a>
		</li>  
        <li> 
			<a class="right" href="price.php">	<i class="text-info fa fa-table left fa-5x "></i><br>
			Add Price</a>
		</li> 
        
		
        
				<li> 
			<a class="right" href="Print.php">	<i class="text-info fa fa-print left fa-5x "></i><br> Print Price List</a>
		</li>
				
			<?php if ($_SESSION['role'] == 'Admin'){ ?><li> 
			<a class="right" href="registerUser.php">	<i class="text-info fa fa-users left fa-5x "></i><br> Register User</a>
		</li> <?php } ?>	
                
        
				
				
			
       
	  </ul>

		</div>


</div><!--end #content-->
</div><!--end #wrapper-->

</body></html>