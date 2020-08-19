<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

  $productCode					= $_POST['productCode'];
  $productName 					= $_POST['productName'];
  // $productImage 			= $_POST['productImage'];
  $productType					= $_POST['productType'];
  $rawMaterial					= isset($_POST['rawMaterial']) ? $_POST['rawMaterial'] : "";
  $unitOfMeasure 				= $_POST['unitOfMeasure'];
  $quantity 						= $_POST['quantity'];		
  $quantityAlert				= $_POST['quantityAlert'];
  $productCost					= $_POST['productCost'];
  $productPrice 				= $_POST['productPrice'];
  $productDescription		= $_POST['productDescription'];
  $tributaryOrigin			= $_POST['tributaryOrigin'];
  $tributaryNCM					= $_POST['tributaryNCM'];
  $tributaryCEST				= $_POST['tributaryCEST'];
  $tributaryGroup				= $_POST['tributaryGroup'];
  $tributaryBenefitCode	= $_POST['tributaryBenefitCode'];
	$productStatus 				= $_POST['productStatus'];
	
	// workaround to avoid errors in MySQL's STRICT mode
	$rawMaterial == "" ? $rawMaterial = "NULL" : $rawMaterial = "'".$rawMaterial."'";
	$tributaryOrigin == "" ? $tributaryOrigin = "NULL" : $tributaryOrigin = "'".$tributaryOrigin."'";
	$tributaryGroup == "" ? $tributaryGroup = "NULL" : $tributaryGroup = "'".$tributaryGroup."'";

	$type = explode('.', $_FILES['productImage']['name']);
	$type = $type[count($type)-1];		
	$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if(is_uploaded_file($_FILES['productImage']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {
				
				$sql = "INSERT INTO product (product_code, product_name, product_image, product_type, raw_material, unit_id, 
				 quantity, quantity_alert, product_cost, product_price, product_description, tributary_origin, tributary_ncm,
				 tributary_cest, tributary_group, tributary_benefit_code, status, active) 
				VALUES ('$productCode', '$productName', '$url', '$productType', $rawMaterial, '$unitOfMeasure', 
				'$quantity', '$quantityAlert', '$productCost', '$productPrice', '$productDescription', $tributaryOrigin, '$tributaryNCM', 
				'$tributaryCEST', $tributaryGroup, '$tributaryBenefitCode', '$productStatus', 1)";

				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Adicionado com sucesso";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Erro ao adicionar membros";
				}

			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST