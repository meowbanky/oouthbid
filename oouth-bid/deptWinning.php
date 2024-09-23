<?php
require_once('Connections/bid.php');

include('session_check.php');

$_SESSION['SESS_INVOICE'] = $_SESSION['companyName'];


	//Check whether the session variable SESS_MEMBER_ID is present or not

	$_SESSION['currentPage'] = $_SERVER["PHP_SELF"];

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

if (isset($_POST['invoice_no_fromReceipt'])){

	$_SESSION['SESS_INVOICE'] = $_POST['invoice_no_fromReceipt'];

	}

	if (isset($_SESSION['SESS_PRICE_AJUSTMENT'])){

	unset ($_SESSION['SESS_PRICE_AJUSTMENT']);

	}

	if (isset($_POST['unsuspend']) and $_POST['unsuspend']== 'unsuspend'){

	$UpdateSalesQty = sprintf("UPDATE sales SET suspended = 0 WHERE
sales.invoice_no = %s ",
								GetSQLValueString($_POST['invoice_no_fromReceipt'], "text"));
mysql_select_db($database_pos, $pos);
$Result1 = mysql_query($UpdateSalesQty, $pos) or die(mysql_error());


		}

if (isset($_GET['new']) and $_GET['new'] == 'new'){

	unset($_SESSION['SESS_INVOICE']);
	}

function createRandomPassword() {
	$chars = "003232303232023232023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 7) {

		$num = rand() % 33;

		$tmp = substr($chars, $num, 1);

		$pass = $pass . $tmp;

		$i++;

	}
	return $pass;
}
if (!isset($_SESSION['SESS_INVOICE']) or ($_SESSION['SESS_INVOICE'] == '')){
$_SESSION['SESS_INVOICE'] = $_SESSION['companyName'];
}
?>

<!DOCTYPE html>
<!-- saved from url=(0055)http://#/pos/index.php/customers -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $_SESSION['companyName']; ?> -- Powered By OOUTH ICT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <base href=".">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- jQuery Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Select2 CSS and JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <!-- jQuery UI Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet" type="text/css" media="all">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">

    <!-- Gritter CSS -->
    <link href="https://cdn.jsdelivr.net/npm/gritter@1.7.4/css/jquery.gritter.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/gritter@1.7.4/js/jquery.gritter.min.js"></script>

    <!-- Custom CSS -->
    <link href="css/unicorn.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/custom.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/token-input-facebook.css" rel="stylesheet" type="text/css" media="all">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <!-- Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" media="all">

    <!-- Bootstrap Select CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" media="all">

    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">

    <!-- Loadmask CSS -->
    <link href="https://cdn.jsdelivr.net/npm/jquery.loadmask@1.0.1/jquery.loadmask.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery.loadmask@1.0.1/jquery.loadmask.min.js"></script>

    <!-- DataTables CSS and JS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- DataTables TableTools CSS and JS -->
    <link href="https://cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>

    <script src="js/all.js" type="text/javascript" language="javascript" charset="UTF-8"></script>


