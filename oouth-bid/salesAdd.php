<?php require_once('Connections/bid.php'); ?>
<?php

//session_start();
include('session_check.php');

$prefix = substr($_SESSION['companyName'],0,3);
global $bid;
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








	if (isset($_GET['deleid'])){

	$deleteSQL = sprintf("DELETE FROM item_price WHERE item_id = %s and company_id = %s",
					   GetSQLValueString($_GET['deleid'], "int"),
                        GetSQLValueString($_SESSION['company_id'], "int"));

  mysqli_select_db($bid,$database_bid);
  $Result1 = mysqli_query($bid,$deleteSQL) or die(mysql_error());


	}

if (isset($_POST['amount_tendered'])){

	$query_amountCheck = sprintf("SELECT sales_payments.invoice_no FROM sales_payments WHERE sales_payments.invoice_no = %s", GetSQLValueString($_SESSION['SESS_INVOICE'], "text"));
$amountCheck = mysqli_query($bid,$query_amountCheck) or die(mysql_error());
$row_amountCheck = mysqli_fetch_assoc($amountCheck);
$totalRows_amountCheck = mysqli_num_rows($amountCheck);

	if ($totalRows_amountCheck == 0){


	$suspendSQL = sprintf("INSERT INTO sales_payments (invoice_no,payment_type,payment_amount,amount_tendered,payment_date) VALUES (%s, %s, %s,%s,now())",
					   GetSQLValueString($_SESSION['SESS_INVOICE'], "text"),
					   GetSQLValueString($_POST['payment_type'], "text"),
					   GetSQLValueString($_POST['amount_due'], "double"),
					   GetSQLValueString($_POST['amount_tendered'], "double"));


	} else {


		$suspendSQL = sprintf("UPDATE sales_payments SET amount_tendered = %s, payment_type = %s WHERE  invoice_no = %s",
					   GetSQLValueString($_POST['amount_tendered'], "double"),
					   GetSQLValueString($_POST['payment_type'], "text"),
					   GetSQLValueString($_SESSION['SESS_INVOICE'], "text"));

		}

		 mysqli_select_db($bid,$database_bid);
		 $Result1 = mysqli_query($bid,$suspendSQL) or die(mysqli_error($bid));

	}





