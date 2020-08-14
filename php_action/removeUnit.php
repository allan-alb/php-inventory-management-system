<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$unitId = $_POST['unitId'];

if($unitId) { 

 $sql = "UPDATE unit_of_measure SET unit_status = 2 WHERE unit_id = {$unitId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Removido com sucesso";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Erro ao remover a unidade";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST