<?php 	

require_once 'core.php';

$sql = "SELECT person_id, person_type, person_name, person_role, person_registry_number, person_ie, person_email, person_phone,
				person_postalcode, person_address_street, person_address_number, person_address_complem, person_address_district, 
				person_city, person_state, person_bank_name, person_bank_agency, person_bank_account, person_comments, active 
				FROM people WHERE active = 1";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $role = "";

 while($row = $result->fetch_array()) {
	$personId = $row[0];
	
	// role
	switch ($row[3]) {
		case '1':
			$role = "<label class='label label-default' style='font-size: 11px'>Fornecedor</label>";
			break;
		case '2':
			$role = "<label class='label label-primary' style='font-size: 11px'>Cliente</label>";
			break;
		case '3':
			$role = "<label class='label label-info' style='font-size: 11px'>Vendedor</label>";
			break;
		case '4':
			$role = "<label class='label label-warning' style='font-size: 11px'>Transportador</label>";
			break;
		default:
			$role = "<label class='label label-danger' style='font-size: 11px'>Tipo inválido</label>";
			break;
	}

 	// status 
 	if($row[1] == '1') {
 		$type = "<span class='label label-default' style='font-size: 11px'>Física</span>";
 	} else if ($row[1] == '2') {
 		$type = "<span class='label label-default' style='background: #333; font-size: 11px'>Jurídica</span>";
 	} // else if

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editPersonModalBtn" data-target="#editPersonModal" onclick="editPerson('.$personId.')"> <i class="glyphicon glyphicon-edit"></i> Editar</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removePersonModal" id="removePersonModalBtn" onclick="removePerson('.$personId.')"> <i class="glyphicon glyphicon-trash"></i> Remover</a></li>       
	  </ul>
	</div>';

 	$output['data'][] = array( 		
		// person name
		$row[2],
		// person type
		$type,
		// person role
		$role,
		// person email
		$row[6],
		//person phone
		$row[7],
 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);