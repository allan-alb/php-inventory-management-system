<?php require_once 'includes/header.php'; ?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Pessoa</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Cadastro de pessoa</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" data-target="#addPersonModel"> <i class="glyphicon glyphicon-plus-sign"></i> Adicionar pessoa </button>
				</div> <!-- /div-action -->				
				
				<table class="table" id="managePersonTable">
					<thead>
						<tr>
							<th>Nome da pessoa</th>
							<th>Tipo</th>
							<th>Papel</th>
							<th>E-mail</th>
							<th>Telefone</th>
							<th style="width:15%;">Options</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<div class="modal fade" id="addPersonModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="submitPersonForm" action="php_action/createPerson.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Pessoa</h4>
	      </div>
	      <div class="modal-body">

					<div id="add-person-messages"></div>

					<fieldset>
						<legend>Dados básicos:</legend>
					
					<div class="form-group">
	        	<label for="personType" class="col-sm-3 control-label">Tipo: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="personType" name="personType">
				      	<option value="">~~SELECIONAR~~</option>
				      	<option value="1">Pessoa Física</option>
				      	<option value="2">Pessoa Jurídica</option>
				      </select>
				    </div>
					</div> <!-- /form-group-->

	        <div class="form-group">
	        	<label for="personName" class="col-sm-3 control-label">Nome da pessoa: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personName" placeholder="Nome completo" name="personName" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personRole" class="col-sm-3 control-label">Papel: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="personRole" name="personRole">
				      	<option value="">~~SELECIONAR~~</option>
				      	<option value="1">Fornecedor</option>
								<option value="2">Cliente</option>
								<option value="3">Vendedor</option>
								<option value="4">Transportador</option>
				      </select>
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personRegistryNumber" class="col-sm-3 control-label">CPF/CNPJ: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personRegistryNumber" placeholder="CPF/CNPJ" name="personRegistryNumber" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personIE" class="col-sm-3 control-label">Inscrição Estadual: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personIE" placeholder="Número de Inscrição Estadual" name="personIE" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personEmail" class="col-sm-3 control-label">E-mail: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="email" class="form-control" id="personEmail" placeholder="Endereço de E-mail" name="personEmail" autocomplete="off" />
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personPhone" class="col-sm-3 control-label">Telefone: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personPhone" placeholder="Telefone" name="personPhone" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					</fieldset>

					<fieldset>
						<legend>Endereço:</legend>

					<div class="form-group">
	        	<label for="personPostalcode" class="col-sm-3 control-label">CEP: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personPostalcode" placeholder="CEP" name="personPostalcode" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personAddressStreet" class="col-sm-3 control-label">Logradouro: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personAddressStreet" placeholder="Logradouro" name="personAddressStreet" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personAddressNumber" class="col-sm-3 control-label">Número: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personAddressNumber" placeholder="Número" name="personAddressNumber" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personAddressComplem" class="col-sm-3 control-label">Complemento: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personAddressComplem" placeholder="Complemento" name="personAddressComplem" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personAddressDistrict" class="col-sm-3 control-label">Bairro: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personAddressDistrict" placeholder="Bairro" name="personAddressDistrict" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personState" class="col-sm-3 control-label">UF: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
							<select class="form-control" id="personState" name="personState">
				      	<option value="">~~SELECIONAR~~</option>
				      	<?php 
									$sql = "SELECT uf, nome FROM estado WHERE pais = 1";
									$result = $connect->query($sql);

									while($row = $result->fetch_array()) {
										echo "<option value='".$row[0]."'>".$row[1]."</option>";
									} // while
				      	?>
				      </select>
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personCity" class="col-sm-3 control-label">Cidade: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
						<select class="form-control" id="personCity" name="personCity" disabled="disabled">
								<option value="">~~SELECIONAR~~</option>
						</select>
				    </div>
					</div> <!-- /form-group-->

					</fieldset>

					<fieldset>
						<legend>Dados Bancários:</legend>

					<div class="form-group">
	        	<label for="personBankName" class="col-sm-3 control-label">Nome do Banco: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personBankName" placeholder="Nome do Banco" name="personBankName" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personBankAgency" class="col-sm-3 control-label">Agência: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personBankAgency" placeholder="Agência" name="personBankAgency" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="personBankAccount" class="col-sm-3 control-label">Conta: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="personBankAccount" placeholder="Conta" name="personBankAccount" autocomplete="off">
				    </div>
					</div> <!-- /form-group-->

					</fieldset>

					<fieldset>
						<legend>Informações adicionais:</legend>

					<div class="form-group">
	        	<label for="personComments" class="col-sm-3 control-label">Comentários: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <textarea style="resize: vertical;" class="form-control" id="personComments" placeholder="Comentários" name="personComments"></textarea>
				    </div>
					</div> <!-- /form-group-->         	        

					</fieldset>

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	        
	        <button type="submit" class="btn btn-primary" id="createPersonBtn" data-loading-text="Carregando..." autocomplete="off">Salvar Alterações</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->

