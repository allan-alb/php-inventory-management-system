<?php    

require_once 'core.php';

$quotationId = $_POST['quotationId'];

$sql = "SELECT quotations.quotation_id, quotations.date, quotations.client_id, client.person_name AS client_name, client.person_registry_number AS client_registry_number,
      quotations.seller_id, seller.person_name AS seller_name, quotations.quotation_value, quotations.approved, quotations.deadline, quotations.discount, client.person_email,
      client.person_phone, client.person_postalcode, client.person_address_street, client.person_address_number, client.person_address_complem, client.person_address_district, 
      client.person_city, client.person_state FROM quotations
      INNER JOIN people AS client ON quotations.client_id = client.person_id
      INNER JOIN people AS seller ON quotations.seller_id = seller.person_id
      WHERE quotation_id = $quotationId";

$quotationResult = $connect->query($sql);
$quotationData = $quotationResult->fetch_array();

// date('Y-m-d', strtotime($_POST['quotationDate']));
$quotationDate          = date('d/m/Y', strtotime($quotationData[1]));
$clientName             = $quotationData[3];
$clientRegistryNumber   = $quotationData[4];
$sellerName             = $quotationData[6];
$quotationValue         = $quotationData[7];
$quotationDeadline      = date('d/m/Y', strtotime($quotationData[9]));
$discount               = $quotationData[10];

$clientEmail            = $quotationData[11];
$clientPhone            = $quotationData[12];
$clientPostalcode       = $quotationData[13];
$clientStreet           = $quotationData[14];
$clientNumber           = $quotationData[15];
$clientComplem          = $quotationData[16];
$clientDistrict         = $quotationData[17];
$clientCity             = $quotationData[18];
$clientState            = $quotationData[19];

$clientAddress = $clientStreet.", ".$clientNumber;
$clientAddress .= $clientComplem ? ", ".$clientComplem.", " : ", ";
$clientAddress .= $clientDistrict." | CEP: ".$clientPostalcode;


$quotationItemSql = "SELECT quotation_items.item_id, quotation_items.quantity, 
                     product.product_name AS item_name, product.product_price AS item_price FROM quotation_items
                     INNER JOIN product ON quotation_items.item_id = product.product_id 
                     WHERE quotation_items.quotation_id = $quotationId";
$quotationItemResult = $connect->query($quotationItemSql);

 $table = '<style>
            .star img {
               visibility: visible;
            }</style>
            <table align="center" cellpadding="5px" cellspacing="0" style="width: 100%;border:1px solid black;margin-bottom: 10px; min-width: 900px;">
                  <tbody>
                     <tr>
                        <td colspan="5" style="text-align:center;color: black;text-decoration: none; font-size: 25px; font-weight: bold;">Quotation</td>
                     </tr>
                     <tr>
                        <td rowspan="8" colspan="1" background-image="logo.jpg"><img src="logo.jpg" alt="logo" width="250px;"></td>
                     </tr>
                     <tr style="width: 300px;">
                        <td colspan="4" style=" text-align: right;color: black;font-weight: 600;text-decoration: none;font-size: 25px;">Your Company Name</td>
                     </tr>
                     <tr>
                        <td colspan="4" style=" text-align: right;">Telefone: (12) 3 4567-8900</td>
                     </tr>
                     <tr>
                        <td colspan="4" style=" text-align: right;">Email: mycompany@email.com</td>
                     </tr>
                     <tr>
                        <td colspan="4" style=" text-align: right;color: blue;text-decoration: none;"></td>
                     </tr>
                     <tr>
                        <td colspan="4" style=" text-align: right;">No. 01234567890000</td>
                     </tr>
                     <tr>
                        <td colspan="4" style=" text-align: right;">Your First Address, 000, District
                        | Postalcode: 000000</td>
                     </tr>
                     <tr>
                        <td colspan="4" style=" text-align: right;">Cityname, State</td>
                     </tr>
                     <tr>
                        <td colspan="2" style="padding: 0px;vertical-align: top;">
                           <table align="left" cellpadding="4px" cellspacing="0" style="border: thin solid black; width: 100%">
                              <tbody>
                                 <tr>
                                    <td colspan="3" style=" text-align: left;color: black;font-weight: 600;text-decoration: none;font-size: 22px; line-height: 30px;">&nbsp;'.$clientName.'</td>
                                 </tr>
                                 <tr>
                                    <td style="color: black; line-height: 20px;">&nbsp;'.$clientPhone.'</td>
                                 </tr>
                                 <tr>
                                    <td style="color: black; line-height: 20px;">&nbsp;'.$clientEmail.'</td>
                                 </tr>
                                 <tr>
                                 <td style="color: black; line-height: 5px;">&nbsp;</td>
                              </tr>
                                 <tr>
                                 <td style="color: black; line-height: 20px;">&nbsp;'.$clientAddress.'</td>
                              </tr>
                              <tr>
                                 <td style="color: black; line-height: 20px;">&nbsp;'.$clientCity.', '.$clientState.'</td>
                              </tr>
                              <tr>
                                 <td style="border-bottom-style: solid; border-bottom-width: thin; border-bottom-color: black; line-height: 10px;">&nbsp;</td>
                              </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="padding: 0px;vertical-align: top;" colspan="3">
                           <table align="left" cellpadding="5px" cellspacing="0" style="width: 100%">
                              <tbody>
                                 <tr>
                                 <td style="border-top: 1px solid black; height: 40px; color: black; "> </td>
                                 </tr>
                                 <tr>
                                 <td style="height: 50px; color: black; font-size: 18px; text-align: right;">Quotation #00'.$quotationId.'</td>
                                 </tr>
                                 <tr>
                                 <td style="height: 40px; text-align: right; color: black;">Date: '.$quotationDate.'&nbsp;</td>
                                 </tr>
                                 <tr>
                                 <td style="border-bottom-style: solid; border-bottom-width: thin; border-bottom-color: black; height: 55px; text-align: center; color: black;"> </td>
                              </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td style="width: 123px;text-align: center;background-color: #ccc;color: black; border-right: 1px solid white;border-left: 1px solid black;border-bottom: 1px solid black; border-top: 1px solid black; -webkit-print-color-adjust: exact;">
                        #
                        </td>
                        <td style="width: 50%;text-align: center;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-top-width: thin;border-right-width: thin;border-bottom-width: thin;border-top-color: black;border-right-color: white;border-bottom-color: black; background-color: #ccc;color: black; -webkit-print-color-adjust: exact;">
                        Product
                        </td>
                        <td style="width: 150px;text-align: center;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-top-width: thin;border-right-width: thin;border-bottom-width: thin;border-top-color: black;border-right-color: #fff;border-bottom-color: black;background-color: #ccc;color: black; -webkit-print-color-adjust: exact;">
                        Quantity
                        </td>
                        <td style="width: 150px;text-align: center;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-top-width: thin;border-right-width: thin;border-bottom-width: thin;border-top-color: black;border-right-color: #fff;border-bottom-color: black; background-color: #ccc;color: black; -webkit-print-color-adjust: exact;">
                        Price
                        </td>
                        <td style="width: 150px;text-align: center;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-top-width: thin;border-right-width: thin;border-bottom-width: thin;border-top-color: black;border-right-color: black;border-bottom-color: black; background-color: #ccc;color: black; -webkit-print-color-adjust: exact;">
                        Amount
                        </td>
                     </tr>';
                  $x = 1;
                  $productAmount = 0;
                  if ($discount) {
                     $subTotal = $quotationValue - $discount;
                     $total = $quotationValue;
                  } else {
                     $subTotal = $quotationValue;
                     $total = $quotationValue;
                  }
            while($row = $quotationItemResult->fetch_array()) {       
               $productAmount = $row[3] * $row[1];
               $table .= '<tr>
                     <td style="border-left: 1px solid black;border-right: 1px solid black;height: 27px;">'.$x.'</td>
                     <td style="border-left: 1px solid black;height: 27px;">'.$row[2].'</td>
                     <td style="border-left: 1px solid black;height: 27px;">'.$row[1].'</td>
                     <td style="border-left: 1px solid black;height: 27px;">'.$row[3].'</td>
                     <td style="border-left: 1px solid black;border-right: 1px solid black;height: 27px;">'.$productAmount.'</td>
                  </tr>
               ';
               $x++;
               $productAmount = 0;
            } // /while
                $table.= '
                  <tr>
                     <td colspan="5" style="border-top: 1px solid black;"> </td>
                  </tr>
                  <tr style="border-bottom: 1px solid black;">
                     <td colspan="3" style="height: 27px;"> </td>
                     <td style="width: 149px; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;background-color: #999;color: black;padding-left: 5px;-webkit-print-color-adjust: exact;">Sub-total</td>
                     <td style="width: 218px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-top-width: thin; border-right-width: thin; border-bottom-width: thin; border-top-color: black; border-right-color: black; border-bottom-color: black;">'.$subTotal.'</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="border-bottom: 1px solid black;padding: 5px;">Deadline: '.$quotationDeadline.'</td>
                     <td style="border-bottom: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; width: 199px; background-color: #999;color: black; padding-left: 5px;-webkit-print-color-adjust: exact;">Discount</td>
                     <td style="border-bottom: 1px solid black;width: 288px;border-right: 1px solid black;">'.$discount.'</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="width: 859px; padding: 5px;"> </td>
                  </tr>
                  <tr>
                     <td colspan="3" style="height: 10px;">';
                     if ($row[5]) {
                        $table .= 'Seller: '.$sellerName;
                     }
                     $table .= ' </td>
                     <td rowspan="2" style="border: 1px solid black; border-right: 1px solid black; width: 149px; background-color: #999;color: black; padding-left: 5px;-webkit-print-color-adjust: exact;">Total</td>
                     <td rowspan="2" style="width:218px;border: 1px solid black;border-right: 1px solid black;">'.$total.'
                  </td> 
                  </tr>
                  <tr>
                     <td colspan="3" rowspan="2" style="padding-left: 5px;">
                        * Further information
                     </td>
                  </tr>
               </tbody>
            </table>';
$connect->close();

echo $table;