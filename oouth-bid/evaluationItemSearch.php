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
$query = $db->query("SELECT items.item_id, items.item,IFNULL(items.spec,'') AS spec, items.packSize, items.qty, tbl_dept.dept, tbl_lot.lot_description 
FROM items LEFT JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id 
LEFT JOIN tbl_lot ON tbl_lot.lot_id = items.lot_id WHERE items.item_id like '%".$searchTerm."%' OR items.item like '%".$searchTerm."%' OR dept like '%".$searchTerm."%' OR lot_description like '%".$searchTerm."%' ORDER BY item_id LIMIT 50");
while ($row = $query->fetch_assoc()) {
    //$data['id'] = $row['product_id'];
	  $data['label'] = "Item No:- ". $row['item_id']."  ". $row['item']."  Pack Size (".$row['packSize'].") Yearly Qty ( ".$row['qty']. ") Dept (".$row['dept'].") Lot Description (".$row['lot_description'].") Specification (".$row['spec'].")";
	  $data['value'] = $row['item_id'];
	  array_push($return_arr,$data);
}
//return json data
echo json_encode($return_arr);
?>

