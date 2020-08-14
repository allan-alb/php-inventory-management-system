<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$unitName = $_POST['unitName'];
	$unitValue = $_POST['unitValue'];
  	$unitStatus = $_POST['unitStatus']; 

	$sql = "INSERT INTO unit_of_measure (unit_name, unit_value, unit_status) VALUES ('$unitName', '$unitValue','$unitStatus')";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Adicionado com sucesso";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Erro ao adicionar membros";
	}
	 

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST