var managePersonTable;

$(document).ready(function() {
	// top bar active
	$('#navPerson').addClass('active');
	
	// manage person table
	managePersonTable = $("#managePersonTable").DataTable({
		'ajax': 'php_action/fetchPerson.php',
		'order': []		
	});

	// masks
	/*	
	var options = {
		onKeyPress: function(val, e, field, options) {
			var phoneMasks = ['(00) 0000-0000', '(00) 9 0000-0000'];
			var mask = (field.cleanVal().length > 10) ? phoneMasks[1] : phoneMasks[0];
			$('#personPhone').mask(mask, options);
		}
	}
	$('#personPhone').mask('(00) 9 0000-0000', options); */
	
	$('#personPostalcode').mask('00000-000', {placeholder: "_____-___"});
	
	$('#personType').change(function() {
		if ($('#personType').val() == '1') {					// pessoa física
			$('#personRegistryNumber').mask('000.000.000-00', {placeholder: "___.___.___-__"});
		} else if ($('#personType').val() == '2') {		// pessoa jurídica
			$('#personRegistryNumber').mask('00.000.000/0000-00', {placeholder: "__.___.___/____-__"});
		}
	})

	// populate city field when state field is selected
	$("#personState").change(function() {
		var stateValue = $("#personState").val();

		if (stateValue == ''){
			$('#personCity').attr("disabled", "disabled");
			$('#personCity').val("");
		} else {
			$.ajax({
				url: 'php_action/fetchCities.php',
				type: 'post',
				data: {stateValue : stateValue},
				dataType: 'json',
				success:function(response) {
					var $citySelect = $("#personCity");
					$('#personCity').empty();	// remove options
					$('#personCity').append("<option value=''>~~SELECIONAR~~</option>");	// reinclude default empty option

					var newOptions = response;
					$.each(newOptions, function(key, value) {
						$citySelect.append($("<option></option>")
							.attr("value", value).text(value));
					});

					$citySelect.removeAttr('disabled');
				}
			})
		}
	});

	// submit person form function
	$("#submitPersonForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

		var personType						= $("#personType").val();
		var personName 						= $("#personName").val();
		var personRole 						= $("#personRole").val();
		var personRegistryNumber 	= $("#personRegistryNumber").val();

		if(personType == "") {
			$("#personType").after('<p class="text-danger">Tipo da pessoa é obrigatório</p>');
			$('#personType').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#personType").find('.text-danger').remove();
			// success out for form 
			$("#personType").closest('.form-group').addClass('has-success');	  	
		}

		if(personName == "") {
			$("#personName").after('<p class="text-danger">Nome da pessoa é obrigatório</p>');
			$('#personName').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#personName").find('.text-danger').remove();
			// success out for form 
			$("#personName").closest('.form-group').addClass('has-success');	  	
		}

		if(personRole == "") {
			$("#personRole").after('<p class="text-danger">Papel da pessoa é obrigatório</p>');
			$('#personRole').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#personRole").find('.text-danger').remove();
			// success out for form 
			$("#personRole").closest('.form-group').addClass('has-success');	  	
		}

		if(personRegistryNumber == "") {
			$("#personRegistryNumber").after('<p class="text-danger">CPF/CNPJ da pessoa é obrigatório</p>');
			$('#personRegistryNumber').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#personRegistryNumber").find('.text-danger').remove();
			// success out for form 
			$("#personRegistryNumber").closest('.form-group').addClass('has-success');	  	
		}

		if(personType && personName && personRole && personRegistryNumber) {
			var form = $(this);
			// button loading
			$("#createPersonBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createPersonBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						managePersonTable.ajax.reload(null, false);						

  	  			// reset the form text
						$("#submitPersonForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
  	  			$('#add-person-messages').html('<div class="alert alert-success">'+
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
	}); // /submit person form function

});

function editPerson(personId = null) {
	if(personId) {
		// remove hidden person id text
		$('#personId').remove();

		// remove the error 
		$('.text-danger').remove();
		// remove the form-error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// modal loading
		$('.modal-loading').removeClass('div-hide');
		// modal result
		$('.edit-person-result').addClass('div-hide');
		// modal footer
		$('.editPersonFooter').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedPerson.php',
			type: 'post',
			data: {personId : personId},
			dataType: 'json',
			success:function(response) {
				// modal loading
				$('.modal-loading').addClass('div-hide');
				// modal result
				$('.edit-person-result').removeClass('div-hide');
				// modal footer
				$('.editPersonFooter').removeClass('div-hide');

				// masks
				$('#editPersonPostalcode').mask('00000-000', {placeholder: "_____-___"});
				$('#editPersonType').change(function() {
					if ($('#editPersonType').val() == '1') {					// pessoa física
						$('#editPersonRegistryNumber').mask('000.000.000-00', {placeholder: "___.___.___-__"});
					} else if ($('#editPersonType').val() == '2') {		// pessoa jurídica
						$('#editPersonRegistryNumber').mask('00.000.000/0000-00', {placeholder: "__.___.___/____-__"});
					}
				})

				// populate city select with options in order to subsequently select the correct value among them
				var stateValue = response.person_state;
				$.ajax({
					url: 'php_action/fetchCities.php',
					type: 'post',
					data: {stateValue : stateValue},
					dataType: 'json',
					success:function(citiesResponse) {
						var $citySelect = $("#editPersonCity");
						$('#editPersonCity').empty();	// remove options
						$('#editPersonCity').append("<option value=''>~~SELECIONAR~~</option>");	// reinclude default empty option
	
						var newOptions = citiesResponse;
						$.each(newOptions, function(key, value) {
							$citySelect.append($("<option></option>")
								.attr("value", value).text(value));
						});

						$('#editPersonCity').val(response.person_city);
					}
				})

				// setting person data
				$('#editPersonType').val(response.person_type);
				$('#editPersonName').val(response.person_name);
				$('#editPersonRole').val(response.person_role);
				$('#editPersonRegistryNumber').val(response.person_registry_number);
				$('#editPersonIE').val(response.person_ie);
				$('#editPersonEmail').val(response.person_email);
				$('#editPersonPhone').val(response.person_phone);
				$('#editPersonPostalcode').val(response.person_postalcode);
				$('#editPersonAddressStreet').val(response.person_address_street);
				$('#editPersonAddressNumber').val(response.person_address_number);
				$('#editPersonAddressComplem').val(response.person_address_complem);
				$('#editPersonAddressDistrict').val(response.person_address_district);
				$('#editPersonState').val(response.person_state);
				
				$('#editPersonBankName').val(response.person_bank_name);
				$('#editPersonBankAgency').val(response.person_bank_agency);
				$('#editPersonBankAccount').val(response.person_bank_account);
				$('#editPersonComments').val(response.person_comments);

				// repopulate city field when state field is changed
				$("#editPersonState").change(function() {
					var stateValue = $("#editPersonState").val();
			
					if (stateValue == ''){
						$('#editPersonCity').attr("disabled", "disabled");
						$('#editPersonCity').val("");
					} else {
						$.ajax({
							url: 'php_action/fetchCities.php',
							type: 'post',
							data: {stateValue : stateValue},
							dataType: 'json',
							success:function(response) {
								var $citySelect = $("#editPersonCity");
								$('#editPersonCity').empty();	// remove options
								$('#editPersonCity').append("<option value=''>~~SELECIONAR~~</option>");	// reinclude default empty option
			
								var newOptions = response;
								$.each(newOptions, function(key, value) {
									$citySelect.append($("<option></option>")
										.attr("value", value).text(value));
								});
			
								$citySelect.removeAttr('disabled');
							}
						})
					}
				});

				// person id 
				$(".editPersonFooter").after('<input type="hidden" name="personId" id="personId" value="'+response.person_id+'" />');

				// update person form 
				$('#editPersonForm').unbind('submit').bind('submit', function() {

					// remove the error text
					$(".text-danger").remove();
					// remove the form error
					$('.form-group').removeClass('has-error').removeClass('has-success');			

					var personType = $('#editPersonType').val();
					var personName = $('#editPersonName').val();
					var personRole = $('#editPersonRole').val();
					var personRegistryNumber = $('#editPersonRegistryNumber').val();

					if(personType == "") {
						$("#editPersonType").after('<p class="text-danger">Tipo da pessoa é obrigatório</p>');
						$('#editPersonType').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editPersonType").find('.text-danger').remove();
						// success out for form 
						$("#editPersonType").closest('.form-group').addClass('has-success');	  	
					}

					if(personName == "") {
						$("#editPersonName").after('<p class="text-danger">Nome da pessoa é obrigatório</p>');
						$('#editPersonName').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editPersonName").find('.text-danger').remove();
						// success out for form 
						$("#editPersonName").closest('.form-group').addClass('has-success');	  	
					}

					if(personRole == "") {
						$("#editPersonRole").after('<p class="text-danger">Papel da pessoa é obrigatório</p>');
						$('#editPersonRole').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editPersonRole").find('.text-danger').remove();
						// success out for form 
						$("#editPersonRole").closest('.form-group').addClass('has-success');	  	
					}

					if(personRegistryNumber == "") {
						$("#editPersonRegistryNumber").after('<p class="text-danger">CPF/CNPJ da pessoa é obrigatório</p>');

						$('#editPersonRegistryNumber').closest('.form-group').addClass('has-error');
					} else {
						// remove error text field
						$("#editPersonRegistryNumber").find('.text-danger').remove();
						// success out for form 
						$("#editPersonRegistryNumber").closest('.form-group').addClass('has-success');	  	
					}

					if(personType && personName && personRole && personRegistryNumber) {
						var form = $(this);

						// submit btn
						$('#editPersonBtn').button('loading');

						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {

								if(response.success == true) {
									// submit btn
									$('#editPersonBtn').button('reset');

									// reload the manage member table 
									managePersonTable.ajax.reload(null, false);								  	  										
									// remove the error text
									$(".text-danger").remove();
									// remove the form error
									$('.form-group').removeClass('has-error').removeClass('has-success');
			  	  			
			  	  			$('#edit-person-messages').html('<div class="alert alert-success">'+
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
				}); // /update person form

			} // /success
		}); // ajax function

	} else {
		alert('erro! Recarregue a página');
	}
} // /edit person function

// remove person
function removePerson(personId = null) {
	if(personId) {
		// remove person button clicked
		$("#removePersonBtn").unbind('click').bind('click', function() {
			// loading remove button
			$("#removePersonBtn").button('loading');
			$.ajax({
				url: 'php_action/removePerson.php',
				type: 'post',
				data: {personId: personId},
				dataType: 'json',
				success:function(response) {
					// loading remove button
					$("#removePersonBtn").button('reset');
					if(response.success == true) {
						// remove person modal
						$("#removePersonModal").modal('hide');

						// update the person table
						managePersonTable.ajax.reload(null, false);

						// remove success messages
						$(".remove-messages").html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					} else {

						// remove success messages
						$(".removePersonMessages").html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert

					} // /error
				} // /success function
			}); // /ajax function to remove the person
			return false;
		}); // /remove person btn clicked
	} // /if personid
} // /remove person function