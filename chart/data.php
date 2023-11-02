<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","pro_herb");

$sqlQuery = "SELECT orderID, pro_id, orderQty, total FROM order_detail ORDER BY orderID";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>