<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array(), 'quotation_id' => '');
// print_r($valid);
if($_POST) {	

	$quotationDate				= date('Y-m-d', strtotime($_POST['quotationDate']));	
  $client			 					= $_POST['clientName'];
  $seller				 				= isset($_POST['sellerName']) ? $_POST['sellerName'] : "";
  $quotationDeadline    = date('Y-m-d', strtotime($_POST['quotationDeadline']));
  $discount 						= isset($_POST['discount']) ? $_POST['discount'] : "";
  $quotationValue 			= $_POST['quotationValue'];
  
	$userid 							= $_SESSION['userId'];
	
	// workaround for inserting NULL values without conflicts in STRICT mode
	$discount == "" ? $discount = "NULL" : $discount = "'".$discount."'";
	$seller == "" ? $seller = "NULL" : $seller = "'".$seller."'";

	$sql = "INSERT INTO quotations (client_id, seller_id, date, deadline, discount, quotation_value, approved, active, user_id) 
				VALUES ('$client', $seller, '$quotationDate', '$quotationDeadline', $discount, '$quotationValue', 0, 1, $userid)";
	
	$quotation_id;
	$quotationStatus = false;
	if($connect->query($sql) === true) {
		$quotation_id = $connect->insert_id;
		$valid['quotation_id'] = $quotation_id;	

		$quotationStatus = true;
	}

	$quotationItemStatus = false;

	for($x = 0; $x < count($_POST['productName']); $x++) {	

		$quotationItemSql = "INSERT INTO quotation_items (quotation_id, item_id, quantity) VALUES ('$quotation_id', '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."')";
		$connect->query($quotationItemSql);
		if($x == count($_POST['productName'])) {
			$orderItemStatus = true;
		}
		/*
		$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = ".$_POST['productName'][$x]."";
		$updateProductQuantityData = $connect->query($updateProductQuantitySql);
		
		while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
			$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];							
				// update product table
				$updateProductTable = "UPDATE product SET quantity = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]."";
				$connect->query($updateProductTable);

				// add into order_item
				$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
				VALUES ('$order_id', '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

				$connect->query($orderItemSql);		

				if($x == count($_POST['productName'])) {
					$orderItemStatus = true;
				}		
		} // while	
		*/
	} // /for quantity

	$valid['success'] = true;
	$valid['messages'] = "Adicionado com sucesso";		
	
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);