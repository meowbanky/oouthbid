<?php require_once('Connections/bid.php'); ?>
<?php

session_start();

 

//$prefix = substr($_SESSION['companyName'],0,3);

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



	
	
mysqli_select_db($bid,$database_bid);
$query_company = sprintf("SELECT tbl_company.company_id,tbl_company.company_name FROM
tbl_company ");
$company = mysqli_query($bid,$query_company) or die(mysqli_error($bid));
$row_company = mysqli_fetch_assoc($company);
$totalRows_company = mysqli_num_rows($company);
	

	
	



	
$col_itemSearch = "-1";
if (isset($_POST['company'])) {
  $col_itemSearch = $_POST['company'];
}
mysqli_select_db($bid,$database_bid);
$query_itemSearch = sprintf("SELECT item_price.price, tbl_company.company_name, items.item, items.packSize, items.qty, tbl_evaluation.percentage, tbl_lot.lot_description, tbl_dept.dept,
item_price.item_id,items.packSize,items.qty as require_year,
items.qty*(tbl_evaluation.percentage/100) as qtyAwarded FROM tbl_evaluation INNER JOIN item_price ON item_price.item_price_id = tbl_evaluation.item_price_id INNER JOIN tbl_company ON tbl_company.company_id = item_price.company_id
INNER JOIN items ON items.item_id = item_price.item_id INNER JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
WHERE item_price.company_id = %s ORDER BY items.item_id", GetSQLValueString($col_itemSearch, "text"));
$itemSearch = mysqli_query($bid,$query_itemSearch) or die(mysqli_error($bid));
$row_itemSearch = mysqli_fetch_assoc($itemSearch);
$totalRows_itemSearch = mysqli_num_rows($itemSearch);


if (!isset($_SESSION['SESS_INVOICE']) or ($_SESSION['SESS_INVOICE'] == '')){
$_SESSION['SESS_INVOICE'] = $prefix.'-'.createRandomPassword();


}

?>





<div id="content-header" class="hidden-print sales_header_container">
	<h1 class="headigs"> <i class="icon fa fa-shopping-cart"></i>
		<span id="ajax-loader"><img src="img/ajax-loader.gif" alt=""/></span>
			</h1>
	
    
    
</div>

<div class="clear"></div>
	<!--Left small box-->
	<div class="row">
<div class="sale_register_leftbox col-md-9">
			<div class="row forms-area">
										<div class="col-md-8 no-padd">
							
			  </div>					
												
				<div class="col-md-4 no-padd">
					
								
			     <form action="companyWinningAdd.php" method="post" accept-charset="utf-8" class="line_item_form" id="employee_form" autocomplete="off"> 
                     <label for="company">Select Company:
                  <select name="company" required="required" id="company" class="select_test" >
                                 <option value="0">Select Bidding Company</option>
                                 <?php
do {  
?>
                    <option value="<?php echo $row_company['company_id']?>"><?php echo $row_company['company_name']?></option>
                                 <?php
} while ($row_company = mysqli_fetch_assoc($company));
  $rows = mysqli_num_rows($company);
  if($rows > 0) {
      mysqli_data_seek($company, 0);
	  $row_company = mysqli_fetch_assoc($company);
  }
?>
                               </select></label>
                  <label for="Percentage">Select %:
                  <select name="percentage" id="percentage" class="select_test">
                    <option value="0.25">25%</option>
                    <option value="0.5">50%</option>
                    <option value="0.75">75%</option>
                    <option value="1">100%</option>
                  </select></label>
                    </form>
				</div>
	
			</div>
		
		<div class="row">
			
		  <div class="table-responsive">
            
            
            
            </div>
            <?php if($totalRows_itemSearch > 0){ ?>
		  <ul class="list-inline pull-left"><strong><?php echo $row_itemSearch['company_name']?> DEPT.: <?php echo $row_itemSearch['dept']?></strong>
		    <table id="register" class="table table-bordered">
						    
						    <thead>
						<tr><th class="item_name_heading"><strong>S/N</strong></th>
						      <th class="item_name_heading"><strong>ITEM NO</strong></th>
						     <th class="item_name_heading">DRUGS/ITEMS</strong></th>
						      <th class="item_name_heading"><strong>UNIT/ PACK</strong></th>
						      <th class="item_name_heading"><strong>TOTAL QTY AWARDED</strong></th>
						      <th class="item_name_heading"><strong>TOTAL QTY/YR</strong></th>
						      <th class="item_name_heading"><strong>QUOTED PRICE</strong></th>
						      <th class="item_name_heading"><strong> AMOUNT </strong></th>
					        </tr>
                        </thead>
						   <?php if ($totalRows_itemSearch > 0) {	?>	<?php $total=0; $i = 1; do { ;?> <tr>
						      <td><?php echo $i;?></td>
                                <td><?php echo $row_itemSearch['item_id']?></td>
						      <td><?php echo $row_itemSearch['item']?></td>
						      <td width="65"><?php echo $row_itemSearch['packSize']?></td>
						      <td width="78"><?php echo number_format($row_itemSearch['qtyAwarded'])?></td>
						      <td width="78"><?php echo $row_itemSearch['require_year']?></td>
						      <td width="162"><?php echo number_format($row_itemSearch['price'])?></td>
						      <td width="214" align="right"><?php echo number_format($row_itemSearch['price']*$row_itemSearch['qtyAwarded']) ?></td>
					       <?php $i = $i+1; $total=$total+($row_itemSearch['price']*$row_itemSearch['qtyAwarded']);} while ($row_itemSearch = mysqli_fetch_assoc($itemSearch)); ?><?php } ?>
                        </tr>
            <tr>
            <td colspan="8" align="right"><strong>
           <?php if ($totalRows_itemSearch > 0) {	?> Grand total: <?php echo number_format($total);?><?php }?></strong></td></tr>
					      </table>
								
										
            </ul>
            <?php }else {
                echo 'No Data Available';
            } ?>
											
						</div>
						
						
							

					</div>
					<!-- Right small box  -->
				<div class="col-md-3 sale_register_rightbox">
				<h5 class="customer-basic-information"><form action="printAward.php" method="post" accept-charset="utf-8" id="sales_change_form">	<button class="btn btn-primary text-white hidden-print" id="edit_sale" onclick="submit()" > Print </button>
				  <input name="company_id" type="hidden" id="company_id" value="<?php if(isset($_POST['company'])){ echo $_POST['company']; } ?>"><input type="hidden" name="percentage" id="percentage" value="<?php if(isset($_POST['percentage'])){echo $_POST['percentage'];} ?>">

	            </form></h5>
	</div>
<script type="text/javascript">
var submitting = false;
	$(document).ready(function()
	{
		
        
        // $(".select_test").select2();
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

		$('#mode_form, #select_customer_form, #add_payment_form, .line_item_form, #discount_all_form').ajaxForm
({target: "#register_container", beforeSubmit: salesBeforeSubmit});
		$('#add_item_form').ajaxForm({target: "#register_container", beforeSubmit: salesBeforeSubmit, success
: itemScannedSuccess});
		$("#company").change(function()
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
				$('#add_item_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: itemScannedSuccess});
			}
		});

		$('#item,#customer').click(function()
		{
			$(this).attr('value','');
		});

		$( "#customer" ).autocomplete({
			source: 'salecustomersearch.php',
			delay: 10,
			autoFocus: false,
			minLength: 1,
			select: function(event, ui)
			{
				$("#customer").val(ui.item.value);
				$('#select_customer_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit
});
			}
		});
		
		
		
		
		$('#new-customer').click(function()
		{
			$('#select_customer_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit
});
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
			$.post('http://#/pos/index.php/sales/set_change_sale_date', {change_sale_date
: $('#change_sale_date').val()});			
		});
		
		//Input change
		$("#change_sale_date").change(function(){
			$.post('http://#/pos/index.php/sales/set_change_sale_date', {change_sale_date
: $('#change_sale_date').val()});			
		});

		$('#change_sale_date_enable').change(function() 
		{
			$.post('http://#/pos/index.php/sales/set_change_sale_date_enable', {change_sale_date_enable
: $('#change_sale_date_enable').is(':checked') ? '1' : '0'});
		});

		$('#comment').change(function() 
		{
			$.post('http://#/pos/index.php/sales/set_comment', {comment: $('#comment')
.val()});
		});
						
		$('#show_comment_on_receipt').change(function() 
		{
			$.post('http://#/pos/index.php/sales/set_comment_on_receipt', {show_comment_on_receipt
:$('#show_comment_on_receipt').is(':checked') ? '1' : '0'});
		});

		$('#email_receipt').change(function() 
		{	
			$.post('http://#/pos/index.php/sales/set_email_receipt', {email_receipt: $
('#email_receipt').is(':checked') ? '1' : '0'});
		});

		$('#save_credit_card_info').change(function() 
		{
			$.post('http://#/pos/index.php/sales/set_save_credit_card_info', {save_credit_card_info
:$('#save_credit_card_info').is(':checked') ? '1' : '0'});
		});

		$('#change_sale_date_enable').is(':checked') ? $("#change_sale_input").show() : $("#change_sale_input"
).hide(); 

		$('#change_sale_date_enable').click(function() {
			if( $(this).is(':checked')) {
				$("#change_sale_input").show();
			} else {
				$("#change_sale_input").hide();
			}
		});

		$('#use_saved_cc_info').change(function() 
		{
			$.post('http://#/pos/index.php/sales/set_use_saved_cc_info', {use_saved_cc_info
:$('#use_saved_cc_info').is(':checked') ? '1' : '0'});
		});

		$("#finish_sale_button").click(function()
		{
			//Prevent double submission of form
			$("#finish_sale_button").hide();
			$("#register_container").mask("Please wait...");
			
							
				//if (!confirm("Are you sure you want to confirm payment?"))
//				{
//					//Bring back submit and unmask if fail to confirm
//					$("#finish_sale_button").show();
//					$("#register_container").unmask();
//					
//					return;
//				}
						
																		
					if ($("#comment").val())
					{
						$.post('#', {comment: $('#comment'
).val()}, function()
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
									$("#register_container").load('SalesAdd.php?suspend=suspend'
);
							}
		});

		$("#cancel_sale_button").click(function()
		{
			if (confirm("Are you sure you want to clear this sale? All items will cleared."))
			{
				$('#cancel_sale_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit
});
			}
		});

		$("#add_payment_button").click(function()
		{
			$('#add_payment_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit
});
		});

$("#add_customer_button").click(function()
		{
			$('#Add_customer_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit
});
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
			$.post('http://#/pos/index.php/sales/set_tier_id', {tier_id: $(this).val()
}, function()
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
		gritter("Error",'Item not Found','gritter-item-error', false,true);
		
		}else{
		gritter("Success","Item Addedd Successfully",'gritter-item-success',false,true)
		}
	setTimeout(function(){$('#item').focus();}, 10);
	
	setTimeout(function(){

			$.gritter.removeAll();
			return false;

		},1000);
	
}
    </script>