<script type="text/javascript">
$(document).ready(function() {

	// $("#search").focus();

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
			<h1><a href="index.php"><img src="img/header_logo.png" class="hidden-print header-log" id="header-logo" alt=""></a></h1>
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



		<div id="content" class="clearfix sales_content_minibar">

 <div class="clear"></div>

<div id="sale-grid-big-wrapper" class="clearfix">

</div>

<div id="register_container" class="sales clearfix">
	<div id="content-header" class="hidden-print sales_header_container">
	<h1 class="headigs"> <i class="icon fa fa-shopping-cart"></i>
		Company Name - &nbsp; <?php echo $_SESSION['SESS_INVOICE'] ?><span id="ajax-loader" style="display: none;"><img src="img/ajax-loader.gif" alt=""></span>
			</h1>



</div>

<div class="clear"></div>
	<!--Left small box-->
	<div class="row">
		<div class="sale_register_leftbox col-md-9">
			<div class="row forms-area">
										<div class="col-md-8 no-padd">
							<div class="input-append">
								<form action="SalesAdd.php" method="post" accept-charset="utf-8" id="add_item_form" class="form-inline" autocomplete="off">								<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input type="text" name="item" value="Enter item name or scan barcode" id="item" class="input-xlarge ui-autocomplete-input focus" accesskey="i" placeholder="Enter item name or scan barcode" autocomplete="off"><input name="item_id" type="hidden" id="item_id" value="">	<input name="code" type="hidden" id="code" value="<?php if (isset($error)){echo $error; }else {echo -1;} ?>" />
								  <input name="invoice_no" type="hidden" id="invoice_no" value="<?php if (isset($_SESSION['SESS_INVOICE'])){echo $_SESSION['SESS_INVOICE']; }?>">
                                </form>
							</div>
						</div>

				<div class="col-md-4 no-padd">


			</div>

			</div>

		<div class="row">

						<div class="table-responsive">
				<table id="register" class="table table-bordered">

					<thead>
						<tr>
							<th></th>
							<th class="item_name_heading">Item Name</th>
							<th class="sales_item sales_items_number">Item #</th>
							<th class="sales_stock">Stock</th>
							<th class="sales_price">Price</th>
							<th class="sales_quality">Qty.</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody id="cart_contents" class="sa">
												<tr class="cart_content_area">
							<td colspan="7">&nbsp;</td>
						</tr>
										</tbody>
			</table>
			</div>
				<ul class="list-inline pull-left">
						<li>



			</ul>
									<ul class="list-inline pull-right" id="global_discount">
						<li></li>
					</ul>

						</div>




					</div>
					<!-- Right small box  -->
				<div class="col-md-3 sale_register_rightbox">
					<ul class="list-group">
					  <li class="list-group-item spacing">
				      </li>
					  <li class="list-group-item spacing">
				      </li>

				<li class="list-group-item nopadding">
								</li>
		</ul>

		</div>
</div>
<script type="text/javascript">
	</script>

<script type="text/javascript" language="javascript">

    var submitting = false;
	$(document).ready(function()
	{
		//Here just in case the loader doesn't go away for some reason
		$("#ajax-loader").hide();

		if (last_focused_id && last_focused_id != 'item' && $('#'+last_focused_id).is('input[type=text]'))
		{
 			$('#'+last_focused_id).focus();
			$('#'+last_focused_id).select();
		}

		$(document).focusin(function(event)
		{
			last_focused_id = $(event.target).attr('id');
		});

		$('#mode_form, #select_customer_form, #add_payment_form, .line_item_form, #discount_all_form').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit});
		$('#add_item_form').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: itemScannedSuccess});
		$("#cart_contents input").change(function()
		{
			$(this.form).ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
		});

		$( "#item" ).autocomplete({
			source: 'salesitemsearch.php',
			type: 'GET',
			delay: 10,
			autoFocus: false,
			minLength: 1,
			select: function(event, ui)
			{
				event.preventDefault();
				$( "#item" ).val(ui.item.value);
				$("#item_id").val(ui.item.value);
				//alert(ui.item.value);
				$('#add_item_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: itemScannedSuccess});

			}
		});

		$('#item,#customer').click(function()
		{
			$(this).attr('value','');
		});

		$( "#customer" ).autocomplete({
			source: 'http://#/pos/index.php/sales/customer_search',
			delay: 10,
			autoFocus: false,
			minLength: 1,
			select: function(event, ui)
			{
				$("#customer").val(ui.item.value);
				$('#select_customer_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
			}
		});

		$('#customer').blur(function()
		{
			$(this).attr('value',"Type customer name...");
		});

		$('#item').blur(function()
		{
			$(this).attr('value',"Enter item name or scan barcode");
		});

		//Datepicker change
		$('#change_sale_date_picker').datepicker().on('changeDate', function(ev) {
			$.post('http://#/pos/index.php/sales/set_change_sale_date', {change_sale_date: $('#change_sale_date').val()});
		});

		//Input change
		$("#change_sale_date").change(function(){
			$.post('http://#/pos/index.php/sales/set_change_sale_date', {change_sale_date: $('#change_sale_date').val()});
		});

		$('#change_sale_date_enable').change(function()
		{
			$.post('http://#/pos/index.php/sales/set_change_sale_date_enable', {change_sale_date_enable: $('#change_sale_date_enable').is(':checked') ? '1' : '0'});
		});

		$('#comment').change(function()
		{
			$.post('http://#/pos/index.php/sales/set_comment', {comment: $('#comment').val()});
		});

		$('#show_comment_on_receipt').change(function()
		{
			$.post('http://#/pos/index.php/sales/set_comment_on_receipt', {show_comment_on_receipt:$('#show_comment_on_receipt').is(':checked') ? '1' : '0'});
		});

		$('#email_receipt').change(function()
		{
			$.post('http://#/pos/index.php/sales/set_email_receipt', {email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'});
		});

		$('#save_credit_card_info').change(function()
		{
			$.post('http://#/pos/index.php/sales/set_save_credit_card_info', {save_credit_card_info:$('#save_credit_card_info').is(':checked') ? '1' : '0'});
		});

		$('#change_sale_date_enable').is(':checked') ? $("#change_sale_input").show() : $("#change_sale_input").hide();

		$('#change_sale_date_enable').click(function() {
			if( $(this).is(':checked')) {
				$("#change_sale_input").show();
			} else {
				$("#change_sale_input").hide();
			}
		});

		$('#use_saved_cc_info').change(function()
		{
			$.post('http://#/pos/index.php/sales/set_use_saved_cc_info', {use_saved_cc_info:$('#use_saved_cc_info').is(':checked') ? '1' : '0'});
		});

		$("#finish_sale_button").click(function()
		{
			//Prevent double submission of form
			$("#finish_sale_button").hide();
			$("#register_container").mask("Please wait...");



					if ($("#comment").val())
					{
						$.post('http://#/pos/index.php/sales/set_comment', {comment: $('#comment').val()}, function()
						{
							$('#finish_sale_form').submit();
						});
					}
					else
					{
						$('#finish_sale_form').submit();
					}

									});

		$("#suspend_sale_button").click(function()
		{
			if (confirm("Are you sure you want to suspend this sale?"))
			{
									$("#register_container").load('http://#/pos/index.php/sales/suspend');
							}
		});

		$("#cancel_sale_button").click(function()
		{
			if (confirm("Are you sure you want to clear this sale? All items will cleared."))
			{
				$('#cancel_sale_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
			}
		});

		$("#add_payment_button").click(function()
		{
			$('#add_payment_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
		});

		$("#payment_types").change(checkPaymentTypeGiftcard).ready(checkPaymentTypeGiftcard);
		$('#mode').change(function()
		{
			if ($(this).val() == "store_account_payment") { // Hiding the category grid
				$('#show_hide_grid_wrapper, #category_item_selection_wrapper').fadeOut();
			}else { // otherwise, show the categories grid
				$('#show_hide_grid_wrapper, #show_grid').fadeIn();
				$('#hide_grid').fadeOut();
			}
			$('#mode_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
		});

		$('.delete_item, .delete_payment, #delete_customer').click(function(event)
		{
			event.preventDefault();
			$("#register_container").load($(this).attr('href'));
		});

		$("#tier_id").change(function()
		{
			$.post('http://#/pos/index.php/sales/set_tier_id', {tier_id: $(this).val()}, function()
			{
				$("#register_container").load('http://#/pos/index.php/sales/reload');
			});
		});

		$("input[type=text]").not(".description").click(function() {
			$(this).select();
		});

		//alert(screen.width);
		if(screen.width <= 768) //set the colspan on page load
		{
			jQuery('td.edit_discription').attr('colspan', '2');
		}

		 $(window).resize(function() {
			var wi = $(window).width();

			if (wi <= 768){
				jQuery('td.edit_discription').attr('colspan', '2');
			}
			else {
				jQuery('td.edit_discription').attr('colspan', '4');
			}
		});

		$("#new-customer").click(function()
		{
			$("body").mask("Please wait...");
		});
	});

function checkPaymentTypeGiftcard()
{
	if ($("#payment_types").val() == "Gift Card")
	{
		$("#amount_tendered").val('');
		$("#amount_tendered").focus();
		giftcard_swipe_field($("#amount_tendered"));
	}
}

function salesBeforeSubmit(formData, jqForm, options)
{
	if (submitting)
	{
		return false;
	}
	submitting = true;
	$("#ajax-loader").show();
	$("#add_payment_button").hide();
	$("#finish_sale_button").hide();
}

function itemScannedSuccess(responseText, statusText, xhr, $form)
{

	if(($('#code').val())== 1){
		gritter("Error",'Item not Found','gritter-item-error',false,true);

		}else{
		gritter("Success","Item Addedd Successfully",'gritter-item-success',false,true)
		}
	setTimeout(function(){$('#item').focus();}, 10);
	setTimeout(function(){

			$.gritter.removeAll();
			return false;

		},1000);
}


</script></div>




<script type="text/javascript">
$(document).ready(function()
{

	if ($("#invoice_no").val() != ''){
		$("#register_container").load('deptWinningAdd.php');
		}

	$("#show_grid").click(function()
	{
		$("#category_item_selection_wrapper").slideDown();
		$("#show_grid").hide();
		$("#hide_grid").show();
	});

	$("#hide_grid,#hide_grid_top").click(function()
	{
		$("#category_item_selection_wrapper").slideUp();
		$("#show_grid").show();
		$("#hide_grid").hide();
	});

 	var current_category = null;

	function load_categories()
	{
		$.get('http://#/pos/index.php/sales/categories', function(json)
		{
			processCategoriesResult(json);
		}, 'json');
	}

	$(document).on('click', ".pagination.categories a", function(event)
	{
		$("#category_item_selection_wrapper").mask("Please wait...");
		event.preventDefault();
		var offset = $(this).attr('href').substring($(this).attr('href').lastIndexOf('/') + 1);

		$.get('http://#/pos/index.php/sales/categories/'+offset, function(json)
		{
			processCategoriesResult(json);

		}, "json");
	});

	$(document).on('click', ".pagination.items a", function(event)
	{
		$("#category_item_selection_wrapper").mask("Please wait...");
		event.preventDefault();
		var offset = $(this).attr('href').substring($(this).attr('href').lastIndexOf('/') + 1);

		$.post('http://#/pos/index.php/sales/items/'+offset, {category: current_category}, function(json)
		{
			processItemsResult(json);
		}, "json");
	});

	$('#category_item_selection_wrapper').on('click','.category_item.category', function(event)
	{
		$("#category_item_selection_wrapper").mask("Please wait...");

		event.preventDefault();
		current_category = $(this).text();
		$.post('http://#/pos/index.php/sales/items', {category: current_category}, function(json)
		{
			processItemsResult(json);
		}, "json");
	});

	$('#category_item_selection_wrapper').on('click','.category_item.item', function(event)
	{
		$("#category_item_selection_wrapper").mask("Please wait...");
		event.preventDefault();
		$( "#item" ).val($(this).data('id'));
		$('#add_item_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: function()
		{
			gritter("Success","You have successfully added item",'gritter-item-success',false,false);			$("#category_item_selection_wrapper").unmask();
		}});
	});

	$("#category_item_selection_wrapper").on('click', '#back_to_categories', function(event)
	{
		$("#category_item_selection_wrapper").mask("Please wait...");

		event.preventDefault();
		load_categories();
	});

	function processCategoriesResult(json)
	{
		$("#category_item_selection_wrapper .pagination").removeClass('items').addClass('categories');
		$("#category_item_selection_wrapper .pagination").html(json.pagination);

		$("#category_item_selection").html('');

		for(var k=0;k<json.categories.length;k++)
		{
			//var category_item = $("<div/>").attr('class', 'category_item category col-md-2').append('<p>'+json.categories[k]+'</p>');
			 var category_item = $("<div/>").attr('class', 'category_item category col-md-2 col-sm-3 col-xs-6').append('<p>'+json.categories[k]+'</p>');
			$("#category_item_selection").append(category_item);
		}

		$("#category_item_selection_wrapper").unmask();
	}

	function processItemsResult(json)
	{
		$("#category_item_selection_wrapper .pagination").removeClass('categories').addClass('items');
		$("#category_item_selection_wrapper .pagination").html(json.pagination);

		$("#category_item_selection").html('');

		var back_to_categories_button = $("<div/>").attr('id', 'back_to_categories').attr('class', 'category_item back-to-categories col-md-2 col-sm-3 col-xs-6 ').append('<p>&laquo; '+"Back To Categories"+'</p>');
		//var back_to_categories_button = $("<div/>").attr('id', 'back_to_categories').attr('class', 'category_item item category_list').append('<p>&laquo; '+"Back To Categories"+'</p>');
		$("#category_item_selection").append(back_to_categories_button);

		for(var k=0;k<json.items.length;k++)
		{
			var image_src = json.items[k].image_src;
			var prod_image = "";
			var item_parent_class = "";
			if (image_src != '' ) {
				var item_parent_class = "item_parent_class";
				var prod_image = '<div class="prod_image"><img style="width:167px; height:80px;" src="'+image_src+'" alt="" /></div>';
			}

			var item = $("<div/>").attr('class', 'category_item item col-md-2 col-sm-3 col-xs-6  '+item_parent_class).attr('data-id', json.items[k].id).append(prod_image+'<p>'+json.items[k].name+'</p>');
			$("#category_item_selection").append(item);
			var d_id = json.items[k].id;
			//alert( $("#"+d_id).html());
			//if (image_src != '' )
			 //$("div[data-id='" + d_id + "']").attr('style', 'background:rgba(255, 255, 255, 0.5) url('+image_src+') ;background-size:167px 80px;background-repeat:no-repeat;');

		}

		$("#category_item_selection_wrapper").unmask();

	}
	load_categories();
});
var last_focused_id = null;
setTimeout(function(){$('#item').focus();}, 10);
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


<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-1" tabindex="0" style="display: none;"></ul><ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-2" tabindex="0" style="display: none;"></ul></body></html>