<?php include('session_check.php');
require_once('Connections/bid.php');
//session_start();
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


mysqli_select_db($bid,$database_bid);

$query_Period = "SELECT tbl_documenttype.documentType_id, tbl_documenttype.documentType FROM tbl_documenttype order by documentType_id asc";
$Period = mysqli_query($bid,$query_Period) or die(mysqli_error($bid));
$row_Period = mysqli_fetch_assoc($Period);
$totalRows_Period = mysqli_num_rows($Period);

$query_documentType = "SELECT tbl_documenttype.documentType_id, tbl_documenttype.documentType FROM tbl_documenttype";
$documentType = mysqli_query($bid,$query_documentType) or die(mysqli_error($bid));
$row_documentType = mysqli_fetch_assoc($documentType);
$totalrow_documentType = mysqli_num_rows($documentType);

if (isset($_GET['id'])){

$queryDelete = "delete from tbl_document where document_id = '".$_GET['id']."'";
$pixPrev = mysqli_query($bid,$queryDelete) or die(mysqli_error($bid));
}

?>

<!DOCTYPE html>
<!-- saved from url=(0055)http://#/pos/index.php/customers -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?php echo $_SESSION['companyName']; ?> -- Powered By OOUTH ICT</title>


		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!--<base href="http://#/pos/">--><base href=".">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- jQuery Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Select2 CSS and JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <!-- jQuery UI Library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Gritter CSS -->
    <link href="https://cdn.jsdelivr.net/npm/gritter@1.7.4/css/jquery.gritter.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/gritter@1.7.4/js/jquery.gritter.min.js"></script>

    <!-- Custom CSS -->
    <link href="css/unicorn.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/token-input-facebook.css" rel="stylesheet">

    <!-- Additional Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <!-- Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <!-- Bootstrap Select CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Loadmask CSS -->
    <link href="https://cdn.jsdelivr.net/npm/jquery.loadmask@1.0.1/jquery.loadmask.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery.loadmask@1.0.1/jquery.loadmask.min.js"></script>

    <!-- DataTables CSS and JS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- DataTables TableTools CSS and JS -->
    <link href="https://cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>

    <!-- jquery-confirm CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

    <script type="text/javascript">
$(document).ready(function() {

	 $("#search").focus();

} );


</script>


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

	<style>@font-face{font-family:uc-nexus-iconfont;src:url(chrome-extension://pogijhnlcfmcppgimcaccdkmbedjkmhi/res/font_1476274416_922599.woff) format('woff'),url(chrome-extension://pogijhnlcfmcppgimcaccdkmbedjkmhi/res/font_1476274416_922599.ttf) format('truetype')}</style></head>
	<body data-color="grey" class="flat" style="zoom: 1;">
		<div class="modal fade hidden-print" id="myModal"></div>
		<div id="wrapper" class="minibar">
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
				<div id="sidebar" class="hidden-print minibar sales_minibar">

			<?php include ('menu.php');?>
		</div>



		<div id="content"  class="clearfix sales_content_minibar" >

<div id="receipt_wrapper">
    <div id="register_container" class="sales clearfix"></div>
	<div class="row">
    <div class="col-lg-1">
        <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
<div id="image_preview"><img id="previewing" src="noimage.png" /></div>
<hr id="line">
<div class="row-fluid">
    <div class="col-lg-12">
            <label for="documentType">Select Document Type for Upload:<select name="documentType" required="required" id="documentType" class="select2-active">
                                 <option value="0">Select Document Type</option>
                                 <?php
do {
?>
                                 <option value="<?php echo $row_Period['documentType_id']?>"><?php echo $row_Period['documentType']?></option>
                                 <?php
} while ($row_Period = mysqli_fetch_assoc($Period));
  $rows = mysqli_num_rows($Period);
  if($rows > 0) {
      mysqli_data_seek($Period, 0);
	  $row_Period = mysqli_fetch_assoc($Period);
  }
?>
                               </select></label></div>
            </div>
<div id="selectImage">
<label>Select Your Image</label><br/>
<input name="file" type="file" required class="badge-dark" id="file" />
<input type="submit" value="Upload" class="alert-danger" />





          </form></div>
        <div class="col-lg-1">
        <h4 id='loading' ></h4>
<div id="message"></div>
                <br> <br>
    <div id="pixPrev"></div>



    </div>
    <hr id="line"></div>

    </div>


<script>

$(document).ready(function (e) {

    $(".select2-active").select2();

//$('select').niceSelect();
 $("#pixPrev").load('uploadPreview.php');
$("#uploadimage").on('submit',(function(e) {
    if($('#documentType').val() == 0){
        alert('kindly select Document Type');
        $('#documentType').focus();
        return false;

    }
    e.preventDefault();
$("#message").empty();
//$("#register_container").mask("Please wait...");

$.ajax({
url: "ajax_php_file.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$('#loading').hide();
$("#message").html(data);
$("#pixPrev").load('uploadPreview.php');
 $('#file').empty();
}
});
}));

// Function to preview image after validation
$(function() {
$("#file").change(function() {

$("#message").empty(); // To remove the previous error message
var file = this.files[0];
var imagefile = file.type;
var match= ["image/jpeg","image/png","image/jpg"];
if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
{

$('#previewing').attr('src','noimage.png');
$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");

return false;
}
else
{
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
}
});
});
function imageIsLoaded(e) {
$("#file").css("color","green");
$('#image_preview').css("display", "block");
$('#previewing').attr('src', e.target.result);
$('#previewing').attr('width', '250px');
$('#previewing').attr('height', '230px');
};
});

    $("preview").click(function(){
    $.ajax({url: "uploadPreview.php?id=40", success: function(result){
     // $("#div1").html(result);
        alert(result);
    }});
  });


    </script>
<div id="footer" class="col-md-12 hidden-print">
	Please visit our
		<a href="#" target="_blank">
			website		</a>
	to learn the latest information about the project.
		<span class="text-info"> <span class="label label-info"> 14.1</span></span>
</div>

</div><!--end #content-->
</div><!--end #wrapper-->


<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-1" tabindex="0" style="display: none;"></ul><ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-2" tabindex="0" style="display: none;"></ul>
<script type="text/javascript">

</script>
<?php //unset($_SESSION['SESS_INVOICE']); ?>
</body></html>
<?php
//mysql_free_result($recept);

//mysql_free_result($companyInfo);
?>
