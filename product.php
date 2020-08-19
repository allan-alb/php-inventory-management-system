<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Produto</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Gerenciar Produto</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="glyphicon glyphicon-plus-sign"></i> Adicionar Produto </button>
				</div> <!-- /div-action -->				
				
				<table class="table" id="manageProductTable">
					<thead>
						<tr>
							<th style="width:10%;">Foto</th>
							<th>Código</th>					
							<th>Nome do Produto</th>
							<th>Tipo</th>
							<th>Matéria prima</th>
							<th>Unidade</th>
							<th>Quantidade</th>
							<th>Alerta de Qtde.</th>
							<th>Preço</th>
							<th>Status</th>
							<th style="width:15%;">Opções</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->


<!-- add product -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

    	<form class="form-horizontal" id="submitProductForm" action="php_action/createProduct.php" method="POST" enctype="multipart/form-data">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Produto</h4>
	      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div id="add-product-messages"></div>

	      	<div class="form-group">
	        	<label for="productImage" class="col-sm-3 control-label">Imagem do produto: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
					    <!-- the avatar markup -->
							<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
					    <div class="kv-avatar center-block">					        
					        <input type="file" class="form-control" id="productImage" placeholder="Imagem do Produto" name="productImage" class="file-loading" style="width:auto;"/>
					    </div>
				      
				    </div>
	        </div> <!-- /form-group-->	     	           	       

			<div class="form-group">
	        	<label for="productCode" class="col-sm-3 control-label">Código do produto: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="productCode" placeholder="Código do Produto" name="productCode" autocomplete="off" maxlength="30">
				    </div>
	        </div> <!-- /form-group-->	 

	        <div class="form-group">
	        	<label for="productName" class="col-sm-3 control-label">Nome do produto: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="productName" placeholder="Nome do Produto" name="productName" autocomplete="off" maxlength="255">
				    </div>
	        </div> <!-- /form-group-->
			
			<div class="form-group">
	        	<label for="productType" class="col-sm-3 control-label">Tipo: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="productType" name="productType">
				      	<option value="">~~SELECIONAR~~</option>
				      	<option value="1">Matéria prima</option>
				      	<option value="2">Produto acabado</option>
						<option value="3">Embalagem</option>
				      </select>
				    </div>
			</div> <!-- /form-group-->
			
			<div class="form-group">
	        	<label for="rawMaterial" class="col-sm-3 control-label">Matéria prima: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="rawMaterial" name="rawMaterial">
				      	<option value="">~~SELECIONAR~~</option>
				      	<?php 
									$sql = "SELECT product_id, product_name, status FROM product WHERE status = 1 AND product_type = 1";
									$result = $connect->query($sql);

									while($row = $result->fetch_array()) {
										echo "<option value='".$row[0]."'>".$row[1]."</option>";
									} // while
				      	?>
				      </select>
				    </div>
			</div> <!-- /form-group-->

			<div class="form-group">
	        	<label for="unitOfMeasure" class="col-sm-3 control-label">Unidade de medida: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="unitOfMeasure" name="unitOfMeasure">
				      	<option value="">~~SELECIONAR~~</option>
				      	<?php 
				      	$sql = "SELECT unit_id, unit_name, unit_status FROM unit_of_measure WHERE unit_status = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->

	        <div class="form-group">
	        	<label for="quantity" class="col-sm-3 control-label">Quantidade: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="quantity" placeholder="Quantidade" name="quantity" autocomplete="off">
				    </div>
			</div> <!-- /form-group-->
			
			<div class="form-group">
	        	<label for="quantityAlert" class="col-sm-3 control-label">Alerta de quantidade: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="quantityAlert" placeholder="Alerta de quantidade" name="quantityAlert" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->

	        <div class="form-group">
	        	<label for="productCost" class="col-sm-3 control-label">Valor de custo: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="productCost" placeholder="Custo" name="productCost" autocomplete="off">
				    </div>
			</div> <!-- /form-group-->
			
			<div class="form-group">
	        	<label for="productPrice" class="col-sm-3 control-label">Preço de venda: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="productPrice" placeholder="Preço" name="productPrice" autocomplete="off">
				    </div>
			</div> <!-- /form-group-->
			
			<div class="form-group">
	        	<label for="productDescription" class="col-sm-3 control-label">Descrição: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <textarea class="form-control" id="productDescription" placeholder="Descrição" name="productDescription"></textarea>
				    </div>
			</div> <!-- /form-group-->
			
			<div class="form-group">
	        	<label for="tributaryOrigin" class="col-sm-3 control-label">Origem fiscal: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="tributaryOrigin" name="tributaryOrigin">
				      	<option value="">~~SELECIONAR~~</option>
						<option value="0">0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8</option>
						<option value="1">1 - Estrangeira - Importação direta, exceto a indicada no código 6</option>  
				    <option value="2">2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7</option>
						<option value="3">3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior...</option>
						<option value="4">4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produti...</option>
						<option value="5">5 - Nacional, mercadoria ou bem com Conteúdo de Importação interior ou igal a 40%</option>
						<option value="6">6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e...</option>
						<option value="7">7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CA...</option>
						<option value="8">8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%</option>
				      </select>
				    </div>
			</div> <!-- /form-group-->

			<div class="form-group">
	        	<label for="tributaryNCM" class="col-sm-3 control-label">NCM: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="tributaryNCM" placeholder="NCM" name="tributaryNCM" autocomplete="off" maxlength="20">
				    </div>
			</div> <!-- /form-group-->
			
			<div class="form-group">
	        	<label for="tributaryCEST" class="col-sm-3 control-label">CEST: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="tributaryCEST" placeholder="CEST" name="tributaryCEST" autocomplete="off" maxlength="20">
				    </div>
			</div> <!-- /form-group-->
			
			<div class="form-group">
	        	<label for="tributaryGroup" class="col-sm-3 control-label">Grupo tributário: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="number" class="form-control" id="tributaryGroup" placeholder="Grupo" name="tributaryGroup" autocomplete="off">
				    </div>
			</div> <!-- /form-group-->
			
			<div class="form-group">
	        	<label for="tributaryBenefitCode" class="col-sm-3 control-label">Código de benefício fiscal: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="tributaryBenefitCode" placeholder="Código de benefício fiscal" name="tributaryBenefitCode" autocomplete="off" maxlength="20">
				    </div>
			</div> <!-- /form-group-->					        	         	       

	        <div class="form-group">
	        	<label for="productStatus" class="col-sm-3 control-label">Status: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="productStatus" name="productStatus">
				      	<option value="">~~SELECIONAR~~</option>
				      	<option value="1">Disponível</option>
				      	<option value="2">Não Disponível</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	         	        
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
	        
	        <button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Carregando..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Salvar Alterações</button>
	      </div> <!-- /modal-footer -->	      
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->


