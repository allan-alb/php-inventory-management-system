<?php 	

require_once 'core.php';

$personId = $_POST['personId'];

$sql = "SELECT person_id, person_type, person_name, person_role, person_registry_number, person_ie, person_email, person_phone,
        person_postalcode, person_address_street, person_address_number, person_address_complem, person_address_district, person_city,
        person_state, person_bank_name, person_bank_agency, person_bank_account, person_comments, active 
        FROM people WHERE person_id = $personId";

$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row, JSON_INVALID_UTF8_SUBSTITUTE);
