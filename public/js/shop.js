$(function(){
	var homepage = "http://shop"; 

	// add product
	$("#AddProd").submit(function () {
		var form_data = new FormData(this); 
		var form = $("#AddProd"); 
		// let user know, form submitted
	    Materialize.toast("Please wait, form's been submitted",2000);  
	    $(this).addClass("disabledbutton"); 
	    $(".progress").show(); 

		$.ajax({
			url: homepage + "/admin/add-prod",
			type: "POST",
			data: form_data,
			cache: false,
			processData: false,
			contentType: false,
			success: function(data){
				// parse json response
				data = $.parseJSON(data);
				if(data.status == "ok"){
					Materialize.toast("Product has successfully been added",2000,"",function () {
						location.href=homepage+"/admin"; 
					})
				}
				if(data.title){
					Materialize.toast("Field title must have min 4, max 200 symbols"); 
					$("#title").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.short){
					Materialize.toast("Field Short must have min 4, max 500 symbols"); 
					$("#short").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.description){
					Materialize.toast("Field Description must have min 4, max 1000 symbols"); 
					$("#description").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.price){
					Materialize.toast("Field Price must have min 1, max 10 digits"); 
					$("#price").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.rest){
					Materialize.toast("Field Rest must have min 1, max 10 digits"); 
					$("#rest").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.picture){
					Materialize.toast("Main picture must be PNG, JPG formats, and min 100px max 5000px"); 
					$("#picture").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.otherPics){
					Materialize.toast("Other pictures must be JPG,PNG formats, and min 100px max 5000px"); 
					$("#otherPics").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
			}
		})
		return false; 
	})

	// edit product save changes
	$("#EditProd").submit(function () {
		var form_data = new FormData(this); 
		var form = $("#EditProd"); 
		// let user know, form submitted
	    Materialize.toast("Please wait, form's been submitted",2000);  
	    $(this).addClass("disabledbutton"); 
	    $(".progress").show(); 
		
		$.ajax({
			url: homepage + "/admin/edit-prod/" +$(".product_id").val(),
			type: "POST",
			data: form_data,
			cache: false,
			processData: false,
			contentType: false,
			success:function(data){				
				// parse json response
				data = $.parseJSON(data);
				if(data.status == "ok"){
					Materialize.toast("Product has successfully been added",2000,"",function () {
						location.href=homepage+"/view/"+$(".product_id").val(); 
					})
				}
				if(data.title){
					Materialize.toast("Field title must have min 4, max 200 symbols"); 
					$("#title").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.short){
					Materialize.toast("Field Short must have min 4, max 500 symbols"); 
					$("#short").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.description){
					Materialize.toast("Field Description must have min 4, max 1000 symbols"); 
					$("#description").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.price){
					Materialize.toast("Field Price must have min 1, max 10 digits"); 
					$("#price").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.rest){
					Materialize.toast("Field Rest must have min 1, max 10 digits"); 
					$("#rest").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.picture){
					Materialize.toast("Main picture must be PNG, JPG formats, and min 100px max 5000px"); 
					$("#picture").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				if(data.otherPics){
					Materialize.toast("Other pictures must be JPG,PNG formats, and min 100px max 5000px"); 
					$("#otherPics").addClass("invalid"); 
					form.removeClass("disabledbutton");
					$(".progress").hide(); 
				}
				
			}

		})


		return false; s
	})
	// carousel
	$('.bxslider').bxSlider({
	  minSlides: 4,
	  maxSlides: 4,
	  slideWidth: 170,
	  slideMargin: 10,
	  infiniteLoop: false,
	  pager: false
	});

	// remove img from otherPics, located inside carousel in /admin/edit-prod/(id)
	$(".remove-prod,.remove-prod-carousel").click(function () {
		var img = $(this).data("img"); 
		var btn = $(this); 
		// alert(img); 
		$.ajax({
			url: homepage + "/admin/edit-prod/"+$(".product_id").val(),
			type: "POST",
			data: {img: img,remove: 1},
			success: function (data) {
				data = $.parseJSON(data);
				if(data.status == "ok"){
					Materialize.toast("Img has been deleted",4000); 
					if(data.mainImg){
						$(".remove-wrapper").addClass("disabledbutton"); 
					}
					else{
						btn.parent("a").parent("li").addClass("disabledbutton"); 
						
					}
				}
				if(data.status == "error"){
					Materialize.toast("Something went wrong, please try later",4000,"",function () {
						location.reload(); 
					}); 

				}
			}
		})
		return false; 
	})

	// relink when click btn span
	$(".edit-prod").click(function(){
		location.href=$(this).data("refer"); 
		return false; 
	})

	// remove product in /admin/edit-prod
	$(".remove-product").click(function(){
		// let user know, action is being done
		Materialize.toast("Product is being deleted, please wait",2000);

		// product id
		var id = $(this).data("id"); 
		$.ajax({
			url: homepage + "/admin/remove-prod/"+id,
			type: "POST",
			data: {id:id},
			success: function (data) {
				data = $.parseJSON(data);
				if(data.status == "ok"){
					Materialize.toast("Product has successfully been deleted",2000)
					$(".grid-item[data-id="+id+"]").addClass("disabledbutton");
				}
				if(data.status == "error"){
					Materialize.toast("Something went wrong, please try again",2000,"",function () {
						location.reload(); 
					})
				}						
			}
		})

		return false; 
	})



	// add category
	$("#AddCat").submit(function () {
		var form_data = new FormData(this); 
		// let user know, form's been submitted
		Materialize.toast("Form's been submitted, please wait",2000);
		var form = $(this); 
		var progress = $(".progress");
		form.addClass("disabledbutton");
		progress.show();
		$.ajax({
			url: homepage + "/admin/add-cat",
			type: "POST",
			data: form_data,
			cache: false,
			processData: false,
			contentType: false,
			success: function(data){
				data = $.parseJSON(data);
				if(data.status == "ok"){
					Materialize.toast("Category has successfully been added",2000,"",function () {
						location.href=homepage+"/admin";
					})
					
				}
				if(data.title){
					Materialize.toast("Field Title must have min 4 max 200 symbols",2000)
					$("#title").addClass("invalid");
					form.removeClass("disabledbutton");
					progress.hide();
				}
				if(data.picture){
					Materialize.toast("Img format must be JPG,PNG, and min 100px max 5000px (width,height)")
					$("#picture").addClass("invalid"); 
					form.removeClass("disabledbutton");
					progress.hide();
				} 
			}
		})
		return false; 
	})


	// add category
	$("#EditCat").submit(function () {
		var form_data = new FormData(this); 
		// let user know, form's been submitted
		Materialize.toast("Form's been submitted, please wait",2000);
		var form = $(this); 
		var progress = $(".progress");
		form.addClass("disabledbutton");
		progress.show();

		$.ajax({
			url: homepage + "/admin/edit-cat/"+$("input[name=cat_id]").val(),
			type: "POST",
			data: form_data,
			cache: false,
			processData: false,
			contentType: false,
			success: function(data){
				data = $.parseJSON(data);
				if(data.status == "ok"){
					Materialize.toast("Changes has successfully been saved",2000,"",function () {
						location.href=homepage+"/admin";
					})
					
				}
				if(data.title){
					Materialize.toast("Field Title must have min 4 max 200 symbols",2000)
					$("#title").addClass("invalid");
					form.removeClass("disabledbutton");
					progress.hide();
				}
				if(data.picture){
					Materialize.toast("Img format must be JPG,PNG, and min 100px max 5000px (width,height)")
					$("#picture").addClass("invalid"); 
					form.removeClass("disabledbutton");
					progress.hide();
				}
			}
		})
		return false; 
	})

	// remove category by AJAX /admin/

	$(".remove-cat").click(function(){
		var id = $(this).data("id");
		// let user know, form's been submitted
		Materialize.toast("Category is being deleted, please wait",2000);
		var form = $(this); 
		var progress = $(".progress");
		form.addClass("disabledbutton");
		progress.show(); 

		$.ajax({
			url: homepage + "/admin/remove-cat",
			type: "POST",
			data: {id:id},
			success: function(data){ 
				data = $.parseJSON(data);
				if(data.status == "ok"){
					Materialize.toast("Category has successfully been deleted",4000);
					$("tr[data-cat-id="+id+"]").addClass("disabledbutton"); 
				}
				if(data.status == "error"){
					Materialize.toast("Sorry, something went wrong, please try again",4000,"",function () {
						location.reload();
					});
					// $("tr[data-cat-id="+id+"]").addClass("disabledbutton"); 
				}
			}
		})
		return false;
	})


	// remove order /user/remove-order/(id)
	$(".remove-order").click(function () {
		var id = $(this).data("id");
		var btn = $(this);
		// let user know, order is being removed
		Materialize.toast("Order is being removed",2000);
		$.ajax({
			url: homepage+"/user/remove-order/"+id,
			type: "POST",
			data: {id:id},
			success: function (data) {
				data = $.parseJSON(data);
				if(data.status == "ok"){
					Materialize.toast("Order has successfully been removed",4000);
					btn.parent("td").parent("tr").addClass("disabledbutton") 
					// $("tr[data-cat-id="+id+"]").addClass("disabledbutton"); 
				}
				if(data.status == "error"){
					Materialize.toast("Sorry, something went wrong, please try again",4000,"",function () {
						location.reload();
					});
					// $("tr[data-cat-id="+id+"]").addClass("disabledbutton"); 
				}
			}
		})
	})










})