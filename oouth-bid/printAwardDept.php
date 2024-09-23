<?php require_once('Connections/bid.php'); ?>
<?php

include('session_check.php');
	
	
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		header("location: index.php");
		exit();
	}
	
if(!isset($_SESSION['company_id'])){
	header("location: index.php");
	}




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







$col_itemSearch = "-1";
if (isset($_POST['company_id'])) {
  $col_itemSearch = $_POST['company_id'];
    $percent = $_POST['percentage'];
}
mysql_select_db($database_bid, $bid);
$query_itemPrint = sprintf("SELECT item_price.company_id, item_price.price,
item_price.qty,
items.dept_id,
tbl_dept.dept
FROM
tbl_evaluation
INNER JOIN item_price ON item_price.item_price_id = tbl_evaluation.item_price_id
INNER JOIN items ON items.item_id = item_price.item_id
INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
WHERE company_id = %s
GROUP BY items.dept_id
", GetSQLValueString($col_itemSearch, "text"));
$itemPrint = mysql_query($query_itemPrint, $bid) or die(mysql_error());
$row_itemPrint = mysql_fetch_assoc($itemPrint);
$totalRows_itemPrint = mysql_num_rows($itemPrint);


$query_company = sprintf("SELECT
tbl_company.company_id,
tbl_company.company_name,
tbl_company.company_tel,
tbl_company.company_address,
tbl_company.state,
tbl_company.lg,
tbl_company.email,
tbl_company.userid
FROM
tbl_company
WHERE company_id = %s
", GetSQLValueString($col_itemSearch, "text"));
$company = mysql_query($query_company, $bid) or die(mysql_error());
$row_company = mysql_fetch_assoc($company);
$totalRows_company = mysql_num_rows($company);

?>
	
<!DOCTYPE html>
<!-- saved from url=(0055)http://#/pos/index.php/customers -->
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
<link href="css/dataTables.tableTools.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
<link href="css/dataTables.tableTools.min.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">

<script type="text/javascript" src="js/shortcut.js"></script>

<script>
    shortcut.add("F4", function() {
       window.location = "new_employee.php";
	   
	      });   
    shortcut.add("ctrl+d", function() {
        // Do something
		alert("ok");
    }); 
</script>

<script src="js/dataTables.tableTools.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script src="js/dataTables.tableTools.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
				<script type="text/javascript">
			var SITE_URL= "index.php";
		</script>
		
					<script src="support/all.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
			
		<link href="support/css/jquery.dataTables.min.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all">
<script src="support/jquery.min1.js"></script>
<script src="support/js/jquery.dataTables.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>

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
				<div id="sidebar" class="hidden-print minibar sales_minibar">
			
			<?php include ('menu.php');?>
		</div>
        
       
        
		<div id="content"  class="clearfix sales_content_minibar" >
		
<div id="receipt_wrapper">
	<div id="receipt_header">
		<div id="company_name"><?php echo($row_company['company_name']); ?></div>
		<div id="company_address"><?php echo $row_company['company_address']; ?></div>
		<div id="company_phone"><?php echo $row_company['company_tel']; ?></div>
        <div id="company_state"><?php echo $row_company['state']; ?></div>
         <div id="company_lg"><?php echo $row_company['lg']; ?></div>
        <div id="company_lg"><?php echo $row_company['email']; ?></div>
					<div id="website"></div>
				<div id="sale_receipt">Letter of Award</div>
		<div id="sale_time"><?php
								$Today = date('y:m:d',mktime());
								$new = date('l, F d, Y', strtotime($Today));
								echo $new;
								?></div>
		
	</div>
	<div id="receipt_general_info">
				
        <div id="mercahnt_id"></div>			
	</div>
    
    <div class="row">
    <div class="co12"><table id="register" class="table table-bordered">
						    
						    <thead>
						<tr><th class="item_name_heading"><strong>S/N</strong></th>
						      <th class="item_name_heading"><strong>ITEM NO</strong></th>
						     <th class="item_name_heading">DRUGS/ITEMS</strong></th>
						      <th class="item_name_heading"><strong>UNIT/ PACK</strong></th>
						      <th class="item_name_heading"><strong>TOTAL QTY AWARDED</strong></th>
						      
						      <th class="item_name_heading"><strong>QUOTED PRICE</strong></th>
						      <th class="item_name_heading"><strong> AMOUNT </strong></th>
					        </tr>
                        </thead>
						   <?php if ($totalRows_itemPrint > 0) {	?>	<?php  do { ;?> 
        <tr>
          <td colspan="6"><strong><?php echo $row_itemPrint['dept'];?></strong></td>
          
          <td align="right">&nbsp;</td>
        </tr>
        <?php 
        $col_itemSearch = "-1";
if (isset($_POST['company_id'])) {
  $col_itemSearch = $_POST['company_id'];
    $percent = $_POST['percentage'];
}
mysql_select_db($database_bid, $bid);
$query_itemSearch = sprintf("SELECT item_price.price, tbl_company.company_name, items.item, items.packSize, items.qty, tbl_evaluation.percentage, tbl_lot.lot_description, tbl_dept.dept,
item_price.item_id,items.packSize,items.qty as require_year,
(items.qty*(tbl_evaluation.percentage/100))*$percent as qtyAwarded,
tbl_company.company_tel,
tbl_company.company_address,
tbl_company.state,
tbl_company.lg,
tbl_company.email FROM tbl_evaluation INNER JOIN item_price ON item_price.item_price_id = tbl_evaluation.item_price_id INNER JOIN tbl_company ON tbl_company.company_id = item_price.company_id
INNER JOIN items ON items.item_id = item_price.item_id INNER JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
WHERE item_price.company_id = %s and items.dept_id = %s ORDER BY items.item_id", GetSQLValueString($row_itemPrint['company_id'], "text"),GetSQLValueString($row_itemPrint['dept_id'], "text"));
$itemSearch = mysql_query($query_itemSearch, $bid) or die(mysql_error());
$row_itemSearch = mysql_fetch_assoc($itemSearch);
$totalRows_itemSearch = mysql_num_rows($itemSearch);
                              $total=0; $i = 1; do { 
        ?>
        
        <tr>
						      <td><?php echo $i;?></td>
                                <td><?php echo $row_itemSearch['item_id']?></td>
						      <td><?php echo $row_itemSearch['item']?></td>
						      <td width="65"><?php echo $row_itemSearch['packSize']?></td>
						      <td width="78"><?php echo number_format($row_itemSearch['qtyAwarded'])?></td>
						      
						      <td width="162"><?php echo number_format($row_itemSearch['price'])?></td>
						      <td width="214" align="right"><?php $mul = $row_itemSearch['price']*$row_itemSearch['qtyAwarded']; echo number_format($row_itemSearch['price']*$row_itemSearch['qtyAwarded']) ?></td>
					       <?php $i=$i+1;$total=$total+($row_itemSearch['price']*$row_itemSearch['qtyAwarded']);} while ($row_itemSearch = mysql_fetch_assoc($itemSearch)) ?>
        
                        </tr><?php } while ($row_itemPrint = mysql_fetch_assoc($itemPrint)); }?>
            <tr>
            <td><?php if ($totalRows_itemPrint > 0) {	?> <strong>Grand total: <?php echo number_format($total);?><?php } ?></strong></td></tr>
					      </table>
      <div class="row-fluid">
        <div class="col-lg-12">
            <div id='sale_details'>
						
			</div>
            </div>
        
            
      </div>
        </div>
    
    </div>
    
    
	<div id="sale_return_policy">
	  Have a NICE DAY!   <br />
	</div>
	
		
	
<div id="footer" class="col-md-12 hidden-print">
	Please visit our 
		<a href="https://www.oouth.com" target="_blank">
			website		</a> 
	to learn the latest information about the project.
		<span class="text-info"> <span class="label label-info"> 14.1</span></span>
</div>

</div><!--end #content-->
</div><!--end #wrapper-->


<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-1" tabindex="0" style="display: none;"></ul><ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-2" tabindex="0" style="display: none;"></ul>
<script type="text/javascript">
$(window).load(function() { window.print(); });
</script>
<?php //unset($_SESSION['SESS_INVOICE']); ?>
</body></html>
<?php
//mysql_free_result($recept);

//mysql_free_result($companyInfo);
?>
