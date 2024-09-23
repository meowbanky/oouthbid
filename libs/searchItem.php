<?php

require __DIR__ . '/../vendor/autoload.php' ;
require_once __DIR__ . '/../config/config.php' ;

use App\Controllers;
use App\App;

$App = new App();

$return_arr = array();

// Get search term
$searchTerm = isset($_GET['term']) ? '%' . $_GET['term'] . '%':'';
$company_id = $_SESSION['company_id'];

// Prepare the query with placeholders
$query = $App->link->prepare("SELECT items.item_id, IFNULL(items.spec,'') as spec,items.item, 
       items.packSize, items.qty, tbl_dept.dept FROM
	items
	INNER JOIN
	subscription
	ON 
		items.dept_id = subscription.lot_id INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
                                                                         WHERE  items.item_id NOT IN (SELECT item_id FROM item_price WHERE company_id = :company_id) AND items.item like :searchTerm AND company_id = :company_id");

// Bind the parameter
$query->bindParam(':company_id', $company_id, PDO::PARAM_STR);
$query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$query->bindParam(':company_id', $company_id, PDO::PARAM_STR);

try {
    // Execute the query
    $query->execute();

// Fetch the results
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $data['label'] = $row['item']."  Pack Size (".$row['packSize'].")  Dept (".$row['dept'].") Specification (".$row['spec'].")";
        $data['value'] = $row['item_id'];
        array_push($return_arr, $data);
    }

// Return JSON data
    echo json_encode($return_arr);
}catch (PDOException $e) {
    echo json_encode(array('error'=> $e->getMessage()));
}

?>
