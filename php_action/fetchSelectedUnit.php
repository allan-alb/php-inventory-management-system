<?php 	

require_once 'core.php';

$unitId = $_POST['unitId'];

$sql = "SELECT unit_id, unit_name, unit_value, unit_status FROM unit_of_measure WHERE unit_id = $unitId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);