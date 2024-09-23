<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'Oluwaseyi';
$dbName = 'oouth_bid';
//connect with the database
$return_arr = array();
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
$searchTerm = $_GET['term'];


//get matched data from skills table
$query = $db->query("SELECT items.item_id, IFNULL(items.spec,'') as spec,items.item, items.packSize, items.qty, tbl_dept.dept, tbl_lot.lot_description FROM items LEFT JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id LEFT JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id WHERE items.item like '%".$searchTerm."%'");

while ($row = $query->fetch_assoc()) {
    //$data['id'] = $row['product_id'];
	  $data['label'] = $row['item']."  Pack Size (".$row['packSize'].") Yearly Qty ( ".$row['qty']. ") Dept (".$row['dept'].") Lot Description (".$row['lot_description'].") Specification (".$row['spec'].")";
	  $data['value'] = $row['item_id'];
	  array_push($return_arr,$data);
}
//return json data
echo json_encode($return_arr);
?>

