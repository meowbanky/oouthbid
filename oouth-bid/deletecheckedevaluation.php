<?php 
require_once('Connections/bid.php'); 
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
    if (isset($_GET['id'])){
$queryDelete = sprintf("delete from tbl_evaluation where evaluation_id = %s",GetSQLValueString($_GET['id'],"int"));
$delete = mysqli_query($bid,$queryDelete) or die(mysqli_error($bid));
        if($delete){echo 'ok';}
}

}



?>