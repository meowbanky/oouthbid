<?php require_once('Connections/bid.php'); ?>
<?php

//session_start();
include('session_check.php');

$prefix = substr($_SESSION['companyName'],0,3);

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



	
	
	

	
	if ((isset($_POST['percentage'])) and (is_numeric($_POST['percentage']))){
	mysqli_select_db($bid,$database_bid);;
        
        $validatePercentSQL = sprintf("SELECT sum(percentage) as percentage FROM tbl_evaluation WHERE item_id = %s", GetSQLValueString($_POST['item_id'],"int"));
        $validatePercentSQL = mysqli_query($bid,$validatePercentSQL) or die(mysqli_error($bid));
        $row_validateSQL = mysqli_fetch_assoc($validatePercentSQL);
        $totalRows_validatePercentSQL = mysqli_num_rows($validatePercentSQL);
        
        if ((($row_validateSQL['percentage'])+($_POST['percentage'])) <= 100){
	   $validateSQL = sprintf("Select * from tbl_evaluation where item_price_id = %s", GetSQLValueString($_POST['item_price_id'],"int"));
        $validate = mysqli_query($bid,$validateSQL) or die(mysqli_error($bid));
        $row_validateSQL = mysqli_fetch_assoc($validate);
        $totalRows_validateSQL = mysqli_num_rows($validate);
        
        if($totalRows_validateSQL > 0){
            
             $updateEvaluationSQL = sprintf("update tbl_evaluation set percentage = %s where item_price_id = %s",
					   GetSQLValueString($_POST['percentage'], "int"),
                        GetSQLValueString($_POST['item_price_id'], "float"));

              mysqli_select_db($bid,$database_bid);;
              $Result1 = mysqli_query($bid,$updateEvaluationSQL) or die(mysqli_error($bid));
            
        }else{
        $insertEvaluationSQL = sprintf("INSERT INTO tbl_evaluation (item_price_id,percentage,item_id) VALUES (%s, %s,%s)",
					   GetSQLValueString($_POST['item_price_id'], "int"),
                        GetSQLValueString($_POST['percentage'], "float"),
                        GetSQLValueString($_POST['item_id'], "int"));

  mysqli_select_db($bid,$database_bid);;
  $Result1 = mysqli_query($bid,$insertEvaluationSQL) or die(mysqli_error($bid));
	}
		
	}
    }

	

