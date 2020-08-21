var manageProductTable;

$(document).ready(function() {
	// top nav bar 
	$('#navProduct').addClass('active');
	// manage product data table
	manageProductTable = $('#manageProductTable').DataTable({
		'ajax': 'php_action/fetchProduct.php',
		'order': []
	});

	// add product modal btn clicked
	$("#addProductModalBtn").unbind('click').bind('click', function() {
		// // product form reset
		$("#submitProductForm")[0].reset();		

		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		$("#productImage").fileinput({
	      overwriteInitial: true,
		    maxFileSize: 2500,
		    showClose: false,
		    showCaption: false,
		    browseLabel: '',
		    removeLabel: '',
		    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
		    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-1',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: '<img src="assests/images/photo_default.png" alt="Profile Image" style="width:100%;">',
		    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
	  		allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
		});

		// number mask for numeric fields
		$("#quantity").mask("000.000.000,000", {reverse: true});
		$("#quantityAlert").mask("000.000.000,000", {reverse: true});
		$("#productCost").mask("000.000.000,00", {reverse: true});
		$("#productPrice").mask("000.000.000,00", {reverse: true});

		$("#productType").change(function() {
			if ($('#productType').val() === '1') {
				$('#rawMaterial').attr('disabled', 'disabled');
				$('#rawMaterial').val('');
			} else {
				$('#rawMaterial').removeAttr('disabled');
			}
		});

		// submit product form
		$("#submitProductForm").unbind('submit').bind('submit', function() {

			// form validation
			var productImage = $("#productImage").val();
			var productName = $("#productName").val();
			var productType = $("#productType").val();
			var unitOfMeasure = $("#unitOfMeasure").val();
			var quantity = $("#quantity").val();
			var productPrice = $("#productPrice").val();
			var productStatus = $("#productStatus").val();
	
			if(productImage == "") {
				$("#productImage").closest('.center-block').after('<p class="text-danger">Imagem do produto é obrigatório</p>');
				$('#productImage').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productImage").find('.text-danger').remove();
				// success out for form 
				$("#productImage").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productName == "") {
				$("#productName").after('<p class="text-danger">Campo Nome do Produto é obrigatório</p>');
				$('#productName').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productName").find('.text-danger').remove();
				// success out for form 
				$("#productName").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productType == "") {
				$("#productType").after('<p class="text-danger">Campo Tipo do Produto é obrigatório</p>');
				$('#productType').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productType").find('.text-danger').remove();
				// success out for form 
				$("#productType").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(unitOfMeasure == "") {
				$("#unitOfMeasure").after('<p class="text-danger">Campo Unidade de medida é obrigatório</p>');
				$('#unitOfMeasure').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#unitOfMeasure").find('.text-danger').remove();
				// success out for form 
				$("#unitOfMeasure").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(quantity == "") {
				$("#quantity").after('<p class="text-danger">Campo Quantidade é obrigatório</p>');
				$('#quantity').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#quantity").find('.text-danger').remove();
				// success out for form 
				$("#quantity").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productPrice == "") {
				$("#productPrice").after('<p class="text-danger">Preço do produto é obrigatório</p>');
				$('#productPrice').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productPrice").find('.text-danger').remove();
				// success out for form 
				$("#productPrice").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productStatus == "") {
				$("#productStatus").after('<p class="text-danger">Campo Status do produto é obrigatório</p>');
				$('#productStatus').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productStatus").find('.text-danger').remove();
				// success out for form 
				$("#productStatus").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productImage && productName && productType && unitOfMeasure && quantity && productPrice && productStatus) {
				// submit loading button
				$("#createProductBtn").button('loading');

				// convert the numbers to the format accepted in the database
				$("#quantity").val(numberDBFormat($("#quantity").val()));
				$("#quantityAlert").val(numberDBFormat($("#quantityAlert").val()));
				$("#productCost").val(numberDBFormat($("#productCost").val()));
				$("#productPrice").val(numberDBFormat($("#productPrice").val()));

				var form = $(this);
				var formData = new FormData(this);

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: formData,
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					success:function(response) {

						if(response.success == true) {
							// submit loading button
							$("#createProductBtn").button('reset');
							
							$("#submitProductForm")[0].reset();

							$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																	
							// shows a successful message after operation
							$('#add-product-messages').html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');

							// remove the mesages
		          $(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert

		          // reload the manage student table
							manageProductTable.ajax.reload(null, true);

							// remove text-error 
							$(".text-danger").remove();
							// remove from-group error
							$(".form-group").removeClass('has-error').removeClass('has-success');

						} // /if response.success

						// convert back the numbers to the display format
						$("#quantity").val(numberDisplayFormat($("#quantity").val()));
						$("#quantityAlert").val(numberDisplayFormat($("#quantityAlert").val()));
						$("#productCost").val(numberDisplayFormat($("#productCost").val()));
						$("#productPrice").val(numberDisplayFormat($("#productPrice").val()));
						
					} // /success function
				}); // /ajax function
			}	 // /if validation is ok 					

			return false;
		}); // /submit product form

	}); // /add product modal btn clicked
	

	// remove product 	

}); // document.ready fucntion

function editProduct(productId = null) {

	if(productId) {
		$("#productId").remove();		
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		// modal spinner
		$('.div-loading').removeClass('div-hide');
		// modal div
		$('.div-result').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedProduct.php',
			type: 'post',
			data: {productId: productId},
			dataType: 'json',
			success:function(response) {		
			// alert(response.product_image);
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');				

				$("#getProductImage").attr('src', 'stock/'+response.product_image);

				$("#editProductImage").fileinput({		      
				});  

				// $("#editProductImage").fileinput({
		  //     overwriteInitial: true,
			 //    maxFileSize: 2500,
			 //    showClose: false,
			 //    showCaption: false,
			 //    browseLabel: '',
			 //    removeLabel: '',
			 //    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			 //    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			 //    removeTitle: 'Cancel or reset changes',
			 //    elErrorContainer: '#kv-avatar-errors-1',
			 //    msgErrorClass: 'alert alert-block alert-danger',
			 //    defaultPreviewContent: '<img src="stock/'+response.product_image+'" alt="Profile Image" style="width:100%;">',
			 //    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
		  // 		allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
				// });

				$("#editProductType").change(function() {
					if ($('#editProductType').val() === '1') {
						$('#editRawMaterial').attr('disabled', 'disabled');
						$('#editRawMaterial').val('');
					} else {
						$('#editRawMaterial').removeAttr('disabled');
					}
				});

				// convert number to display format
				const quantity = numberDisplayFormat(response.quantity, 3);
				const quantityAlert = numberDisplayFormat(response.quantity_alert, 3);
				const cost = numberDisplayFormat(response.product_cost, 2);
				const price = numberDisplayFormat(response.product_price, 2);

				// number mask for numeric fields
				$("#editQuantity").mask("000.000.000,000", {reverse: true});
				$("#editQuantityAlert").mask("000.000.000,000", {reverse: true});
				$("#editProductCost").mask("000.000.000,00", {reverse: true});
				$("#editProductPrice").mask("000.000.000,00", {reverse: true});

				// product id 
				$(".editProductFooter").append('<input type="hidden" name="productId" id="productId" value="'+response.product_id+'" />');				
				$(".editProductPhotoFooter").append('<input type="hidden" name="productId" id="productId" value="'+response.product_id+'" />');				
				
				// product code
				$("#editProductCode").val(response.product_code);
				// product name
				$("#editProductName").val(response.product_name);
				// product type
				$("#editProductType").val(response.product_type);
				// product raw material
				$("#editRawMaterial").val(response.raw_material);
				// product unit of measure
				$("#editUnitOfMeasure").val(response.unit_id);
				// quantity
				$("#editQuantity").val(quantity);
				// quantity alert
				$("#editQuantityAlert").val(quantityAlert);
				// product cost
				$("#editProductCost").val(cost);
				// product price
				$("#editProductPrice").val(price);
				// product description
				$("#editProductDescription").val(response.product_description);
				// tributary origin
				$("#editTributaryOrigin").val(response.tributary_origin);
				// tributary ncm
				$("#editTributaryNCM").val(response.tributary_ncm);
				// tributary cest
				$("#editTributaryCEST").val(response.tributary_cest);
				// tributary group
				$("#editTributaryGroup").val(response.tributary_group);
				// tributary benefit code
				$("#editTributaryBenefitCode").val(response.tributary_benefit_code);
				// status
				$("#editProductStatus").val(response.status);

				// check if product type is 1 to disable raw_material field
				if ($('#editProductType').val() === '1') {
					$('#editRawMaterial').attr('disabled', 'disabled');
					$('#editRawMaterial').val('');
				} else {
					$('#editRawMaterial').removeAttr('disabled');
				}

				// update the product data function
				$("#editProductForm").unbind('submit').bind('submit', function() {

					// form validation
					var productImage = $("#editProductImage").val();
					var productName = $("#editProductName").val();
					var productType = $("#editProductType").val();
					var unitOfMeasure = $("#editUnitOfMeasure").val();
					var quantity = $("#editQuantity").val();
					var productPrice = $("#editProductPrice").val();
					var productStatus = $("#editProductStatus").val();
								

					if(productName == "") {
						$("#editProductName").after('<p class="text-danger">Campo Nome do Produto é obrigatório</p>');
						$('#editProductName').closest('.form-group').addClass('has-error');
					}	else {
						// remove error text field
						$("#editProductName").find('.text-danger').remove();
						// success out for form 
						$("#editProductName").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(productType == "") {
						$("#editProductType").after('<p class="text-danger">Campo Tipo do Produto é obrigatório</p>');
						$('#editProductType').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductType").find('.text-danger').remove();
						// success out for form 
						$("#editProductType").closest('.form-group').addClass('has-success');	  	
					}	// /else
		
					if(unitOfMeasure == "") {
						$("#editUnitOfMeasure").after('<p class="text-danger">Campo Unidade de medida é obrigatório</p>');
						$('#editUnitOfMeasure').closest('.form-group').addClass('has-error');
					}	else {
						// remove error text field
						$("#editUnitOfMeasure").find('.text-danger').remove();
						// success out for form 
						$("#editUnitOfMeasure").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(quantity == "") {
						$("#editQuantity").after('<p class="text-danger">Campo Quantidade é obrigatório</p>');
						$('#editQuantity').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editQuantity").find('.text-danger').remove();
						// success out for form 
						$("#editQuantity").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(productPrice == "") {
						$("#editProductPrice").after('<p class="text-danger">Preço do produto é obrigatório</p>');
						$('#editProductPrice').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductPrice").find('.text-danger').remove();
						// success out for form 
						$("#editProductPrice").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(productStatus == "") {
						$("#editProductStatus").after('<p class="text-danger">Campo Status do produto é obrigatório</p>');
						$('#editProductStatus').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductStatus").find('.text-danger').remove();
						// success out for form 
						$("#editProductStatus").closest('.form-group').addClass('has-success');	  	
					}	// /else					

					if(productName && productType && unitOfMeasure && quantity && productPrice && productStatus) {
						// submit loading button
						$("#editProductBtn").button('loading');

						// convert back the numbers to the format accepted in the database
						$("#editQuantity").val(numberDBFormat($("#editQuantity").val()));
						$("#editQuantityAlert").val(numberDBFormat($("#editQuantityAlert").val()));
						$("#editProductCost").val(numberDBFormat($("#editProductCost").val()));
						$("#editProductPrice").val(numberDBFormat($("#editProductPrice").val()));

						var form = $(this);
						var formData = new FormData(this);

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: formData,
							dataType: 'json',
							cache: false,
							contentType: false,
							processData: false,
							success:function(response) {
								console.log(response);
								if(response.success == true) {
									// submit loading button
									$("#editProductBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-product-messages').html('<div class="alert alert-success">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

									// remove the messages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          // reload the manage student table
									manageProductTable.ajax.reload(null, true);

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

								} // /if response.success

								// convert back the numbers to the display format
								$("#editQuantity").val(numberDisplayFormat($("#editQuantity").val()));
								$("#editQuantityAlert").val(numberDisplayFormat($("#editQuantityAlert").val()));
								$("#editProductCost").val(numberDisplayFormat($("#editProductCost").val()));
								$("#editProductPrice").val(numberDisplayFormat($("#editProductPrice").val()));
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // update the product data function

				// update the product image				
				$("#updateProductImageForm").unbind('submit').bind('submit', function() {					
					// form validation
					var productImage = $("#editProductImage").val();					
					
					if(productImage == "") {
						$("#editProductImage").closest('.center-block').after('<p class="text-danger">Campo Imagem do produto é obrigatório</p>');
						$('#editProductImage').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductImage").find('.text-danger').remove();
						// success out for form 
						$("#editProductImage").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(productImage) {
						// submit loading button
						$("#editProductImageBtn").button('loading');

						var form = $(this);
						var formData = new FormData(this);

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: formData,
							dataType: 'json',
							cache: false,
							contentType: false,
							processData: false,
							success:function(response) {
								
								if(response.success == true) {
									// submit loading button
									$("#editProductImageBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-productPhoto-messages').html('<div class="alert alert-success">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

									// remove the mesages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          // reload the manage student table
									manageProductTable.ajax.reload(null, true);

									$(".fileinput-remove-button").click();

									$.ajax({
										url: 'php_action/fetchProductImageUrl.php?i='+productId,
										type: 'post',
										success:function(response) {
										$("#getProductImage").attr('src', response);		
										}
									});																		

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

								} // /if response.success
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // /update the product image

			} // /success function
		}); // /ajax to fetch product image

				
	} else {
		alert('erro, favor atualize a página');
	}
} // /edit product function

// remove product 
function removeProduct(productId = null) {
	if(productId) {
		// remove product button clicked
		$("#removeProductBtn").unbind('click').bind('click', function() {
			// loading remove button
			$("#removeProductBtn").button('loading');
			$.ajax({
				url: 'php_action/removeProduct.php',
				type: 'post',
				data: {productId: productId},
				dataType: 'json',
				success:function(response) {
					// loading remove button
					$("#removeProductBtn").button('reset');
					if(response.success == true) {
						// remove product modal
						$("#removeProductModal").modal('hide');

						// update the product table
						manageProductTable.ajax.reload(null, false);

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
						$(".removeProductMessages").html('<div class="alert alert-success">'+
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
			}); // /ajax function to remove the product
			return false;
		}); // /remove product btn clicked
	} // /if productid
} // /remove product function

function clearForm(oForm) {
	// var frm_elements = oForm.elements;									
	// console.log(frm_elements);
	// 	for(i=0;i<frm_elements.length;i++) {
	// 		field_type = frm_elements[i].type.toLowerCase();									
	// 		switch (field_type) {
	// 	    case "text":
	// 	    case "password":
	// 	    case "textarea":
	// 	    case "hidden":
	// 	    case "select-one":	    
	// 	      frm_elements[i].value = "";
	// 	      break;
	// 	    case "radio":
	// 	    case "checkbox":	    
	// 	      if (frm_elements[i].checked)
	// 	      {
	// 	          frm_elements[i].checked = false;
	// 	      }
	// 	      break;
	// 	    case "file": 
	// 	    	if(frm_elements[i].options) {
	// 	    		frm_elements[i].options= false;
	// 	    	}
	// 	    default:
	// 	        break;
	//     } // /switch
	// 	} // for
}