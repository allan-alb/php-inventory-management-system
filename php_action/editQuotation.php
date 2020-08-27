<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	
	$quotationId = $_POST['quotationId'];

	$quotationDate 				= date('Y-m-d', strtotime($_POST['quotationDate']));	
  $client			 					= $_POST['clientName'];
  $seller				 				= isset($_POST['sellerName']) ? $_POST['sellerName'] : "";
  $quotationDeadline    = date('Y-m-d', strtotime($_POST['quotationDeadline']));
  $discount 						= isset($_POST['discount']) ? $_POST['discount'] : "";
	$quotationValue 			= $_POST['quotationValue'];
	$approved							= $_POST['quotationApproved'];
  
	$userid 							= $_SESSION['userId'];

	// workaround for inserting NULL values and avoid conflicts in STRICT mode
	$discount == "" ? $discount = "NULL" : $discount = "'".$discount."'";
	$seller == "" ? $seller = "NULL" : $seller = "'".$seller."'";

	$sql = "UPDATE quotations SET client_id = '$client', seller_id = $seller, date = '$quotationDate', deadline = '$quotationDeadline', discount = $discount, quotation_value = '$quotationValue', approved = '$approved', user_id = '$userid' WHERE quotation_id = {$quotationId}";
	$connect->query($sql);
	
	$readyToUpdateQuotationItem = true;

	// remove the quotation item data from order item table
	for($x = 0; $x < count($_POST['productName']); $x++) {			
		$removeQuotationSql = "DELETE FROM quotation_items WHERE quotation_id = {$quotationId}";
		$connect->query($removeQuotationSql);	
	} // /for quantity

	if($readyToUpdateQuotationItem) {
			// insert the quotation item data 
		for($x = 0; $x < count($_POST['productName']); $x++) {
			$quotationItemSql = "INSERT INTO quotation_items (quotation_id, item_id, quantity) 
													VALUES ({$quotationId}, '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."')";

			$connect->query($quotationItemSql);
		} // /for quantity
	}

	

	$valid['success'] = true;
	$valid['messages'] = "Atualizado com sucesso";
	
	$connect->close();

	echo json_encode($valid);
} 