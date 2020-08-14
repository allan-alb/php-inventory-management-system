<?php require_once 'includes/header.php'; ?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Unidade de medida</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Gerenciar Unidade de medida</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" data-target="#addUnitModel"> <i class="glyphicon glyphicon-plus-sign"></i> Adicionar unidade de medida </button>
				</div> <!-- /div-action -->				
				
				<table class="table" id="manageUnitTable">
					<thead>
						<tr>							
							<th>Nome da Unidade</th>
							<th>Valor da Unidade</th>
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

<div class="modal fade" id="addUnitModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="submitUnitForm" action="php_action/createUnit.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Unidade</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-unit-messages"></div>

	        <div class="form-group">
	        	<label for="unitName" class="col-sm-3 control-label">Nome da Unidade: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="unitName" placeholder="Nome da Unidade" name="unitName" autocomplete="off">
				    </div>
			</div> <!-- /form-group-->
			<div class="form-group">
	        	<label for="unitValue" class="col-sm-3 control-label">Valor da Unidade: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="number" class="form-control" id="unitValue" placeholder="Valor da Unidade" name="unitValue" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
	        <div class="form-group">
	        	<label for="unitStatus" class="col-sm-3 control-label">Status: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="unitStatus" name="unitStatus">
				      	<option value="">~~SELECIONE~~</option>
				      	<option value="1">Disponível</option>
				      	<option value="2">Não Disponível</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	         	        

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	        
	        <button type="submit" class="btn btn-primary" id="createUnitBtn" data-loading-text="Carregando..." autocomplete="off">Salvar Alterações</button>
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

<!-- edit unit -->
<div class="modal fade" id="editUnitModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="editUnitForm" action="php_action/editUnit.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Unidade de Medida</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="edit-unit-messages"></div>

	      	<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Carregando...</span>
					</div>

		      <div class="edit-unit-result">
		      	<div class="form-group">
		        	<label for="editUnitName" class="col-sm-3 control-label">Nome da Unidade: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="editUnitName" placeholder="Nome da Unidade" name="editUnitName" autocomplete="off">
					    </div>
				</div> <!-- /form-group-->
				<div class="form-group">
		        	<label for="editUnitValue" class="col-sm-3 control-label">Valor da Unidade: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <input type="number" class="form-control" id="editUnitValue" placeholder="Valor da Unidade" name="editUnitValue" autocomplete="off">
					    </div>
		        </div> <!-- /form-group-->
		        <div class="form-group">
		        	<label for="editUnitStatus" class="col-sm-3 control-label">Status: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <select class="form-control" id="editUnitStatus" name="editUnitStatus">
					      	<option value="">~~SELECIONE~~</option>
					      	<option value="1">Disponível</option>
					      	<option value="2">Não Disponível</option>
					      </select>
					    </div>
		        </div> <!-- /form-group-->	
		      </div>         	        
		      <!-- /edit unit result -->

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer editUnitFooter">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
	        
	        <button type="submit" class="btn btn-success" id="editUnitBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Salvar Alterações</button>
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
<!-- /edit unit -->

<!-- remove unit -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remover Unidade</h4>
      </div>
      <div class="modal-body">
        <p>Tem certeza de que deseja remover?</p>
      </div>
      <div class="modal-footer removeUnitFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fechar</button>
        <button type="button" class="btn btn-primary" id="removeUnitBtn" data-loading-text="Carregando..."> <i class="glyphicon glyphicon-ok-sign"></i> Salvar Alterações</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove unit -->

<script src="custom/js/unit.js"></script>

<?php require_once 'includes/footer.php'; ?>