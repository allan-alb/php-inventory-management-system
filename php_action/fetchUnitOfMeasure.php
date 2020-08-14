<?php 	

require_once 'core.php';

$sql = "SELECT unit_id, unit_name, unit_value, unit_status FROM unit_of_measure WHERE unit_status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeUnits = ""; 

 while($row = $result->fetch_array()) {
 	$unitId = $row[0];
 	// active 
 	if($row[3] == 1) {
 		// activate member
 		$activeUnits = "<label class='label label-success'>Disponível</label>";
 	} else {
 		// deactivate member
 		$activeUnits = "<label class='label label-danger'>Não Disponível</label>";
 	}

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Ação <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" data-target="#editUnitModel" onclick="editUnits('.$unitId.')"> <i class="glyphicon glyphicon-edit"></i> Editar</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeUnits('.$unitId.')"> <i class="glyphicon glyphicon-trash"></i> Remover</a></li>       
	  </ul>
	</div>';

 	$output['data'][] = array( 		
		$row[1],
		$row[2], 	
 		$activeUnits,
 		$button
 		); 	
 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);