if (isset($_POST['item'])) {
  $_SESSION['item'] = $_POST['item'];
}else{
   if(!isset($_SESSION['item'])){
       $_SESSION['item'] = "-1";
   }
}
mysqli_select_db($bid,$database_bid);;
$query_itemSearch = sprintf("SELECT
tbl_company.company_name,
item_price.price,
item_price.qty,item_price.qty*item_price.price as orderbyy,
items.item,
items.packSize,IFNULL(items.spec,'') AS spec,
item_price.item_id,
item_price.lot_id,
item_price.item_price_id,
tbl_company.company_id,
tbl_dept.dept,
tbl_lot.lot_description,
tbl_lot.lot_id,
tbl_dept.dept_id
FROM
item_price
INNER JOIN tbl_company ON tbl_company.company_id = item_price.company_id
INNER JOIN items ON items.item_id = item_price.item_id
INNER JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id
INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
WHERE items.item_id = %s ORDER BY orderbyy DESC",GetSQLValueString($_SESSION['item'], "int"));
$itemSearch = mysqli_query($bid,$query_itemSearch) or die(mysqli_error($bid));
$row_itemSearch = mysqli_fetch_assoc($itemSearch);
$totalRows_itemSearch = mysqli_num_rows($itemSearch);

mysqli_select_db($bid,$database_bid);;
$query_itemModal = sprintf("SELECT
tbl_company.company_name,
item_price.price,
item_price.qty,
items.item,
items.packSize,
item_price.item_id,
item_price.lot_id,
item_price.item_price_id,
tbl_company.company_id,
tbl_dept.dept,
tbl_lot.lot_description,
tbl_lot.lot_id,
tbl_dept.dept_id
FROM
item_price
INNER JOIN tbl_company ON tbl_company.company_id = item_price.company_id
INNER JOIN items ON items.item_id = item_price.item_id
INNER JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id
INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
WHERE items.item_id = %s ORDER BY price ASC",GetSQLValueString($_SESSION['item'], "int"));
$itemModal = mysqli_query($bid,$query_itemModal) or die(mysqli_error($bid));
$row_itemModal = mysqli_fetch_assoc($itemModal);
$totalRows_itemModal = mysqli_num_rows($itemModal);


if ($totalRows_itemSearch > 0){
    $_SESSION['item'] = $row_itemSearch['item_id'];
    
}else{
  $_SESSION['item'] = -1;  
    
}

mysqli_select_db($bid,$database_bid);;
$query_evaluation = sprintf("SELECT
tbl_evaluation.percentage,
item_price.price,
item_price.item_id,
tbl_evaluation.evaluation_id,
tbl_company.company_name,
items.item,
tbl_lot.lot_description,
tbl_dept.dept,
tbl_lot.lot_id,
tbl_dept.dept_id,
items.packSize,
item_price.qty
FROM
tbl_evaluation
LEFT JOIN item_price ON tbl_evaluation.item_price_id = item_price.item_price_id
INNER JOIN tbl_company ON tbl_company.company_id = item_price.company_id
INNER JOIN items ON items.item_id = item_price.item_id
INNER JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id
INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
WHERE items.item_id = %s ORDER BY price ASC", GetSQLValueString($_SESSION['item'], "int"));
$evaluation = mysqli_query($bid,$query_evaluation) or die(mysqli_error($bid));
$row_evaluation = mysqli_fetch_assoc($evaluation);
$totalRows_evaluation = mysqli_num_rows($evaluation);





if (!isset($_SESSION['SESS_INVOICE']) or ($_SESSION['SESS_INVOICE'] == '')){
$_SESSION['SESS_INVOICE'] = $_SESSION['companyName'];


}

?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<div id="content-header" class="hidden-print sales_header_container">
	<h1 class="headigs"> <i class="icon fa fa-shopping-cart"></i><?php //echo $_SESSION['SESS_INVOICE'] ?><span id="ajax-loader"><img src="img/ajax-loader.gif" alt=""/></span>
			</h1>
	
    
    
</div>

<div class="clear"></div>
	<!--Left small box-->
	<div class="row">
		<div class="sale_register_leftbox col-md-9" style="width: 100%">
			<div class="row forms-area">
										<div class="col-md-8 no-padd">
							<div class="input-append">
								<form action="evaluationAdd.php" method="post" accept-charset
="utf-8" id="add_item_form" class="form-inline" autocomplete="off">								<input name="item" type="text" class="input-xlarge" id="item" placeholder="Enter item name or lot no" accesskey="i"
 value="" size="60"
  />																
								  <input name="code" type="hidden" id="code" value="<?php if (isset($error)){echo $error; }else {echo -1;} ?>" />
							  </form>
							</div>
						</div>					
												
			  <div class="col-md-4 no-padd"></div>
	
			</div>
		<div class="clear" style="padding: 10px;"> </div>
            <div class="clear" style="padding: 10px;">
            
            


<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target=".myModal">
  Overview
</button> 

<!-- Modal -->
<div class="modal fade myModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Overview</h4>
      </div>
      <div class="modal-body">
         <table border="1" class="wrap_trs">
    <tr>
        <?php if ($totalRows_itemModal > 0) {	?>	<?php do { ?><td><?php echo $row_itemModal['company_name']; ?><br><?php echo number_format($row_itemModal['price'],2); ?></td><?php } while ($row_itemModal = mysqli_fetch_assoc($itemModal)); ?><?php } ?>
       
    </tr>
</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

            </div>
		<div class="row" style="will-change: 100%">
			<div class="col-md-4" style="width: 60%">
                <div id="datatable_wrapper">
						<div class="table-responsive">
                            <?php if($totalRows_itemSearch > 0){ ?>
                          <strong>ITEM NO: <?php echo $row_itemSearch['item_id']; ?> - <?php echo $row_itemSearch['item']; ?> -&nbsp;<?php echo $row_itemSearch['dept']; ?>&nbsp; - <?php echo $row_itemSearch['lot_description']; ?><br>QUANTITY DESIRED/YEAR: <?php echo $row_itemSearch['qty']; ?> 
						  PACK SIZE:<?php echo $row_itemSearch['packSize']; ?>  SPECIFICATION:<?php echo $row_itemSearch['spec']; ?> </strong>
				          <?php } ?>
                            <div class="widget-content nopadding table_holder table-responsive">
                                <table class="tablesorter table table-bordered  table-hover" id="sortable_table">
                    <thead>
						<tr>
						  <th class="item_name_heading" >Company Name</th>
                            <th class="sales_stock">Price</th>
							<th class="sales_stock">Total</th>
							<th class="sales_stock">%</th>
                        </tr>
                    </thead>
  <tbody id="cart_contents" class="sa">
   <?php if ($totalRows_itemSearch > 0) {	?>	<?php do { ?> <tr>
      <th align="left" scope="col"><?php echo $row_itemSearch['company_name']; ?></th>
      <th scope="col"><?php echo number_format($row_itemSearch['price'],2); ?>&nbsp;</th>
      <th scope="col"><?php echo number_format($row_itemSearch['qty']*$row_itemSearch['price'],2); ?>&nbsp;</th>
      <th scope="col"><span class="line_item_form">
													        <form action="evaluationAdd.php" method="post" accept-charset="utf-8" class="line_item_form" id="employee_form" autocomplete="off"><input name="percentage" type="text" class="input-small" id="percentage" inputmode="numeric" pattern="[0-9]*" accesskey="q" value="" size="5" />	<input name="item_price_id" type="hidden" id="item_price_id" value="<?php echo $row_itemSearch['item_price_id'] ?>" />	
													          <input name="item_id" type="hidden" id="item_id" value="<?php echo $row_itemSearch['item_id'] ?>" />		<input name="company_id" type="hidden" id="company_id" value="<?php echo $row_itemSearch['company_id'] ?>" />									
		          </form>
													      </span></th>
    </tr> 
     <?php } while ($row_itemSearch = mysqli_fetch_assoc($itemSearch)); ?><?php } // Show if recordset not empty ?>
  </tbody>
</table>
</div></div>		<div class="pagination hidden-print alternate text-center fg-toolbar ui-toolbar"></div>
			</div>
                </div>
            <div class="col-md-4" align="center">
            
            </div>
            <div class="col-md-4">
                <?php if($totalRows_evaluation > 0 ) { ?>
                <strong>ITEM NO: <?php echo $row_evaluation['item_id']; ?> - <?php echo $row_evaluation['item']; ?> -&nbsp;<?php echo $row_evaluation['dept']; ?>&nbsp; - <?php echo $row_evaluation['lot_description']; ?><br>QUANTITY DESIRED/YEAR: <?php echo $row_evaluation['qty']; ?> PACK SIZE:<?php echo $row_evaluation['packSize']; ?></strong>
                <?php } ?>
           <div class="widget-content nopadding table_holder table-responsive">
							
                                <table class="tablesorter table table-bordered  table-hover" id="sortable_table2">
                    <thead>
						<tr>
						  <th class="item_name_heading" >Company Name</th>
                            <th class="sales_stock">Price</th>
							<th class="sales_stock">Total</th>
							<th class="sales_stock">%</th>
							<th class="sales_stock"><button id="deletbutton" class="btn-danger">Delete Selected</button></th>
                        </tr>
                    </thead>
  <tbody id="cart_contents" class="sa">
   <?php if ($totalRows_evaluation > 0) {	?>	<?php do { ?> <tr>
      <th align="left" scope="col"><?php echo $row_evaluation['company_name']; ?></th>
      <th scope="col"><?php echo number_format($row_evaluation['price'],2); ?>&nbsp;</th>
      <th scope="col"><?php echo number_format($row_evaluation['qty']*$row_evaluation['price'],2); ?>&nbsp;</th>
      <th scope="col"><?php echo $row_evaluation['percentage']?></th>
      <th scope="col"><input type="checkbox" name="checkbox" id="checkbox" value="<?php echo $row_evaluation['evaluation_id'];?>"></th>
    </tr> 
     <?php } while ($row_evaluation = mysqli_fetch_assoc($evaluation)); ?><?php } // Show if recordset not empty ?>
  </tbody>
</table></div></div>		<div class="pagination hidden-print alternate text-center fg-toolbar ui-toolbar"></div>
            
            </div>
						<ul class="list-inline pull-left">
								
										
			</ul>
											
		  </div>
						
						
							

					</div>
					<!-- Right small box  -->

					  <!-- Cancel and suspend buttons --></li>
				<div class="row">
				
				

					<div id='sale_details'></div>
                    <li class="list-group-item">
				  					
 </li>
				</li>
                   </div>
</div>
				<li class="list-group-item spacing">
                    
				</li>

				
		</ul>

		</div>
</div>
<script type="text/javascript">
	// gritter("Warning","Warning, Desired Quantity is Insufficient. You can still process the sale, but check
// your inventory",'gritter-item-warning',false,false);</script>

<script type="text/javascript" language="javascript">

    var submitting = false;
	$(document).ready(function()
	{
		$('table.wrap_trs tr').unwrap(); 
            var cells = $('table.wrap_trs tr td');
            for (var i = 0; i < cells.length; i += 4) {
                cells.slice(i, i + 4).wrapAll('<tr></tr>');
            }
            
            //var tableSearch = $('#sortable_table').dataTable();
//                $("#search").keyup(function() {
//                    tableSearch.fnFilter(this.value);
//                }); 

        
        
        $('#sortable_table').DataTable( {
        //"dom": '<"top"i><"clear">f<"clear">rt<"bottom"lp><"clear">'
            dom: '<"pagination_top.pagination hidden-print alternate text-center fg-toolbar ui-toolbar"fp><"clear">lt<"pagination_top.pagination hidden-print alternate text-center fg-toolbar ui-toolbar"i>'
    } );
        
        $('#sortable_table2').DataTable( {
        //"dom": '<"top"i><"clear">f<"clear">rt<"bottom"lp><"clear">'
            dom: '<"pagination_top.pagination hidden-print alternate text-center fg-toolbar ui-toolbar"f><"clear">lt<"pagination_top.pagination hidden-print alternate text-center fg-toolbar ui-toolbar"i>'
    } );
        //bottom i
        
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
		$("#cart_contents input").change(function()
		{
			$(this.form).ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit});
		});
        
        

		$( "#item" ).autocomplete({
			source: 'evaluationItemSearch.php',
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
			$(this).attr('value',"Enter item name");
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
						$.post('#', {comment: $('#comment').val()}, function()
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
				$("#register_container").load('SalesAdd.php?suspend=suspend');
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
		
		}else if(($('#code').val())== 2){ 
        gritter("Error",'Item Price already Added','gritter-item-error', false,true);
        }
    else{
		gritter("Success","Item Addedd Successfully",'gritter-item-success',false,true)
		}
	setTimeout(function(){$('#item').focus();}, 10);
	
	setTimeout(function(){

			$.gritter.removeAll();
			return false;

		},1000);
	
}



</script>
<script>
        
        
     $("button").click(function(){
         $("#deletbutton").text('Deleting..');
         var page = 'deletecheckedevaluation.php?id=';
        if ($('input[type=checkbox]:checked').length > 0){
            $.confirm({
    title: 'Confirm!',
    content: 'Are you sure you want to delete the Company !',
    buttons: {
        confirm: function () {
       $('input[type=checkbox]:checked').each(function(){
         var status = (this.checked ? $(this).val(): "");
         var ido = $(this).attr("value");
          
        $.ajax({url: page+ido, success: function(result){
     // $("#div1").html(result);
        $("#register_container").load('evaluationAdd.php');
        
    }});
            
           
          });
            },
        cancel: function () {
            //$.alert('Canceled!');
        }
    }
});
        }else{
            $.alert({
    title: 'Alert!',
    content: 'Select at least one item to delete!',
});
            //alert("Select at least one item to delete");
        }
         
         $("#deletbutton").text('Delete Selected');
        
  });
    

    </script>
<?php
mysqli_free_result($itemSearch);

//mysql_free_result($invoice);
?>
