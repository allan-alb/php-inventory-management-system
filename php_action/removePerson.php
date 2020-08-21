<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$personId = $_POST['personId'];

if($personId) { 

 $sql = "UPDATE people SET active = 0 WHERE person_id = {$personId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Removida com sucesso";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Erro ao remover pessoa";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST