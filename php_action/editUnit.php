<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$unitName = $_POST['editUnitName'];
	$unitValue = $_POST['editUnitValue'];
  	$unitStatus = $_POST['editUnitStatus']; 
  	$unitId = $_POST['unitId'];

	$sql = "UPDATE unit_of_measure SET unit_name = '$unitName', unit_value = '$unitValue', unit_status = '$unitStatus' WHERE unit_id = '$unitId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Atualizado com sucesso!";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Erro ao adicionar membros";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST