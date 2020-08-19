<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$productId						= $_POST['productId'];
	$productCode 					= $_POST['editProductCode']; 
	$productName 					= $_POST['editProductName']; 
	$productType 					= $_POST['editProductType'];
	$rawMaterial					= isset($_POST['editRawMaterial']) ? $_POST['editRawMaterial'] : "";
	$unitOfMeasure 				= $_POST['editUnitOfMeasure']; 
	$quantity 						= $_POST['editQuantity'];
	$quantityAlert 				= $_POST['editQuantityAlert'];
	$productCost 					= $_POST['editProductCost'];
	$productPrice 				= $_POST['editProductPrice'];
	$productDescription 	= $_POST['editProductDescription'];
	$tributaryOrigin 			= $_POST['editTributaryOrigin'];
	$tributaryNCM 				= $_POST['editTributaryNCM'];
	$tributaryCEST 				= $_POST['editTributaryCEST'];
	$tributaryGroup 			= $_POST['editTributaryGroup'];
	$tributaryBenefitCode = $_POST['editTributaryBenefitCode'];
  $productStatus 				= $_POST['editProductStatus'];

	// workaround to avoid errors in MySQL's STRICT mode
	$rawMaterial == "" ? $rawMaterial = "NULL" : $rawMaterial = "'".$rawMaterial."'";
	$tributaryOrigin == "" ? $tributaryOrigin = "NULL" : $tributaryOrigin = "'".$tributaryOrigin."'";
	$tributaryGroup == "" ? $tributaryGroup = "NULL" : $tributaryGroup = "'".$tributaryGroup."'";

	$sql = "UPDATE product SET product_code = '$productCode', product_name = '$productName', product_type = '$productType', raw_material = $rawMaterial, 
					unit_id = '$unitOfMeasure', quantity = '$quantity', quantity_alert = '$quantityAlert', product_cost = '$productCost', product_price = '$productPrice', 
					product_description = '$productDescription', tributary_origin = $tributaryOrigin, tributary_ncm = '$tributaryNCM', tributary_cest = '$tributaryCEST', 
					tributary_group = $tributaryGroup, tributary_benefit_code = '$tributaryBenefitCode', status = '$productStatus', active = 1 
					WHERE product_id = $productId ";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Atualizado com sucesso";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Erro na atualização do produto";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);
 
