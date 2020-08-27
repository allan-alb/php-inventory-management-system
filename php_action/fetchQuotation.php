<?php 	

require_once 'core.php';

$sql = "SELECT quotations.quotation_id, quotations.date, quotations.client_id, client.person_name AS client_name, 
				quotations.seller_id, seller.person_name AS seller_name, quotations.quotation_value, quotations.approved FROM quotations
				INNER JOIN people AS client ON quotations.client_id = client.person_id
				INNER JOIN people AS seller ON quotations.seller_id = seller.person_id
				WHERE quotations.active = 1";
$result = $connect->query($sql);


$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $approved = "";
 $x = 1;

 while($row = $result->fetch_array()) {
 	$quotationId = $row[0];

 	$countQuotationItemSql = "SELECT count(*) FROM quotation_items WHERE quotation_id = $quotationId";
 	$itemCountResult = $connect->query($countQuotationItemSql);
 	$itemCountRow = $itemCountResult->fetch_row();


 	// approved 
 	if($row[7] == 1) { 		
 		$approved = "<label class='label label-success'>Sim</label>";
 	} else if($row[7] == 0) { 		
 		$approved = "<label class='label label-warning'>Não</label>";
 	} else { 		
 		$approved = "<label class='label label-error'>Valor inválido</label>";
 	} // /else

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a href="quotations.php?o=editQuo&i='.$quotationId.'" id="editQuotationModalBtn"> <i class="glyphicon glyphicon-edit"></i> Editar</a></li>

	    <li><a type="button" onclick="printQuotation('.$quotationId.')"> <i class="glyphicon glyphicon-print"></i> Imprimir </a></li>
	    
	    <li><a type="button" data-toggle="modal" data-target="#removeQuotationModal" id="removeQuotationModalBtn" onclick="removeQuotation('.$quotationId.')"> <i class="glyphicon glyphicon-trash"></i> Remover</a></li>       
	  </ul>
	</div>';		

 	$output['data'][] = array( 		
 		// id
 		$quotationId,
 		// quotation date
 		$row[1],
 		// client name
 		$row[3], 
 		// seller name
		$row[5],
		// number of items
		$itemCountRow,
		// value 
		$row[6],
		// approved status
		$approved,
 		// button
 		$button 		
 		); 	
 	$x++;
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);