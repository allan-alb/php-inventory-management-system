<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$personType						 = $_POST['personType'];
	$personName 					 = $_POST['personName'];
	$personRole 					 = $_POST['personRole'];
	$personRegistryNumber  = $_POST['personRegistryNumber'];
	$personIE 						 = $_POST['personIE'];
	$personEmail 					 = $_POST['personEmail'];
	$personPhone 					 = $_POST['personPhone'];
	$personPostalcode 		 = $_POST['personPostalcode'];
	$personAddressStreet 	 = $_POST['personAddressStreet'];
	$personAddressNumber	 = $_POST['personAddressNumber'];
	$personAddressComplem	 = $_POST['personAddressComplem'];
	$personAddressDistrict = $_POST['personAddressDistrict'];
	$personCity						 = $_POST['personCity'];
	$personState					 = $_POST['personState'];
	$personBankName				 = $_POST['personBankName'];
	$personBankAgency			 = $_POST['personBankAgency'];
	$personBankAccount		 = $_POST['personBankAccount'];
	$personComments				 = $_POST['personComments'];
	
	$sql = "INSERT INTO people (person_type, person_name, person_role, person_registry_number, person_ie, person_email, person_phone,
					person_postalcode, person_address_street, person_address_number, person_address_complem, person_address_district, person_city,
					person_state, person_bank_name, person_bank_agency, person_bank_account, person_comments, active) 
					VALUES ('$personType',	'$personName',	'$personRole',	'$personRegistryNumber',	'$personIE',	'$personEmail',	'$personPhone',	
					'$personPostalcode',	'$personAddressStreet',	'$personAddressNumber',	'$personAddressComplem',	'$personAddressDistrict',	'$personCity',	
					'$personState',	'$personBankName',	'$personBankAgency',	'$personBankAccount',	'$personComments',  1)";

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