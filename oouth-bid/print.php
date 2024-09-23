<?php require_once('Connections/bid.php');
global $bid;

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
 global $bid;

  $theValue = function_exists("mysql_real_escape_string") ? mysqli_real_escape_string($bid,$theValue) : mysqli_escape_string($bid,$theValue);

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

$col_recept = "-1";
if (isset($_SESSION['company_id'])) {
  $col_recept = $_SESSION['company_id'];
}



mysqli_select_db($bid,$database_bid);
$query_companyInfo = "SELECT tbl_company.company_name,tbl_company.company_address,company_tel,tbl_company.state,tbl_company.lg,tbl_company.email FROM tbl_company WHERE company_id = '".$_SESSION['company_id']."'";
$companyInfo = mysqli_query($bid,$query_companyInfo) or die(mysqli_error($bid));
$row_companyInfo = mysqli_fetch_assoc($companyInfo);
$totalRows_companyInfo = mysqli_num_rows($companyInfo);

$query_totalInvoice = sprintf("SELECT
Sum(item_price.price * item_price.qty) as 'total'
FROM item_price WHERE company_id =  %s", GetSQLValueString($_SESSION['company_id'], "text"));
$totalInvoice = mysqli_query($bid,$query_totalInvoice) or die(mysqli_error($bid));
$row_totalInvoice = mysqli_fetch_assoc($totalInvoice);
$totalRows_totalInvoice = mysqli_num_rows($totalInvoice);

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
	<div id="receipt_header">
		<div id="company_name"><?php echo($row_companyInfo['company_name']); ?></div>
		<div id="company_address"><?php echo $row_companyInfo['company_address']; ?></div>
		<div id="company_phone"><?php echo $row_companyInfo['company_tel']; ?></div>
        <div id="company_state"><?php echo $row_companyInfo['state']; ?></div>
         <div id="company_lg"><?php echo $row_companyInfo['lg']; ?></div>
        <div id="company_lg"><?php echo $row_companyInfo['email']; ?></div>
					<div id="website"></div>
				<div id="sale_receipt">Bid Document</div>
		<div id="sale_time"><?php
								$Today = date('y:m:d',time());
								$new = date('l, F d, Y', strtotime($Today));
								echo $new;
								?></div>
		
	</div>
	<div id="receipt_general_info">
				
        <div id="mercahnt_id"></div>			
	</div>
    <?php mysqli_select_db($bid,$database_bid);
$query_lotInfo = "SELECT
ANY_VALUE(item_price.item_id) AS item_id,
item_price.company_id,
tbl_lot.lot_id,
tbl_lot.lot_description,
ANY_VALUE(tbl_dept.dept_id) AS dept_id,
ANY_VALUE(tbl_dept.dept) AS dept
FROM
item_price
INNER JOIN items ON items.item_id = item_price.item_id
INNER JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id
INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
WHERE company_id = '".$_SESSION['company_id']."' GROUP BY items.lot_id";
$lotInfo = mysqli_query($bid,$query_lotInfo) or die(mysqli_error($bid));
$row_lotInfo = mysqli_fetch_assoc($lotInfo);
$totalRows_lotInfo = mysqli_num_rows($lotInfo);?>
    <div class="row">
    <div class="co12"><?php do { ?> <div class="lotDetails"><strong><?php echo $row_lotInfo['lot_description'];?></strong></div><table width="100%" border="1">
        
  <tbody>
    
      <tr>
      <th scope="col">Item Id</th>
      <th scope="col">List of Drugs/Items</th>
      <th scope="col"> QTY/YEAR </th>
      <th scope="col">Pack Size</th>
      <th scope="col">Unit Price</th>
      <th scope="col">Total</th>
    </tr>
      <?php mysqli_select_db($bid,$database_bid);
                                
$query_itemInfo = "SELECT
item_price.item_id,
item_price.price,
items.qty,
items.packSize,items.item
FROM
item_price INNER JOIN items ON items.item_id = item_price.item_id
WHERE company_id = '".$row_lotInfo['company_id']. "' AND items.lot_id = '" . $row_lotInfo['lot_id']. "'";
$itemInfo = mysqli_query($bid,$query_itemInfo) or die(mysqli_error($bid));
$row_itemInfo = mysqli_fetch_assoc($itemInfo);
$totalRows_itemIfo = mysqli_num_rows($itemInfo);?>
  <?php if($totalRows_itemIfo > 0 ) { do { ?>    <tr>
      <td><?php echo $row_itemInfo['item_id'];?></td>
      <td><?php echo $row_itemInfo['item'];?></td>
      <td><?php echo $row_itemInfo['qty'];?></td>
      <td><?php echo $row_itemInfo['packSize'];?></td>
      <td align="right"><?php echo number_format($row_itemInfo['price'],2);?></td>
      <td align="right"><?php echo number_format(($row_itemInfo['price'] * $row_itemInfo['qty']),2);?></td>
    </tr><?php } while ($row_itemInfo = mysqli_fetch_assoc($itemInfo)); }?>
  </tbody>
</table><?php } while ($row_lotInfo = mysqli_fetch_assoc($lotInfo)); ?>

        <div class="row-fluid">
        <div class="col-lg-12">
            <div id='sale_details'>
						<table id="sales_items" class="table">
							<tr class="warning">
								<td class="left">Bid Security:</td>
								<td class="right"><strong><?php echo number_format(($row_totalInvoice['total']*0.3),2) ;//$totalRows_invoice ; ?></strong></td>
							</tr>
														<tr class="success">
								<td ><h3 class="sales_totals">Total:</h3></td>
								<td ><h3 class="currency_totals"><?php echo number_format(ceil($row_totalInvoice['total']),2); ?></h3></td>
							</tr>
						</table>
					</div>
            </div>
        
            
        </div>
        </div>
    
    </div>
    
    
	<div id="sale_return_policy">
	  Have a NICE DAY!   <br />
	</div>
	
		
	<form action="price.php" method="post" accept-charset="utf-8" id="sales_change_form">	<button class="btn btn-primary text-white hidden-print" id="edit_sale" onclick="submit()" > Add Mores </button>

	  </form>
	

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
