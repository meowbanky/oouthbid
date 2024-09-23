<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'oluwaseyi';
$dbName = 'q4dx_world';
//connect with the database
$return_arr = array();
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
$searchTerm = $_GET['term'];
//get matched data from skills table
$query = $db->query("SELECT
items.`name`,
items.item_id
FROM
items
WHERE (`name` <> '' and deleted <> 1) and (`name` like '%".$searchTerm."%' or items.isbn like '%".$searchTerm."%' ) ORDER BY `name` ASC");
while ($row = $query->fetch_assoc()) {
    $data['id'] = $row['item_id'];
	  $data['label'] = $row['name'];
	  $data['value'] = $row['item_id'];
	  array_push($return_arr,$data);
}
//return json data
echo json_encode($return_arr);
?>

