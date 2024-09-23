<?php require_once('Connections/bid.php'); 
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

$row_itemSearch['dept_id'] = 1;
$row_itemSearch['company_id'] =1;

mysql_select_db($database_bid, $bid);
            $query_companySpecific = sprintf("SELECT item_price.price, item_price.company_id, tbl_company.company_name, items.item, items.packSize, items.qty, tbl_evaluation.percentage, tbl_lot.lot_description, tbl_dept.dept,
item_price.item_id,items.packSize,items.qty as require_year,
items.qty*(tbl_evaluation.percentage/100) as qtyAwarded FROM tbl_evaluation INNER JOIN item_price ON item_price.item_price_id = tbl_evaluation.item_price_id INNER JOIN tbl_company ON tbl_company.company_id = item_price.company_id
INNER JOIN items ON items.item_id = item_price.item_id INNER JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
          WHERE items.dept_id = 1 and item_price.company_id = 1 ORDER BY items.item_id", GetSQLValueString($row_itemSearch['dept_id'], "text"),GetSQLValueString($row_itemSearch['company_id'], "text"));
            $companySpecific = mysql_query($query_companySpecific, $bid) or die(mysql_error());
            $row_companySpecific = mysql_fetch_assoc($companySpecific);
            $totalRows_companySpecific = mysql_num_rows($companySpecific);




  do { 
     
     echo $row_companySpecific['company_name'];
     
     } while ($row_companySpecific = mysql_fetch_assoc($companySpecific))
                   

?>