<!-- edit categories brand -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	    	
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Produto</h4>
	      </div>
	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div class="div-loading">
	      		<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Carregando...</span>
	      	</div>

	      	<div class="div-result">

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#photo" aria-controls="home" role="tab" data-toggle="tab">Foto</a></li>
				    <li role="presentation"><a href="#productInfo" aria-controls="profile" role="tab" data-toggle="tab">Informação do Produto</a></li>    
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">

				  	
				    <div role="tabpanel" class="tab-pane active" id="photo">
				    	<form action="php_action/editProductImage.php" method="POST" id="updateProductImageForm" class="form-horizontal" enctype="multipart/form-data">

				    	<br />
				    	<div id="edit-productPhoto-messages"></div>

				    	<div class="form-group">
			        	<label for="editProductImage" class="col-sm-3 control-label">Imagem do Produto: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">							    				   
						      <img src="" id="getProductImage" class="thumbnail" style="width:250px; height:250px;" />
						    </div>
			        </div> <!-- /form-group-->	     	           	       
				    	
			      	<div class="form-group">
			        	<label for="editProductImage" class="col-sm-3 control-label">Selecionar Foto: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
							    <!-- the avatar markup -->
									<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
							    <div class="kv-avatar center-block">					        
							        <input type="file" class="form-control" id="editProductImage" placeholder="Imagem do Produto" name="editProductImage" class="file-loading" style="width:auto;"/>
							    </div>
						      
						    </div>
			        </div> <!-- /form-group-->	     	           	       

			        <div class="modal-footer editProductPhotoFooter">
				        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
				        
				        <!-- <button type="submit" class="btn btn-success" id="editProductImageBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button> -->
				      </div>
				      <!-- /modal-footer -->
				      </form>
				      <!-- /form -->
				    </div>
				    <!-- product image -->
				    <div role="tabpanel" class="tab-pane" id="productInfo">
				    	<form class="form-horizontal" id="editProductForm" action="php_action/editProduct.php" method="POST">				    
				    	<br />

							<div id="edit-product-messages"></div>
							
							<div class="form-group">
								<label for="editProductCode" class="col-sm-3 control-label">Código do produto: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editProductCode" placeholder="Código do Produto" name="editProductCode" autocomplete="off" maxlength="30">
								</div>
							</div> <!-- /form-group-->	

				    	<div class="form-group">
			        	<label for="editProductName" class="col-sm-3 control-label">Nome do Produto: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editProductName" placeholder="Nome do Produto" name="editProductName" autocomplete="off" maxlength="255">
						    </div>
							</div> <!-- /form-group-->
							
							<div class="form-group">
								<label for="editProductType" class="col-sm-3 control-label">Tipo: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<select class="form-control" id="editProductType" name="editProductType">
										<option value="">~~SELECIONAR~~</option>
										<option value="1">Matéria prima</option>
										<option value="2">Produto acabado</option>
										<option value="3">Embalagem</option>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editRawMaterial" class="col-sm-3 control-label">Matéria prima: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<select class="form-control" id="editRawMaterial" name="editRawMaterial">
										<option value="">~~SELECIONAR~~</option>
										<?php 
											$sql = "SELECT product_id, product_name, status FROM product WHERE status = 1 AND product_type = 1";
											$result = $connect->query($sql);

											while($row = $result->fetch_array()) {
												echo "<option value='".$row[0]."'>".$row[1]."</option>";
											} // while	
										?>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editUnitOfMeasure" class="col-sm-3 control-label">Unidade de medida: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<select class="form-control" id="editUnitOfMeasure" name="editUnitOfMeasure">
										<option value="">~~SELECIONAR~~</option>
										<?php 
										$sql = "SELECT unit_id, unit_name, unit_status FROM unit_of_measure WHERE unit_status = 1";
										$result = $connect->query($sql);

										while($row = $result->fetch_array()) {
											echo "<option value='".$row[0]."'>".$row[1]."</option>";
										} // while
										
										?>
									</select>
								</div>
							</div> <!-- /form-group-->

			        <div class="form-group">
			        	<label for="editQuantity" class="col-sm-3 control-label">Quantidade: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editQuantity" placeholder="Quantidade" name="editQuantity" autocomplete="off">
						    </div>
							</div> <!-- /form-group-->
							
							<div class="form-group">
								<label for="editQuantityAlert" class="col-sm-3 control-label">Alerta de quantidade: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editQuantityAlert" placeholder="Alerta de quantidade" name="editQuantityAlert" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

			        <div class="form-group">
								<label for="editProductCost" class="col-sm-3 control-label">Valor de custo: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editProductCost" placeholder="Custo" name="editProductCost" autocomplete="off" />
								</div>
							</div> <!-- /form-group-->
					
							<div class="form-group">
										<label for="editProductPrice" class="col-sm-3 control-label">Preço de venda: </label>
										<label class="col-sm-1 control-label">: </label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="editProductPrice" placeholder="Preço" name="editProductPrice" autocomplete="off">
										</div>
							</div> <!-- /form-group-->
	
							<div class="form-group">
								<label for="editProductDescription" class="col-sm-3 control-label">Descrição: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<textarea class="form-control" id="editProductDescription" placeholder="Descrição" name="editProductDescription"></textarea>
								</div>
							</div> <!-- /form-group-->
							
							<div class="form-group">
								<label for="editTributaryOrigin" class="col-sm-3 control-label">Origem fiscal: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<select class="form-control" id="editTributaryOrigin" name="editTributaryOrigin">
										<option value="">~~SELECIONAR~~</option>
										<option value="0">0 - Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8</option>
										<option value="1">1 - Estrangeira - Importação direta, exceto a indicada no código 6</option>  
										<option value="2">2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7</option>
										<option value="3">3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior...</option>
										<option value="4">4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produti...</option>
										<option value="5">5 - Nacional, mercadoria ou bem com Conteúdo de Importação interior ou igal a 40%</option>
										<option value="6">6 - Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX e...</option>
										<option value="7">7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante lista CA...</option>
										<option value="8">8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%</option>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editTributaryNCM" class="col-sm-3 control-label">NCM: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editTributaryNCM" placeholder="NCM" name="editTributaryNCM" autocomplete="off" maxlength="20">
								</div>
							</div> <!-- /form-group-->
							
							<div class="form-group">
								<label for="editTributaryCEST" class="col-sm-3 control-label">CEST: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editTributaryCEST" placeholder="CEST" name="editTributaryCEST" autocomplete="off" maxlength="20">
								</div>
							</div> <!-- /form-group-->
							
							<div class="form-group">
								<label for="editTributaryGroup" class="col-sm-3 control-label">Grupo tributário: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="number" class="form-control" id="editTributaryGroup" placeholder="Grupo" name="editTributaryGroup" autocomplete="off">
								</div>
							</div> <!-- /form-group-->
							
							<div class="form-group">
								<label for="editTributaryBenefitCode" class="col-sm-3 control-label">Código de benefício fiscal: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editTributaryBenefitCode" placeholder="Código de benefício fiscal" name="editTributaryBenefitCode" autocomplete="off" maxlength="20">
								</div>
							</div> <!-- /form-group-->

			        <div class="form-group">
			        	<label for="editProductStatus" class="col-sm-3 control-label">Status: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <select class="form-control" id="editProductStatus" name="editProductStatus">
						      	<option value="">~~SELECIONAR~~</option>
						      	<option value="1">Disponível</option>
						      	<option value="2">Não Disponível</option>
						      </select>
						    </div>
			        </div> <!-- /form-group-->	         	        

			        <div class="modal-footer editProductFooter">
				        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
				        
				        <button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Carregando..."> <i class="glyphicon glyphicon-ok-sign"></i> Salvar Alterações</button>
				      </div> <!-- /modal-footer -->				     
			        </form> <!-- /.form -->				     	
				    </div>    
				    <!-- /product info -->
				  </div>

				</div>
	      	
	      </div> <!-- /modal-body -->
	      	      
     	
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- /categories brand -->

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remover Produto</h4>
      </div>
      <div class="modal-body">

      	<div class="removeProductMessages"></div>

        <p>Tem certeza de que deseja remover?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
        <button type="button" class="btn btn-primary" id="removeProductBtn" data-loading-text="Carregando..."> <i class="glyphicon glyphicon-ok-sign"></i> Salvar alterações</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->


<script src="custom/js/product.js"></script>

<?php require_once 'includes/footer.php'; ?>