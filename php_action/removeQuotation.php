<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$quotationId = $_POST['quotationId'];

if($quotationId) { 

 $sql = "UPDATE quotations SET active = 0 WHERE quotation_id = {$quotationId}";

 //$quotationItem = "UPDATE quotation_item SET quotation_item_status = 2 WHERE  quotation_id = {$quotationId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Removido com sucesso";
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Erro ao remover orçamento";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} 