$col_itemSearch = "-1";
if (isset($_POST['item'])) {
  $col_itemSearch = $_POST['item'];
}
mysqli_select_db($bid,$database_bid);
$query_itemSearch = sprintf("SELECT
items.item_id,
items.item,
items.packSize,
items.qty,
tbl_dept.dept,
tbl_lot.lot_description,
items.lot_id,
items.dept_id
FROM items LEFT JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id LEFT JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id WHERE items.item_id = %s", GetSQLValueString($col_itemSearch, "text"),GetSQLValueString($col_itemSearch, "int"));
$itemSearch = mysqli_query($bid,$query_itemSearch) or die(mysqli_error($bid));
$row_itemSearch = mysqli_fetch_assoc($itemSearch);
$totalRows_itemSearch = mysqli_num_rows($itemSearch);

if ($totalRows_itemSearch == 0){

$error = '1';


	}else{


$query_check = sprintf("SELECT * FROM item_price WHERE company_id = %s and item_id =  %s", GetSQLValueString($_SESSION['company_id'], "int"),
 GetSQLValueString($row_itemSearch['item_id'], "text"));
$check = mysqli_query($bid,$query_check) or die(mysqli_error($bid));
$row_check = mysqli_fetch_assoc($check);
$totalRows_check = mysqli_num_rows($check);

    if($totalRows_check > 0){
        $error = '2';
    }else{

if (isset($_POST['item'])) {



$insertSQL = sprintf("INSERT INTO item_price (item_id,company_id,user_id,lot_id, dept_id,qty) VALUES (%s, %s,%s,%s,%s,%s)",
					   GetSQLValueString($row_itemSearch['item_id'],"int"),
                        GetSQLValueString($_SESSION['company_id'], "int"),
					   GetSQLValueString($_SESSION['SESS_MEMBER_ID'], "int"),
                        GetSQLValueString($row_itemSearch['lot_id'],"int"),
                        GetSQLValueString($row_itemSearch['dept_id'], "int"),
                        GetSQLValueString($row_itemSearch['qty'], "int"));

  mysqli_select_db($bid,$database_bid);
  $Result1 = mysqli_query($bid,$insertSQL) or die(mysqli_error($bid));




	}
    }

}



if (isset($_POST['sales_item_id']) and (isset($_POST['price']))and ($_POST['price'] > 0) ) {

    if(!isset($_POST['price'])){
        $_POST['price'] = 0.00;


    }
	//echo $_POST['price'];
    $price = str_replace(',','',$_POST['price']);
$UpdateSales = sprintf("UPDATE item_price SET price = %s WHERE item_id = %s and company_id = %s",
                       GetSQLValueString($price, "float"),
					GetSQLValueString($_POST['sales_item_id'], "int"),
                     GetSQLValueString($_SESSION['company_id'], "int") );
mysqli_select_db($bid,$database_bid);
$Result1 = mysqli_query($bid,$UpdateSales) or die(mysqli_error($bid));


}

if (isset($_POST['remarks'])) {

$UpdateSales = sprintf("UPDATE item_price SET remarks = %s WHERE item_id = %s",GetSQLValueString($_POST['remarks'], "text"),
					GetSQLValueString($_POST['item_id'], "int"));
mysqli_select_db($bid,$database_bid);
$Result1 = mysqli_query($bid,$UpdateSales) or die(mysqli_error($bid));


}



$col_invoice = "-1";
if (isset($_SESSION['company_id'])) {
  $col_invoice = $_SESSION['company_id'];
}
mysqli_select_db($bid,$database_bid);
$query_invoice = sprintf("SELECT
item_price.item_price_id,
item_price.item_id,
item_price.company_id,
item_price.user_id,
item_price.price,IFNULL(items.spec,'') AS spec,
item_price.remarks,
item_price.lot_id,
item_price.dept_id,
items.item,
items.item_id,
items.packSize,
items.qty,
tbl_lot.lot_description,
tbl_dept.dept
FROM
item_price
INNER JOIN items ON items.item_id = item_price.item_id
INNER JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id
INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
WHERE company_id =  %s order by item_price_id desc", GetSQLValueString($col_invoice, "text"));
$invoice = mysqli_query($bid,$query_invoice) or die(mysql_error());
$row_invoice = mysqli_fetch_assoc($invoice);
$totalRows_invoice = mysqli_num_rows($invoice);


$query_cartQty = sprintf("SELECT Sum(sales_items.quantity_purchased) as cartqty FROM sales_items WHERE invoice_no =  %s", GetSQLValueString($col_invoice, "text"));
$cartQty = mysqli_query($bid,$query_cartQty) or die(mysqli_error($bid));
$row_cartQty = mysqli_fetch_assoc($cartQty);
$totalRows_cartQty = mysqli_num_rows($cartQty);
//
$query_totalInvoice = sprintf("SELECT
Sum(item_price.price * item_price.qty) as 'total'
FROM item_price WHERE company_id =  %s", GetSQLValueString($col_invoice, "text"));
$totalInvoice = mysqli_query($bid,$query_totalInvoice) or die(mysqli_error($bid));
$row_totalInvoice = mysqli_fetch_assoc($totalInvoice);
$totalRows_totalInvoice = mysqli_num_rows($totalInvoice);


if (!isset($_SESSION['SESS_INVOICE']) or ($_SESSION['SESS_INVOICE'] == '')){
$_SESSION['SESS_INVOICE'] = $_SESSION['companyName'];


}

?>



<div id="content-header" class="hidden-print sales_header_container">
    <h1 class="headigs"> <i class="icon fa fa-shopping-cart"></i>&nbsp;<?php echo $_SESSION['SESS_INVOICE'] ?><span
            id="ajax-loader"><img src="img/ajax-loader.gif" alt="" /></span>
    </h1>



</div>

<div class="clear"></div>
<!--Left small box-->
<div class="row">
    <div class="sale_register_leftbox col-md-9">
        <div class="row forms-area">
            <div class="col-md-8 no-padd">
                <div class="input-append">
                    <form action="salesAdd.php" method="post" accept-charset="utf-8" id="add_item_form"
                        class="form-inline" autocomplete="off"> <input name="item" type="text" class="input-xlarge"
                            id="item" placeholder="Enter item name or scan barcode" accesskey="i" value="" size="60" />
                        <input name="code" type="hidden" id="code"
                            value="<?php if (isset($error)){echo $error; }else {echo -1;} ?>" />
                    </form>
                </div>
            </div>

            <div class="col-md-4" style="padding: 20px">


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
                            <th class="sales_stock">Lot #</th>
                            <th class="sales_price">Dept</th>
                            <th class="sales_price">Qty/Year</th>
                            <th class="sales_price">Pack Size</th>
                            <th class="sales_price">Lot Description</th>
                            <th class="sales_price">Spec.</th>
                            <th class="sales_price">Qty </th>
                            <th class="sales_quality" style="width:500px">
                                Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Price

                            </th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="cart_contents" class="sa">
                        <?php if ($totalRows_invoice > 0) {	?> <?php do { ?>
                        <tr id="reg_item_top" bgcolor="#eeeeee">
                            <td><a href="salesAdd.php?deleid=<?php echo $row_invoice['item_id'] ?>"
                                    class="delete_item"><i class="fa fa-trash-o fa fa-2x text-error"></i> </a></td>
                            <td class="text text-success"><?php echo $row_invoice['item']; ?></td>
                            <td class="text text-info sales_item" id="reg_item_number">
                                <?php echo $row_invoice['item_id']; ?></td>
                            <td class="text text-warning sales_stock" id="reg_item_stock"><span
                                    class="text text-info sales_item"><?php echo $row_invoice['lot_id']; ?></span></td>
                            <td><span class="text text-info sales_item"><?php echo $row_invoice['dept']; ?></span></td>
                            <td><span class="text text-info sales_item"><?php echo $row_invoice['qty']; ?></span></td>
                            <td><span class="text text-info sales_item"><?php echo $row_invoice['packSize']; ?></span>
                            </td>
                            <td><span
                                    class="text text-info sales_item"><?php echo $row_invoice['lot_description']; ?></span>
                            </td>
                            <td><span
                                    class="text text-info sales_item"><?php echo $row_invoice['spec']; ?></span>
                            </td>
                            <td><?php echo $row_invoice['qty']; ?></td>

                            <td id="reg_item_qty">
                                <form action="salesAdd.php" method="post" accept-charset="utf-8" class="line_item_form"
                                    autocomplete="off"><input name="price" type="text" required="required"
                                        class="input-small" id="price" accesskey="q"
                                        value="<?php echo number_format(ceil($row_invoice['price']),2); ?>" size="100"
                                        maxlength="20" /> <input name="sales_item_id" type="hidden" id="sales_item_id"
                                        value="<?php echo $row_invoice['item_id']; ?>" /> </form>
                            </td>

                            <td><span
                                    class="text text-main"><?php $total = ceil($row_invoice['price'] * $row_invoice['qty']); echo number_format($total,2) ?></span>
                            </td>



                        </tr>
                        <tr bgcolor="#eeeeee">
                            <td>&nbsp;</td>
                            <td class="text text-success">Remarks</td>
                            <td colspan="3" class="text text-info sales_item" id="reg_item_number3"><span
                                    class="line_item_form">
                                    <form action="salesAdd.php" method="post" accept-charset="utf-8"
                                        class="line_item_form" autocomplete="off"><input name="remarks" type="text"
                                            class="input-small" id="remarks" accesskey="q"
                                            value="<?php echo $row_invoice['remarks']; ?>" size="50" /> <input
                                            name="item_id" type="hidden" id="item_id"
                                            value="<?php echo $row_invoice['item_id'] ?>" />
                                    </form>
                                </span></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td id="reg_item_qty3">&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php } while ($row_invoice = mysqli_fetch_assoc($invoice)); ?><?php } // Show if recordset not empty ?>

                        <?php if ($totalRows_invoice == 0) {	?>
                    <tbody id="cart_contents" class="sa">
                        <tr class="cart_content_area">
                            <td colspan="11">
                                <div class="text-center text-warning">
                                    <h3></h3>
                                </div>
                            </td>
                        </tr>
                    </tbody> <?php } ?>


                    </tbody>
                </table>
            </div>
            <ul class="list-inline pull-left">


            </ul>

        </div>




    </div>
    <!-- Right small box  -->

    <!-- Cancel and suspend buttons -->
    </li>
    <div class="row">
        <div class="col-md-6" style="padding: 20px">



            <div id='sale_details'>
                <table id="sales_items" class="table">
                    <tr class="warning">
                        <td class="left" align="right">Bid Security:</td>
                        <td class="right" align="right">
                            <strong><?php echo number_format(($row_totalInvoice['total']*0.03),2) ;//$totalRows_invoice ; ?></strong>
                        </td>
                    </tr>
                    <tr class="success">
                        <td align="right">
                            <h3 class="sales_totals">Total:</h3>
                        </td>
                        <td align="right">
                            <h3 class="currency_totals"><?php echo number_format(ceil($row_totalInvoice['total']),2); ?>
                            </h3>
                        </td>
                    </tr>
                </table>
            </div>
            <li class="list-group-item">
                <?php if ($totalRows_invoice > 0) {	?>
                <form action="print.php" method="post" accept-charset="utf-8" id="finish_sale_form" autocomplete="off">
                    <input type='button' class='btn btn-success btn-large
 btn-block' id='finish_sale_button' value='Print' />
        </div>
    </div>
    <input name="invoice" type="hidden" id="company_id" value="<?php  $_SESSION['company_id']?>">
</div>
</form>
<?php } ?>
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
// your inventory",'gritter-item-warning',false,false);
</script>

<script type="text/javascript" language="javascript">
var submitting = false;
$(document).ready(function() {
    //Here just in case the loader doesn't go away for some reason
    $("#ajax-loader").hide();

    if (last_focused_id && last_focused_id != 'item' && $('#' + last_focused_id).is('input[type=text]'))

    {
        $('#' + last_focused_id).focus();
        $('#' + last_focused_id).select();
    }

    $(document).focusin(function(event) {
        last_focused_id = $(event.target).attr('id');
    });

    $('#mode_form, #select_customer_form, #add_payment_form, .line_item_form, #discount_all_form').ajaxForm({
        target: "#register_container",
        beforeSubmit: salesBeforeSubmit
    });
    $('#add_item_form').ajaxForm({
        target: "#register_container",
        beforeSubmit: salesBeforeSubmit,
        success: itemScannedSuccess
    });
    $("#cart_contents input").change(function() {
        $(this.form).ajaxSubmit({
            target: "#register_container",
            beforeSubmit: salesBeforeSubmit
        });
    });

    $("#item").autocomplete({
        source: 'salesitemsearch.php',
        type: 'GET',
        delay: 10,
        autoFocus: false,
        minLength: 1,
        select: function(event, ui) {
            event.preventDefault();
            $("#item").val(ui.item.value);
            $('#add_item_form').ajaxSubmit({
                target: "#register_container",
                beforeSubmit: salesBeforeSubmit,
                success: itemScannedSuccess
            });
        }
    });

    $('#item,#customer').click(function() {
        $(this).attr('value', '');
    });

    $("#customer").autocomplete({
        source: 'salecustomersearch.php',
        delay: 10,
        autoFocus: false,
        minLength: 1,
        select: function(event, ui) {
            $("#customer").val(ui.item.value);
            $('#select_customer_form').ajaxSubmit({
                target: "#register_container",
                beforeSubmit: salesBeforeSubmit
            });
        }
    });




    $('#new-customer').click(function() {
        $('#select_customer_form').ajaxSubmit({
            target: "#register_container",
            beforeSubmit: salesBeforeSubmit
        });
    });



    $('#customer').blur(function() {
        $(this).attr('value', "Type customer name...");
    });

    $('#item').blur(function() {
        $(this).attr('value', "Enter item name or scan barcode");
    });

    //Datepicker change
    $('#change_sale_date_picker').datepicker().on('changeDate', function(ev) {
        $.post('http://#/pos/index.php/sales/set_change_sale_date', {
            change_sale_date: $('#change_sale_date').val()
        });
    });

    //Input change
    $("#change_sale_date").change(function() {
        $.post('http://#/pos/index.php/sales/set_change_sale_date', {
            change_sale_date: $('#change_sale_date').val()
        });
    });

    $('#change_sale_date_enable').change(function() {
        $.post('http://#/pos/index.php/sales/set_change_sale_date_enable', {
            change_sale_date_enable: $('#change_sale_date_enable').is(':checked') ? '1' : '0'
        });
    });

    $('#comment').change(function() {
        $.post('http://#/pos/index.php/sales/set_comment', {
            comment: $('#comment')
                .val()
        });
    });

    $('#show_comment_on_receipt').change(function() {
        $.post('http://#/pos/index.php/sales/set_comment_on_receipt', {
            show_comment_on_receipt: $('#show_comment_on_receipt').is(':checked') ? '1' : '0'
        });
    });

    $('#email_receipt').change(function() {
        $.post('http://#/pos/index.php/sales/set_email_receipt', {
            email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'
        });
    });

    $('#save_credit_card_info').change(function() {
        $.post('http://#/pos/index.php/sales/set_save_credit_card_info', {
            save_credit_card_info: $('#save_credit_card_info').is(':checked') ? '1' : '0'
        });
    });

    $('#change_sale_date_enable').is(':checked') ? $("#change_sale_input").show() : $("#change_sale_input")
        .hide();

    $('#change_sale_date_enable').click(function() {
        if ($(this).is(':checked')) {
            $("#change_sale_input").show();
        } else {
            $("#change_sale_input").hide();
        }
    });

    $('#use_saved_cc_info').change(function() {
        $.post('http://#/pos/index.php/sales/set_use_saved_cc_info', {
            use_saved_cc_info: $('#use_saved_cc_info').is(':checked') ? '1' : '0'
        });
    });

    $("#finish_sale_button").click(function() {
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


        if ($("#comment").val()) {
            $.post('#', {
                comment: $('#comment').val()
            }, function() {
                $('#finish_sale_form').submit();
            });
        } else {
            $('#finish_sale_form').submit();
        }

    });

    $("#suspend_sale_button").click(function() {
        if (confirm("Are you sure you want to suspend this sale?")) {
            $("#register_container").load('SalesAdd.php?suspend=suspend');
        }
    });

    $("#cancel_sale_button").click(function() {
        if (confirm("Are you sure you want to clear this sale? All items will cleared.")) {
            $('#cancel_sale_form').ajaxSubmit({
                target: "#register_container",
                beforeSubmit: salesBeforeSubmit
            });
        }
    });

    $("#add_payment_button").click(function() {
        $('#add_payment_form').ajaxSubmit({
            target: "#register_container",
            beforeSubmit: salesBeforeSubmit
        });
    });

    $("#add_customer_button").click(function() {
        $('#Add_customer_form').ajaxSubmit({
            target: "#register_container",
            beforeSubmit: salesBeforeSubmit
        });
    });

    $("#payment_types").change(checkPaymentTypeGiftcard).ready(checkPaymentTypeGiftcard);
    $('#mode').change(function() {
        if ($(this).val() == "store_account_payment") { // Hiding the category grid
            $('#show_hide_grid_wrapper, #category_item_selection_wrapper').fadeOut();
        } else { // otherwise, show the categories grid
            $('#show_hide_grid_wrapper, #show_grid').fadeIn();
            $('#hide_grid').fadeOut();
        }
        $('#mode_form').ajaxSubmit({
            target: "#register_container",
            beforeSubmit: salesBeforeSubmit
        });
    });

    $('.delete_item, .delete_payment, #delete_customer').click(function(event) {
        event.preventDefault();
        $("#register_container").load($(this).attr('href'));
    });

    $("#tier_id").change(function() {
        $.post('http://#/pos/index.php/sales/set_tier_id', {
            tier_id: $(this).val()
        }, function() {
            $("#register_container").load('http://#/pos/index.php/sales/reload');
        });
    });

    $("input[type=text]").not(".description").click(function() {
        $(this).select();
    });

    //alert(screen.width);
    if (screen.width <= 768) //set the colspan on page load
    {
        jQuery('td.edit_discription').attr('colspan', '2');
    }

    $(window).resize(function() {
        var wi = $(window).width();

        if (wi <= 768) {
            jQuery('td.edit_discription').attr('colspan', '2');
        } else {
            jQuery('td.edit_discription').attr('colspan', '4');
        }
    });

    $("#new-customer").click(function() {
        $("body").mask("Please wait...");
    });
});

function checkPaymentTypeGiftcard() {
    if ($("#payment_types").val() == "Gift Card") {
        $("#amount_tendered").val('');
        $("#amount_tendered").focus();
        giftcard_swipe_field($("#amount_tendered"));
    }
}

function salesBeforeSubmit(formData, jqForm, options) {
    if (submitting) {
        return false;
    }
    submitting = true;
    $("#ajax-loader").show();
    $("#add_payment_button").hide();
    $("#finish_sale_button").hide();
}

function itemScannedSuccess(responseText, statusText, xhr, $form) {

    if (($('#code').val()) == 1) {
        gritter("Error", 'Item not Found', 'gritter-item-error', false, true);

    } else if (($('#code').val()) == 2) {
        gritter("Error", 'Item Price already Added', 'gritter-item-error', false, true);
    } else {
        gritter("Success", "Item Addedd Successfully", 'gritter-item-success', false, true)
    }
    setTimeout(function() {
        $('#item').focus();
    }, 10);

    setTimeout(function() {

        $.gritter.removeAll();
        return false;

    }, 1000);

}
</script>
<?php
mysqli_free_result($itemSearch);

mysqli_free_result($invoice);
?>