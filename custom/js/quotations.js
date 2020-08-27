var manageQuotationTable;

$(document).ready(function() {
	
	var divRequest = $(".div-request").text();

	// top nav bar 
	$("#navQuotation").addClass('active');

	if(divRequest == 'add')  {
		// add quotation	
		// top nav child bar 
		$('#topNavAddQuotation').addClass('active');	

		// quotation date picker
		$("#quotationDate").datepicker({ dateFormat: 'yy-mm-dd' });
		$("#quotationDeadline").datepicker({ dateFormat: 'yy-mm-dd' });

		// cpf/cnpj field
		$("#clientName").change(function() {
			updateRegistryNumber();
		})

		// create quotation form function
		$("#createQuotationForm").unbind('submit').bind('submit', function() {
			var form = $(this);

			$('.form-group').removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove();
				
			var quotationDate = $("#quotationDate").val();
			var clientName = $("#clientName").val();
			var quotationDeadline = $("#quotationDeadline").val();
			var totalAmount = $("#totalAmount").val();

			// form validation 
			if(quotationDate == "") {
				$("#quotationDate").after('<p class="text-danger"> O campo Data é obrigatório </p>');
				$('#quotationDate').closest('.form-group').addClass('has-error');
			} else {
				$('#quotationDate').closest('.form-group').addClass('has-success');
			} // /else

			if(clientName == "") {
				$("#clientName").after('<p class="text-danger"> O campo Cliente é obrigatório </p>');
				$('#clientName').closest('.form-group').addClass('has-error');
			} else {
				$('#clientName').closest('.form-group').addClass('has-success');
			} // /else

			if(quotationDeadline == "") {
				$("#quotationDeadline").after('<p class="text-danger"> O campo Prazo é obrigatório </p>');
				$('#quotationDeadline').closest('.form-group').addClass('has-error');
			} else {
				$('#quotationDeadline').closest('.form-group').addClass('has-success');
			} // /else

			if(totalAmount == "") {
				$("#totalAmount").after('<p class="text-danger"> O campo Total é obrigatório </p>');
				$('#totalAmount').closest('.form-group').addClass('has-error');
			} else {
				$('#totalAmount').closest('.form-group').addClass('has-success');
			} // /else


			// array validation
			var productName = document.getElementsByName('productName[]');				
			var validateProduct;
			for (var x = 0; x < productName.length; x++) {       			
				var productNameId = productName[x].id;	    	
		    if(productName[x].value == ''){	    		    	
		    	$("#"+productNameId+"").after('<p class="text-danger"> O campo Nome do Produto é obrigatório!! </p>');
		    	$("#"+productNameId+"").closest('.form-group').addClass('has-error');	    		    	    	
	      } else {      	
		    	$("#"+productNameId+"").closest('.form-group').addClass('has-success');	    		    		    	
	      }          
	   	} // for

	   	for (var x = 0; x < productName.length; x++) {       						
		    if(productName[x].value){	    		    		    	
		    	validateProduct = true;
	      } else {      	
		    	validateProduct = false;
	      }          
	   	} // for       		   	
	   	
	   	var quantity = document.getElementsByName('quantity[]');		   	
	   	var validateQuantity;
	   	for (var x = 0; x < quantity.length; x++) {       
	 			var quantityId = quantity[x].id;
		    if(quantity[x].value == ''){	    	
		    	$("#"+quantityId+"").after('<p class="text-danger"> O campo Quantidade é obrigatório!! </p>');
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < quantity.length; x++) {       						
		    if(quantity[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for       	

			if(quotationDate && clientName && quotationDeadline && totalAmount) {
				if(validateProduct == true && validateQuantity == true) {
					// create quotation button
					// $("#creatQuotationBtn").button('loading');
					console.log(form.serialize());

					$.ajax({
						url : form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),					
						dataType: 'json',
						success:function(response) {
							console.log(response);
							// reset button
							$("#createQuotationBtn").button('reset');
							
							$(".text-danger").remove();
							$('.form-group').removeClass('has-error').removeClass('has-success');

							if(response.success == true) {
								
								// create quotation button
								$(".success-messages").html('<div class="alert alert-success">'+
	            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
	            	' <br /> <br /> <a type="button" onclick="printQuotation('+response.quotation_id+')" class="btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Imprimir </a>'+
	            	'<a href="quotations.php?o=add" class="btn btn-default" style="margin-left:10px;"> <i class="glyphicon glyphicon-plus-sign"></i> Novo Orçamento </a>'+
	            	
	   		       '</div>');
								
							$("html, body, div.panel, div.panel-body").animate({scrollTop: '0px'}, 100);

							// disabled te modal footer button
							$(".submitButtonFooter").addClass('div-hide');
							// remove the product row
							$(".removeProductRowBtn").addClass('div-hide');
								
							} else {
								alert(response.messages);								
							}
						} // /response
					}); // /ajax
				} // if array validate is true
			} // /if field validate is true
			

			return false;
		}); // /create quotation form function	
	
	} else if(divRequest == 'manquo') {
		// top nav child bar 
		$('#topNavManageQuotation').addClass('active');

		manageQuotationTable = $("#manageQuotationTable").DataTable({
			'ajax': 'php_action/fetchQuotation.php',
			'order': []
		});		
					
	} else if(divRequest == 'editQuo') {
		$("#quotationDate").datepicker({ dateFormat: 'yy-mm-dd' });
		$("#quotationDeadline").datepicker({ dateFormat: 'yy-mm-dd' });

		updateRegistryNumber();

		$("#clientName").change(function () {
			updateRegistryNumber();
		})

		// edit quotation form function
		$("#editQuotationForm").unbind('submit').bind('submit', function() {
			// alert('ok');
			var form = $(this);

			$('.form-group').removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove();
				
			var quotationDate = $("#quotationDate").val();
			var clientName = $("#clientName").val();
			var quotationDate = $("#quotationDate").val();
			var totalAmount = $("#totalAmount").val();

			// form validation 
			if(quotationDate == "") {
				$("#quotationDate").after('<p class="text-danger"> O campo Data é obrigatório </p>');
				$('#quotationDate').closest('.form-group').addClass('has-error');
			} else {
				$('#quotationDate').closest('.form-group').addClass('has-success');
			} // /else

			if(clientName == "") {
				$("#clientName").after('<p class="text-danger"> O campo Cliente é obrigatório </p>');
				$('#clientName').closest('.form-group').addClass('has-error');
			} else {
				$('#clientName').closest('.form-group').addClass('has-success');
			} // /else

			if(quotationDeadline == "") {
				$("#quotationDeadline").after('<p class="text-danger"> O campo Prazo é obrigatório </p>');
				$('#quotationDeadline').closest('.form-group').addClass('has-error');
			} else {
				$('#quotationDeadline').closest('.form-group').addClass('has-success');
			} // /else

			if(totalAmount == "") {
				$("#totalAmount").after('<p class="text-danger"> O campo Total é obrigatório </p>');
				$('#totalAmount').closest('.form-group').addClass('has-error');
			} else {
				$('#totalAmount').closest('.form-group').addClass('has-success');
			} // /else
			
			// array validation
			var productName = document.getElementsByName('productName[]');				
			var validateProduct;
			for (var x = 0; x < productName.length; x++) {       			
				var productNameId = productName[x].id;	    	
		    if(productName[x].value == ''){	    		    	
		    	$("#"+productNameId+"").after('<p class="text-danger"> Nome do produto é obrigatório! </p>');
		    	$("#"+productNameId+"").closest('.form-group').addClass('has-error');	    		    	    	
	      } else {      	
		    	$("#"+productNameId+"").closest('.form-group').addClass('has-success');	    		    		    	
	      }          
	   	} // for

	   	for (var x = 0; x < productName.length; x++) {			
		    if(productName[x].value){
		    	validateProduct = true;
	      } else {
		    	validateProduct = false;
	      }
	   	} // for
	   	
	   	var quantity = document.getElementsByName('quantity[]');
	   	var validateQuantity;
	   	for (var x = 0; x < quantity.length; x++) {
	 			var quantityId = quantity[x].id;
		    if(quantity[x].value == ''){
		    	$("#"+quantityId+"").after('<p class="text-danger"> Quantidade do produto é obrigatório! </p>');
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-error');
	      } else {
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-success');
	      } 
	   	}  // for

	   	for (var x = 0; x < quantity.length; x++) {       						
		    if(quantity[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for       	
	   	

			if(quotationDate && clientName && quotationDeadline && totalAmount) {
				if(validateProduct == true && validateQuantity == true) {
					// create quotation button

					$.ajax({
						url : form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),					
						dataType: 'json',
						success:function(response) {
							console.log(response);
							// reset button
							$("#ediQuotationBtn").button('reset');
							
							$(".text-danger").remove();
							$('.form-group').removeClass('has-error').removeClass('has-success');

							if(response.success == true) {
								
								// create quotation button
								$(".success-messages").html('<div class="alert alert-success">'+
	            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +	            		            		            	
	   		       '</div>');
								
							$("html, body, div.panel, div.panel-body").animate({scrollTop: '0px'}, 100);

							// disabled te modal footer button
							$(".editButtonFooter").addClass('div-hide');
							// remove the product row
							$(".removeProductRowBtn").addClass('div-hide');
								
							} else {
								alert(response.messages);								
							}
						} // /response
					}); // /ajax
				} // if array validate is true
			} // /if field validate is true
			
			return false;
		}); // /edit quotation form function	
	} 	

}); // /document


// print quotation function
function printQuotation(quotationId = null) {
	if(quotationId) {		
			
		$.ajax({
			url: 'php_action/printQuotation.php',
			type: 'post',
			data: {quotationId: quotationId},
			dataType: 'text',
			success:function(response) {
				
				var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Quotation Invoice</title>');        
        mywindow.document.write('</head><body>');
        mywindow.document.write(response);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.resizeTo(screen.width, screen.height);
setTimeout(function() {
    mywindow.print();
    mywindow.close();
}, 1250);

        //mywindow.print();
        //mywindow.close();
				
			}// /success function
		}); // /ajax function to fetch the printable quotation
	} // /if quotationId
} // /print quotation function

function addRow() {
	$("#addRowBtn").button("loading");

	var tableLength = $("#productTable tbody tr").length;

	var tableRow;
	var arrayNumber;
	var count;

	if(tableLength > 0) {		
		tableRow = $("#productTable tbody tr:last").attr('id');
		arrayNumber = $("#productTable tbody tr:last").attr('class');
		count = tableRow.substring(3);	
		count = Number(count) + 1;
		arrayNumber = Number(arrayNumber) + 1;					
	} else {
		// no table row
		count = 1;
		arrayNumber = 0;
	}

	$.ajax({
		url: 'php_action/fetchProductData.php',
		type: 'post',
		dataType: 'json',
		success:function(response) {
			$("#addRowBtn").button("reset");			

			var tr = '<tr id="row'+count+'" class="'+arrayNumber+'">'+			  				
				'<td>'+
					'<div class="form-group">'+

					'<select class="form-control" name="productName[]" id="productName'+count+'" onchange="getProductData('+count+')" >'+
						'<option value="">~~SELECT~~</option>';
						// console.log(response);
						$.each(response, function(index, value) {
							tr += '<option value="'+value[0]+'">'+value[1]+'</option>';							
						});
													
					tr += '</select>'+
					'</div>'+
				'</td>'+
				'<td style="padding-left:30px; padding-top: 10px;">'+
					'<div class="form-group">'+
					'<p id="unitName'+count+'"></p>'+
					'</div>'+
				'</td>'+
				'<td style="padding-left:10px;"">'+
					'<input type="text" name="productPrice[]" id="productPrice'+count+'" autocomplete="off" disabled="true" class="form-control" />'+
					'<input type="hidden" name="priceValue[]" id="priceValue'+count+'" autocomplete="off" class="form-control" />'+
				'</td>'+
				'<td style="padding-left:20px; padding-top: 10px; display: flex; justify-content: center; align-items: center;">'+
					'<div class="form-group">'+
					'<p id="available_quantity'+count+'"></p>'+
					'</div>'+
				'</td>'+
				'<td style="padding-left:10px;">'+
					'<div class="form-group">'+
					'<input type="number" step="0.001" name="quantity[]" id="quantity'+count+'" onkeyup="getTotal('+count+')" '+
						'onchange="getTotal('+count+')" autocomplete="off" class="form-control" min="1" />'+
					'</div>'+
				'</td>'+
				'<td style="padding-left:20px;">'+
					'<input type="text" name="total[]" id="total'+count+'" autocomplete="off" class="form-control" disabled="true" />'+
					'<input type="hidden" name="totalValue[]" id="totalValue'+count+'" autocomplete="off" class="form-control" />'+
				'</td>'+
				'<td>'+
					'<button class="btn btn-default removeProductRowBtn" type="button" onclick="removeProductRow('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
				'</td>'+
			'</tr>';
			if(tableLength > 0) {							
				$("#productTable tbody tr:last").after(tr);
			} else {				
				$("#productTable tbody").append(tr);
			}		

		} // /success
	});	// get the product data

} // /add row

function removeProductRow(row = null) {
	if(row) {
		$("#row"+row).remove();


		subAmount();
	} else {
		alert('erro! recarregue a página');
	}
}

// select on product data
function getProductData(row = null) {

	if(row) {
		var productId = $("#productName"+row).val();		
		
		if(productId == "") {
			$("#productPrice"+row).val("");

			$("#quantity"+row).val("");						
			$("#total"+row).val("");


		} else {
			$.ajax({
				url: 'php_action/fetchSelectedProduct.php',
				type: 'post',
				data: {productId : productId},
				dataType: 'json',
				success:function(response) {
					$.ajax({
						url: 'php_action/fetchSelectedUnit.php',
						type: 'post',
						data: {unitId: response.unit_id},
						dataType: 'json',
						success: function(unitResponse) {
							$("#unitName"+row).text(unitResponse.unit_name);
						}
					})
					// setting the price value into the price input field
					
					$("#productPrice"+row).val(numberDisplayFormat(response.product_price));
					$("#priceValue"+row).val(response.product_price);

					$("#quantity"+row).val(1);
					$("#available_quantity"+row).text(numberDisplayFormat(response.quantity));

					var total = Number(response.product_price) * 1;
					total = total.toFixed(2);
					$("#total"+row).val(total);
					$("#totalValue"+row).val(total);
			
					subAmount();
				} // /success
			}); // /ajax function to fetch the product data	
		}
				
	} else {
		alert('no row! please refresh the page');
	}
} // /select on product data

function updateRegistryNumber() {
	if ($("#clientName").val() != "") {
		var personId = $("#clientName").val();

		$.ajax({
			url: 'php_action/fetchSelectedPerson.php',
			type: 'post',
			data: {personId : personId},
			dataType: 'json',
			success:function(response) {
				$("#clientRegistryNumber").val(response.person_registry_number);
			}
		})
	} else {
		$("#clientRegistryNumber").val("");
	}
}

// table total
function getTotal(row = null) {
	if(row) {
		var total = Number($("#priceValue"+row).val()) * Number($("#quantity"+row).val());
		total = total.toFixed(2);
		$("#total"+row).val(total);
		$("#totalValue"+row).val(total);
		
		subAmount();

	} else {
		alert('sem linha! favor recarregue a página');
	}
}

function subAmount() {
	var tableProductLength = $("#productTable tbody tr").length;
	var totalSubAmount = 0;
	for(x = 0; x < tableProductLength; x++) {
		var tr = $("#productTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);

		totalSubAmount = Number(totalSubAmount) + Number($("#total"+count).val());
	} // /for

	totalSubAmount = totalSubAmount.toFixed(2);

	// sub total
	$("#subTotal").val(totalSubAmount);
	$("#subTotalValue").val(totalSubAmount);


	// total amount
	var discount = $("#discount").val();
	if(discount) {
		var totalAmount = Number($("#subTotal").val()) - Number(discount);
		totalAmount = totalAmount.toFixed(2);
		$("#totalAmount").val(totalAmount);
		$("#quotationValue").val(totalAmount);
	} else {
		$("#totalAmount").val(totalSubAmount);
		$("#quotationValue").val(totalSubAmount);
	} // /else discount	
} // /sub total amount

function syncQuotationTotal() {
	$("#quotationValue").val($("#totalAmount").val());
}

function discountFunc() {
	var discount = $("#discount").val();
	if(discount) {
		var totalAmount = Number($("#subTotal").val()) - Number(discount);
		totalAmount = totalAmount.toFixed(2);
		$("#totalAmount").val(totalAmount);
		$("#quotationValue").val(totalAmount);
	} else {
		var totalAmount = Number($("#subTotal").val());
		$("#totalAmount").val(totalAmount);
		$("#quotationValue").val(totalAmount);
	} // /else discount	
} // /discount function


function resetQuotationForm() {
	// reset the input field
	$("#createQuotationForm")[0].reset();
	// remove remove text danger
	$(".text-danger").remove();
	// remove form group error 
	$(".form-group").removeClass('has-success').removeClass('has-error');
} // /reset quotation form


// remove quotation from server
function removeQuotation(quotationId = null) {
	if(quotationId) {
		$("#removeQuotationBtn").unbind('click').bind('click', function() {
			$("#removeQuotationBtn").button('loading');

			$.ajax({
				url: 'php_action/removeQuotation.php',
				type: 'post',
				data: {quotationId : quotationId},
				dataType: 'json',
				success:function(response) {
					$("#removeQuotationBtn").button('reset');

					if(response.success == true) {

						manageQuotationTable.ajax.reload(null, false);
						// hide modal
						$("#removeQuotationModal").modal('hide');
						// success messages
						$("#success-messages").html('<div class="alert alert-success">'+
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
						// error messages
						$(".removeQuotationMessages").html('<div class="alert alert-warning">'+
	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
	          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          
					} // /else

				} // /success
			});  // /ajax function to remove the quotation

		}); // /remove quotation button clicked
		

	} else {
		alert('erro! recarregue a página');
	}
}
// /remove quotation from server