<!-- edit person -->
<div class="modal fade" id="editPersonModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="editPersonForm" action="php_action/editPerson.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Pessoa</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="edit-person-messages"></div>

	      	<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Carregando...</span>
					</div>

		      <div class="edit-person-result">       	        
						
						<fieldset>
						<legend>Dados básicos:</legend>
					
							<div class="form-group">
								<label for="editPersonType" class="col-sm-3 control-label">Tipo: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<select class="form-control" id="editPersonType" name="editPersonType">
										<option value="">~~SELECIONAR~~</option>
										<option value="1">Pessoa Física</option>
										<option value="2">Pessoa Jurídica</option>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonName" class="col-sm-3 control-label">Nome da pessoa: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonName" placeholder="Nome completo" name="editPersonName" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonRole" class="col-sm-3 control-label">Papel: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<select class="form-control" id="editPersonRole" name="editPersonRole">
										<option value="">~~SELECIONAR~~</option>
										<option value="1">Fornecedor</option>
										<option value="2">Cliente</option>
										<option value="3">Vendedor</option>
										<option value="4">Transportador</option>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonRegistryNumber" class="col-sm-3 control-label">CPF/CNPJ: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonRegistryNumber" placeholder="CPF/CNPJ" name="editPersonRegistryNumber" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonIE" class="col-sm-3 control-label">Inscrição Estadual: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonIE" placeholder="Número de Inscrição Estadual" name="editPersonIE" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonEmail" class="col-sm-3 control-label">E-mail: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="email" class="form-control" id="editPersonEmail" placeholder="Endereço de E-mail" name="editPersonEmail" autocomplete="off" />
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonPhone" class="col-sm-3 control-label">Telefone: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonPhone" placeholder="Telefone" name="editPersonPhone" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

						</fieldset>

						<fieldset>
							<legend>Endereço:</legend>

							<div class="form-group">
								<label for="editPersonPostalcode" class="col-sm-3 control-label">CEP: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonPostalcode" placeholder="CEP" name="editPersonPostalcode" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonAddressStreet" class="col-sm-3 control-label">Logradouro: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonAddressStreet" placeholder="Logradouro" name="editPersonAddressStreet" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonAddressNumber" class="col-sm-3 control-label">Número: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonAddressNumber" placeholder="Número" name="editPersonAddressNumber" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonAddressComplem" class="col-sm-3 control-label">Complemento: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonAddressComplem" placeholder="Complemento" name="editPersonAddressComplem" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonAddressDistrict" class="col-sm-3 control-label">Bairro: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonAddressDistrict" placeholder="Bairro" name="editPersonAddressDistrict" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonState" class="col-sm-3 control-label">UF: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<select class="form-control" id="editPersonState" name="editPersonState">
										<option value="">~~SELECIONAR~~</option>
										<?php 
											$sql = "SELECT uf, nome FROM estado WHERE pais = 1";
											$result = $connect->query($sql);

											while($row = $result->fetch_array()) {
												echo "<option value='".$row[0]."'>".$row[1]."</option>";
											} // while
										?>
									</select>
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonCity" class="col-sm-3 control-label">Cidade: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
								<select class="form-control" id="editPersonCity" name="editPersonCity">
										<option value="">~~SELECIONAR~~</option>
								</select>
								</div>
							</div> <!-- /form-group-->

						</fieldset>

						<fieldset>
							<legend>Dados Bancários:</legend>

							<div class="form-group">
								<label for="editPersonBankName" class="col-sm-3 control-label">Nome do Banco: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonBankName" placeholder="Nome do Banco" name="editPersonBankName" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonBankAgency" class="col-sm-3 control-label">Agência: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonBankAgency" placeholder="Agência" name="editPersonBankAgency" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editPersonBankAccount" class="col-sm-3 control-label">Conta: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="editPersonBankAccount" placeholder="Conta" name="editPersonBankAccount" autocomplete="off">
								</div>
							</div> <!-- /form-group-->

						</fieldset>

						<fieldset>
							<legend>Informações adicionais:</legend>

							<div class="form-group">
								<label for="editPersonComments" class="col-sm-3 control-label">Comentários: </label>
								<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
									<textarea style="resize: vertical;" class="form-control" id="editPersonComments" placeholder="Comentários" name="editPersonComments"></textarea>
								</div>
							</div> <!-- /form-group-->         	        

						</fieldset>

		      </div>         	        
		      <!-- /edit person result -->

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer editPersonFooter">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
	        
	        <button type="submit" class="btn btn-success" id="editPersonBtn" data-loading-text="Carregando..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Salvar Alterações</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->
<!-- /edit person -->

<!-- remove person -->
<div class="modal fade" tabindex="-1" role="dialog" id="removePersonModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remover Pessoa</h4>
      </div>
      <div class="modal-body">
        <p>Tem certeza de que deseja remover?</p>
      </div>
      <div class="modal-footer removePersonFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
        <button type="button" class="btn btn-primary" id="removePersonBtn" data-loading-text="Carregando..."> <i class="glyphicon glyphicon-ok-sign"></i> Salvar Alterações</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove person -->

<script src="custom/js/people.js"></script>

<?php require_once 'includes/footer.php'; ?>