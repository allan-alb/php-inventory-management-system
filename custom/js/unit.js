var manageUnitTable;

$(document).ready(function() {
	// top bar active
	$('#navUnit').addClass('active');
	
	// manage unit table
	manageUnitTable = $("#manageUnitTable").DataTable({
		'ajax': 'php_action/fetchUnitOfMeasure.php',
		'order': []		
	});

	// submit unit form function
	$("#submitUnitForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

		var unitName = $("#unitName").val();
		var unitValue = $("#unitValue").val();
		var unitStatus = $("#unitStatus").val();

		if(unitName == "") {
			$("#unitName").after('<p class="text-danger">O campo Nome é obrigatório</p>');
			$('#unitName').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#unitName").find('.text-danger').remove();
			// success out for form 
			$("#unitName").closest('.form-group').addClass('has-success');	  	
		}

		if(unitValue == "") {
			$("#unitValue").after('<p class="text-danger">O campo Valor é obrigatório</p>');
			$('#unitValue').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#unitValue").find('.text-danger').remove();
			// success out for form 
			$("#unitValue").closest('.form-group').addClass('has-success');	  	
		}

		if(unitStatus == "") {
			$("#unitStatus").after('<p class="text-danger">Status da unidade é obrigatório</p>');

			$('#unitStatus').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#unitStatus").find('.text-danger').remove();
			// success out for form 
			$("#unitStatus").closest('.form-group').addClass('has-success');	  	
		}

		if(unitName && unitValue && unitStatus) {
			var form = $(this);
			// button loading
			$("#createUnitBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createUnitBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						manageUnitTable.ajax.reload(null, false);						

  	  			// reset the form text
						$("#submitUnitForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
  	  			$('#add-unit-messages').html('<div class="alert alert-success">'+
            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          '</div>');

  	  			$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					}  // if

				} // /success
			}); // /ajax	
		} // if

		return false;
	}); // /submit unit form function

});

function editUnits(unitId = null) {
	if(unitId) {
		// remove hidden unit id text
		$('#unitId').remove();

		// remove the error 
		$('.text-danger').remove();
		// remove the form-error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// modal loading
		$('.modal-loading').removeClass('div-hide');
		// modal result
		$('.edit-unit-result').addClass('div-hide');
		// modal footer
		$('.editUnitFooter').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedUnit.php',
			type: 'post',
			data: {unitId : unitId},
			dataType: 'json',
			success:function(response) {
				// modal loading
				$('.modal-loading').addClass('div-hide');
				// modal result
				$('.edit-unit-result').removeClass('div-hide');
				// modal footer
				$('.editUnitFooter').removeClass('div-hide');

				// setting the unit name value 
				$('#editUnitName').val(response.unit_name);
				// setting the unit value value 
				$('#editUnitValue').val(response.unit_value);
				// setting the unit status value
				$('#editUnitStatus').val(response.unit_active);
				// unit id 
				$(".editUnitFooter").after('<input type="hidden" name="unitId" id="unitId" value="'+response.unit_id+'" />');

				// update unit form 
				$('#editUnitForm').unbind('submit').bind('submit', function() {

					// remove the error text
					$(".text-danger").remove();
					// remove the form error
					$('.form-group').removeClass('has-error').removeClass('has-success');			

					var unitName = $('#editUnitName').val();
					var unitValue = $('#editUnitValue').val();
					var unitStatus = $('#editUnitStatus').val();

					if(unitName == "") {
						$("#editUnitName").after('<p class="text-danger">O campo Nome é obrigatório</p>');
						$('#editUnitName').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editUnitName").find('.text-danger').remove();
						// success out for form 
						$("#editUnitName").closest('.form-group').addClass('has-success');	  	
					}

					if(unitValue == "") {
						$("#editUnitValue").after('<p class="text-danger">O campo Valor é obrigatório</p>');
						$('#editUnitValue').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editUnitValue").find('.text-danger').remove();
						// success out for form 
						$("#editUnitValue").closest('.form-group').addClass('has-success');	  	
					}

					if(unitStatus == "") {
						$("#editUnitStatus").after('<p class="text-danger">Status da unidade é obrigatório</p>');

						$('#editUnitStatus').closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editUnitStatus").find('.text-danger').remove();
						// success out for form 
						$("#editUnitStatus").closest('.form-group').addClass('has-success');	  	
					}

					if(unitName && unitValue && unitStatus) {
						var form = $(this);

						// submit btn
						$('#editUnitBtn').button('loading');

						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {

								if(response.success == true) {
									console.log(response);
									// submit btn
									$('#editUnitBtn').button('reset');

									// reload the manage member table 
									manageUnitTable.ajax.reload(null, false);								  	  										
									// remove the error text
									$(".text-danger").remove();
									// remove the form error
									$('.form-group').removeClass('has-error').removeClass('has-success');
			  	  			
			  	  			$('#edit-unit-messages').html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
								} // /if
									
							}// /success
						});	 // /ajax												
					} // /if

					return false;
				}); // /update unit form

			} // /success
		}); // ajax function

	} else {
		alert('error!! Refresh the page again');
	}
} // /edit units function

function removeUnits(unitId = null) {
	if(unitId) {
		$('#removeUnitId').remove();
		$.ajax({
			url: 'php_action/fetchSelectedUnit.php',
			type: 'post',
			data: {unitId : unitId},
			dataType: 'json',
			success:function(response) {
				$('.removeUnitFooter').after('<input type="hidden" name="removeUnitId" id="removeUnitId" value="'+response.unit_id+'" /> ');

				// click on remove button to remove the unit
				$("#removeUnitBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeUnitBtn").button('loading');

					$.ajax({
						url: 'php_action/removeUnit.php',
						type: 'post',
						data: {unitId : unitId},
						dataType: 'json',
						success:function(response) {
							console.log(response);
							// button loading
							$("#removeUnitBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal 
								$('#removeMemberModal').modal('hide');

								// reload the unit table 
								manageUnitTable.ajax.reload(null, false);
								
								$('.remove-messages').html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
							} else {

							} // /else
						} // /response messages
					}); // /ajax function to remove the unit

				}); // /click on remove button to remove the unit

			} // /success
		}); // /ajax

		$('.removeUnitFooter').after();
	} else {
		alert('error!! Refresh the page again');
	}
} // /remove units function