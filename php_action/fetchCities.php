<?php 	

require_once 'core.php';

$stateValue = $_POST['stateValue'];

// get state id
$sql0 = "SELECT id FROM estado WHERE uf = '$stateValue'";
$result0 = $connect->query($sql0);

if($result0->num_rows > 0) { 
  $row0 = $result0->fetch_array();
 } // if num_rows

$stateId = $row0[0];

// get cities from state
$sql = "SELECT nome FROM cidade WHERE uf = $stateId";
$result = $connect->query($sql);

while($row = $result->fetch_array()) {
  $cities[$row[0]] = $row[0];
}

$connect->close();

echo json_encode($cities);