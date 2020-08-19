<?php 	



require_once 'core.php';

$sql = "SELECT product.product_id, product.product_code, product.product_name, product.product_image, product.product_type,
		product.raw_material, raw_product.product_name, product.unit_id, unit.unit_name, product.quantity, product.quantity_alert, 
		product.product_cost, product.product_price, product.product_description, product.status FROM product 
		INNER JOIN unit_of_measure AS unit ON product.unit_id = unit.unit_id 
		LEFT JOIN product AS raw_product ON product.raw_material = raw_product.product_id
		WHERE product.active = 1";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $status = ""; 
 $type = "";

 while($row = $result->fetch_array()) {
	$productId = $row[0];
	
	// type
	switch ($row[4]) {
		case '1':
			$type = "<label class='label label-default'>Matéria prima</label>";
			break;
		case '2':
			$type = "<label class='label label-primary'>Produto acabado</label>";
			break;
		case '3':
			$type = "<label class='label label-info'>Embalagem</label>";
			break;
		default:
			$type = "<label class='label label-danger'>Tipo inválido</label>";
			break;
	}

 	// status 
 	if($row[14] == 1) {
 		// activate member
 		$status = "<label class='label label-success'>Disponível</label>";
 	} else {
 		// deactivate member
 		$status = "<label class='label label-danger'>Não Disponível</label>";
 	} // /else

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')"> <i class="glyphicon glyphicon-edit"></i> Editar</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct('.$productId.')"> <i class="glyphicon glyphicon-trash"></i> Remover</a></li>       
	  </ul>
	</div>';

	$unit = $row[8];
	$raw = $row[6];
	$quantity = str_replace('.', ',', substr($row[9], 0, -1));
	$quantityAlert = $row[10] ? str_replace('.', ',', substr($row[10], 0, -1)) : '';
	$price = str_replace('.', ',', substr($row[12], 0, -2));

	$imageUrl = substr($row[3], 3);
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

 	$output['data'][] = array( 		
 		// image
		$productImage,
		// product code
		$row[1], 
 		// product name
		$row[2], 
		// product type
		$type,
		// raw material
		$raw,
		// unit
		$unit,
		// quantity
		$quantity, // $row[9],
		// quantity_alert
		$quantityAlert, // $row[10], 
 		// price
 		$price, // $row[12],
 		// status
 		$status,
 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);