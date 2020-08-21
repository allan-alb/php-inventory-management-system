<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$personType						 = $_POST['editPersonType'];
	$personName 					 = $_POST['editPersonName'];
	$personRole 					 = $_POST['editPersonRole'];
	$personRegistryNumber  = $_POST['editPersonRegistryNumber'];
	$personIE 						 = $_POST['editPersonIE'];
	$personEmail 					 = $_POST['editPersonEmail'];
	$personPhone 					 = $_POST['editPersonPhone'];
	$personPostalcode 		 = $_POST['editPersonPostalcode'];
	$personAddressStreet 	 = $_POST['editPersonAddressStreet'];
	$personAddressNumber	 = $_POST['editPersonAddressNumber'];
	$personAddressComplem	 = $_POST['editPersonAddressComplem'];
	$personAddressDistrict = $_POST['editPersonAddressDistrict'];
	$personCity						 = $_POST['editPersonCity'];
	$personState					 = $_POST['editPersonState'];
	$personBankName				 = $_POST['editPersonBankName'];
	$personBankAgency			 = $_POST['editPersonBankAgency'];
	$personBankAccount		 = $_POST['editPersonBankAccount'];
	$personComments				 = $_POST['editPersonComments'];
	
  $personId = $_POST['personId'];

	$sql = "UPDATE people SET person_type = '$personType', person_name = '$personName', person_role = '$personRole', 
					person_registry_number = '$personRegistryNumber', person_ie = '$personIE', person_email = '$personEmail', 
					person_phone = '$personPhone', person_postalcode = '$personPostalcode', person_address_street = '$personAddressStreet', 
					person_address_number = '$personAddressNumber', person_address_complem = '$personAddressComplem', 
					person_address_district = '$personAddressDistrict', person_city = '$personCity',	person_state = '$personState', 
					person_bank_name = '$personBankName', person_bank_agency = '$personBankAgency', person_bank_account = '$personBankAccount', 
					person_comments = '$personComments', active = 1
					WHERE person_id = '$personId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Atualizado com sucesso";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Erro ao adicionar membros";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST