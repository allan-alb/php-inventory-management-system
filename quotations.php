<?php 
require_once 'php_action/db_connect.php'; 
require_once 'includes/header.php'; 

if($_GET['o'] == 'add') { 
// add quotation
	echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['o'] == 'manquo') { 
	echo "<div class='div-request div-hide'>manquo</div>";
} else if($_GET['o'] == 'editQuo') { 
	echo "<div class='div-request div-hide'>editQuo</div>";
} // /else manage quotation


?>

<ol class="breadcrumb">
  <li><a href="dashboard.php">Home</a></li>
  <li>Orçamento</li>
  <li class="active">
  	<?php if($_GET['o'] == 'add') { ?>
  		Novo Orçamento
		<?php } else if($_GET['o'] == 'manquo') { ?>
			Gerenciar Orçamentos
		<?php } // /else manage quotation ?>
  </li>
</ol>


<h4>
	<i class='glyphicon glyphicon-circle-arrow-right'></i>
	<?php if($_GET['o'] == 'add') {
		echo "Novo Orçamento";
	} else if($_GET['o'] == 'manquo') { 
		echo "Gerenciar Orçamentos";
	} else if($_GET['o'] == 'editQuo') { 
		echo "Editar Orçamento";
	}
	?>	
</h4>



<div class="panel panel-default">
	<div class="panel-heading">

		<?php if($_GET['o'] == 'add') { ?>
  		<i class="glyphicon glyphicon-plus-sign"></i>	Novo Orçamento
		<?php } else if($_GET['o'] == 'manquo') { ?>
			<i class="glyphicon glyphicon-edit"></i> Gerenciar Orçamentos
		<?php } else if($_GET['o'] == 'editQuo') { ?>
			<i class="glyphicon glyphicon-edit"></i> Editar Orçamento
		<?php } ?>

	</div> <!--/panel-->	
	<div class="panel-body">
			
		<?php if($_GET['o'] == 'add') { 
			// add quotation
			?>			

			<div class="success-messages"></div> <!--/success-messages-->

			<form class="form-horizontal" method="POST" action="php_action/createQuotation.php" id="createQuotationForm">
			
				<div class="col-md-12">
					<div class="col-md-6" style="display: flex; justify-content:flex-start;">
						<div class="form-group">
							<label for="quotationDate" class="col-md-5 control-label">Data do Orçamento</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="quotationDate" name="quotationDate" autocomplete="off" />
							</div>
						</div> <!--/form-group-->
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-md-7">
						<div class="form-group">
							<label for="clientName">Nome do Cliente</label>
							<select class="form-control" name="clientName" id="clientName" >
								<option value="">~~SELECIONE~~</option>
								<?php
									$clientSql = "SELECT person_id, person_name, person_registry_number FROM people WHERE active = 1 AND person_role = 2 ORDER BY person_name ASC";
									$clientData = $connect->query($clientSql);

									while($clientRow = $clientData->fetch_array()) {									 		
										echo "<option value='".$clientRow['person_id']."'>".$clientRow['person_name']."</option>";
									} // /while 
								?>
							</select>
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group" style="margin-left: 10px;">
							<label for="clientRegistryNumber">CPF/CNPJ</label>
							<input type="text" class="form-control" id="clientRegistryNumber" name="clientRegistryNumber" disabled="true" />
						</div> <!--/form-group-->
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-md-7">
						<div class="form-group">
							<label for="sellerName">Nome do Vendedor</label>
							<select class="form-control" name="sellerName" id="sellerName" >
								<option value="">~~SELECIONE~~</option>
								<?php
									$sellerSql = "SELECT person_id, person_name, person_registry_number FROM people WHERE active = 1 AND person_role = 3 ORDER BY person_name ASC";
									$sellerData = $connect->query($sellerSql);

									while($sellerRow = $sellerData->fetch_array()) {									 		
										echo "<option value='".$sellerRow['person_id']."'>".$sellerRow['person_name']."</option>";
									} // /while 
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-md-6" style="display: flex; justify-content:flex-start;">
						<div class="form-group">
							<label for="quotationDeadline" class="col-md-4 control-label">Prazo</label>
							<div class="col-md-7">
								<input type="text" class="form-control" id="quotationDeadline" name="quotationDeadline" autocomplete="off" />
							</div>
						</div> <!--/form-group-->
					</div>
				</div>
					
			  <table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
							<th style="width:40%;">Produto</th>
							<th style="width:15%;">Unidade</th>
							<th style="width:15%;">Preço (R$)</th>
			  			<th style="width:10%;">Quantidade disponível</th>
			  			<th style="width:10%;">Quantidade</th>
			  			<th style="width:25%;">Total</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php
			  		$arrayNumber = 0;
			  		for($x = 1; $x < 2; $x++) { ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0 ORDER BY product_name ASC";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."'>".$row['product_name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
			  					</div>
								</td>
								<td style="padding-left:30px; padding-top: 10px;">
			  					<div class="form-group">
									<p id="unitName<?php echo $x; ?>"></p>
			  					</div>
			  				</td>
			  				<td style="padding-left:10px;">			  					
			  					<input type="text" name="productPrice[]" id="productPrice<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />					
			  					<input type="hidden" name="priceValue[]" id="priceValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
			  				</td>
								<td style="padding-left:20px; padding-top: 10px; display: flex; justify-content: center; align-items: center;">
			  					<div class="form-group">
									<p id="available_quantity<?php echo $x; ?>"></p>
			  					</div>
			  				</td>
			  				<td style="padding-left:10px;">
			  					<div class="form-group">
									<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" 
										onchange="getTotal(<?php echo $x ?>)"	autocomplete="off" class="form-control" min="1" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
			  		} // /for
			  		?>
			  	</tbody>			  	
			  </table>

				<div class="col-md-6">
					<button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Carregando..."> <i class="glyphicon glyphicon-plus-sign"></i> Adicionar Linha </button>
				</div>
			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Sub Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Descontos</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" />
				    </div>
					</div> <!--/form-group-->	
					<div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true"/>
				      <input type="hidden" class="form-control" id="quotationValue" name="quotationValue" />
				    </div>
				  </div> <!--/form-group-->		  
			  </div> <!--/col-md-6-->

			  <div class="form-group submitButtonFooter">
			    <div class="col-md-offset-8 col-sm-10">
			      <button type="submit" id="createQuotationBtn" data-loading-text="Carregando..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Salvar Alterações</button>

			      <button type="reset" class="btn btn-default" onclick="resetQuotationForm()"><i class="glyphicon glyphicon-erase"></i> Limpar</button>
			    </div>
			  </div>
			</form>
		<?php } else if($_GET['o'] == 'manquo') { 
			// manage quotation
			?>

			<div id="success-messages"></div>
			
			<table class="table" id="manageQuotationTable" style="text-align: center;">
				<thead>
					<tr>
						<th>#</th>
						<th>Data do Orçamento</th>
						<th>Nome do Cliente</th>
						<th>Nome do Vendedor</th>
						<th>Num. Itens</th>
						<th>Valor</th>
						<th>Aprovado</th>
						<th>Opções</th>
					</tr>
				</thead>
			</table>

		<?php 
		// /else manage quotation
		} else if($_GET['o'] == 'editQuo') {
			// get quotation
			?>
			
			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/editQuotation.php" id="editQuotationForm">

  			<?php $quotationId = $_GET['i'];

  			$sql = "SELECT quotations.quotation_id, quotations.date, quotations.client_id, client.person_name, client.person_registry_number, quotations.seller_id, seller.person_name, quotations.deadline, quotations.discount, quotations.quotation_value, quotations.approved FROM quotations
								INNER JOIN people AS client ON quotations.client_id = client.person_id
								INNER JOIN people AS seller ON quotations.seller_id = seller.person_id
								WHERE quotations.quotation_id = {$quotationId}";

				$result = $connect->query($sql);
				$data = $result->fetch_row();
  			?>

				<div class="col-md-12">
					<div class="col-md-6" style="display: flex; justify-content:flex-start;">
						<div class="form-group">
							<label for="quotationDate" class="col-md-5 control-label">Data do Orçamento</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="quotationDate" name="quotationDate" autocomplete="off" value="<?php echo $data[1] ?>" />
							</div>
						</div> <!--/form-group-->
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-md-7">
						<div class="form-group">
							<label for="clientName">Nome do Cliente</label>
							<select class="form-control" name="clientName" id="clientName" >
								<option value="">~~SELECIONE~~</option>
								<?php
									$clientSql = "SELECT person_id, person_name, person_registry_number FROM people WHERE active = 1 AND person_role = 2 ORDER BY person_name ASC";
									$clientData = $connect->query($clientSql);

									while($clientRow = $clientData->fetch_array()) {
										$selected = "";
										if ($clientRow['person_id'] == $data[2]) {
											$selected = "selected";
										}
										echo "<option value='".$clientRow['person_id']."' ".$selected.">".$clientRow['person_name']."</option>";
										$selected = "";
									} // /while 
								?>
							</select>
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group" style="margin-left: 10px;">
							<label for="clientRegistryNumber">CPF/CNPJ</label>
							<input type="text" class="form-control" id="clientRegistryNumber" name="clientRegistryNumber" disabled="true" />
						</div> <!--/form-group-->
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-md-7">
						<div class="form-group">
							<label for="sellerName">Nome do Vendedor</label>
							<select class="form-control" name="sellerName" id="sellerName" >
								<option value="">~~SELECIONE~~</option>
								<?php
									$sellerSql = "SELECT person_id, person_name, person_registry_number FROM people WHERE active = 1 AND person_role = 3 ORDER BY person_name ASC";
									$sellerData = $connect->query($sellerSql);

									while($sellerRow = $sellerData->fetch_array()) {
										$selectedSeller = "";
										if ($sellerRow['person_id'] == $data[5]) {
											$selectedSeller = "selected";
										}								 		
										echo "<option value='".$sellerRow['person_id']."' ".$selectedSeller.">".$sellerRow['person_name']."</option>";
									} // /while 
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="col-md-6" style="display: flex; justify-content:flex-start;">
						<div class="form-group">
							<label for="quotationDeadline" class="col-md-4 control-label">Prazo</label>
							<div class="col-md-7">
								<input type="text" class="form-control" id="quotationDeadline" name="quotationDeadline" autocomplete="off" value="<?php echo $data[7] ?>" />
							</div>
						</div> <!--/form-group-->
					</div>
				</div>

			  <table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
							<th style="width:40%;">Produto</th>
							<th style="width:15%;">Unidade</th>
							<th style="width:15%;">Preço (R$)</th>
			  			<th style="width:10%;">Quantidade disponível</th>
			  			<th style="width:10%;">Quantidade</th>
			  			<th style="width:25%;">Total</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php

			  		$quotationItemSql = "SELECT quotation_items.item_id, quotation_items.quantity, 
																product.product_name AS item_name, product.product_price AS item_price, product.unit_id AS item_unit_id
																FROM quotation_items
																INNER JOIN product ON quotation_items.item_id = product.product_id 
																WHERE quotation_items.quotation_id = {$quotationId}";
						$quotationItemResult = $connect->query($quotationItemSql);	
						
						$arrayNumber = 0;
						$subTotal = 0;
			  		
			  		$x = 1;
			  		while($quotationItemData = $quotationItemResult->fetch_array()) { 
			  			// print_r($orderItemData); ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  						<option value="">~~SELECIONE~~</option>
			  						<?php
			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0 ORDER BY product_name ASC";
			  							$productData = $connect->query($productSql);

			  							while($productRow = $productData->fetch_array()) {									 		
			  								$selected = "";
			  								if($productRow['product_id'] == $quotationItemData['item_id']) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}

			  								echo "<option value='".$productRow['product_id']."' id='changeProduct".$productRow['product_id']."' ".$selected." >".$productRow['product_name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
			  					</div>
								</td>
								<?php 
									$unitId = $quotationItemData['item_unit_id'];
									$unitSql = "SELECT unit_name, unit_value FROM unit_of_measure WHERE unit_id = $unitId";
									$unitResult = $connect->query($unitSql);
									$unitData = $unitResult->fetch_array();
									$unitName = $unitData[0];
								?>
								<td style="padding-left:30px; padding-top: 10px;">
			  					<div class="form-group">
									<p id="unitName<?php echo $x; ?>"><?php echo $unitName ?></p>
			  					</div>
			  				</td>
			  				<td style="padding-left:10px;">			  					
			  					<input type="text" name="productPrice[]" id="productPrice<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $quotationItemData['item_price']; ?>" />					
			  					<input type="hidden" name="priceValue[]" id="priceValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $quotationItemData['item_price']; ?>" />
			  				</td>
			  				
								<td style="padding-left:20px;">
			  					<div class="form-group">
										<?php
			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['product_id'] == $quotationItemData['item_id']) { 
			  									echo "<p id='available_quantity".$row['product_id']."'>".$row['quantity']."</p>";
												}
			  								 else {
			  									$selected = "";
			  								}

										 	} // /while 

			  						?>
									
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" step="0.001" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" onchange="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $quotationItemData['quantity']; ?>" />
			  					</div>
								</td>
								<?php 
									$totalItem = 0;
									$totalItem = (float)$quotationItemData['item_price'] * (float)$quotationItemData['quantity'];
									$subTotal = $subTotal + $totalItem;
								?>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $totalItem; ?>"/>			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $totalItem; ?>"/>			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
							$arrayNumber++;
							$x++;
			  		} // /while
			  		?>
			  	</tbody>			  	
			  </table>

			  <div class="col-md-6">
					<button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Adicionar Linha </button>
				</div>
			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Sub Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="<?php echo $subTotal ?>" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?php echo $subTotal ?>" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Descontos</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" value="<?php echo $data[8] ?>" />
				    </div>
					</div> <!--/form-group-->	
					<div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="<?php echo $data[9] ?>" onchange="syncQuotationTotal()" />
				      <input type="hidden" class="form-control" id="quotationValue" name="quotationValue" value="<?php echo $data[9] ?>" />
				    </div>
					</div> <!--/form-group-->
					
					<div class="form-group">
							<label for="quotationApproved">Aprovado</label>
							<select class="form-control" name="quotationApproved" id="quotationApproved" >
								<option value="1" <?php echo ($data[10] == '1') ? "selected" : ""; ?> >Sim</option>
								<option value="0" <?php echo ($data[10] == '0') ? "selected" : ""; ?> >Não</option>
							</select>
						</div>
			  </div> <!--/col-md-6-->


			  <div class="form-group editButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">

			    <input type="hidden" name="quotationId" id="quotationId" value="<?php echo $_GET['i']; ?>" />

			    <button type="submit" id="editQuotationBtn" data-loading-text="Carregando..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Salvar Alterações</button>
			      
			    </div>
			  </div>
			</form>

			<?php
		} // /get quotation else  ?>

	</div> <!--/panel-->	
</div> <!--/panel-->	
<!-- /edit quotation -->

<!-- remove quotation -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeQuotationModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remover Orçamento</h4>
      </div>
      <div class="modal-body">

      	<div class="removeQuotationMessages"></div>

        <p>Tem certeza de que deseja remover?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
        <button type="button" class="btn btn-primary" id="removeQuotationBtn" data-loading-text="Carregando..."> <i class="glyphicon glyphicon-ok-sign"></i> Salvar Alterações</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove quotation-->


<script src="custom/js/quotations.js"></script>

<?php require_once 'includes/footer.php'; ?>


	