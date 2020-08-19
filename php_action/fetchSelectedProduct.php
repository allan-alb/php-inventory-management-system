<?php

header('Content-Type: application/json; charset=UTF-8');

require_once 'core.php';

$productId = $_POST['productId'];

$sql = "SELECT product_id, product_code, product_name, product_image, product_type, raw_material, unit_id, quantity, quantity_alert,
        product_cost, product_price, product_description, tributary_origin, tributary_ncm, tributary_cest, tributary_group, tributary_benefit_code,
        status, active FROM product WHERE product_id = $productId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row, JSON_INVALID_UTF8_SUBSTITUTE);