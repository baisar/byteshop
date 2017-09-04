$(function () {
  var homepage = "http://shop"; 
  
  $(".grid").masonry(); 

  $(window).on("load",function(){
    $(".grid").masonry();     
  })


  $(".add_to_cart").click(function(){
  	alert("BEKS")
  })

  // signup
  $("#Register").submit(function(){
    // let user know, form submitted
    Materialize.toast("Please wait",2000); 
    $(this).addClass("disabledbutton"); 
    $(".progress").show(); 

  	var form_data = new FormData(this); 

  	$.ajax({
  		url: homepage + "/user/signup",
  		type: "POST",
  		data: form_data,
  		cache: false,
  		contentType: false,
  		processData: false,
  		success: function (data) {
        console.log(data); 
        // parse JSON response
        data = $.parseJSON(data); 

        if(data.status == "ok"){
          Materialize.toast("You have successfully been registered",3000,"",function () {
            location.reload(); 
          }); 
        }
        if(data.nick){
          Materialize.toast("Field nick should have min 4 and max 20 symbols"); 
          $("#nick").addClass("invalid"); 
          $("#Register").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
        if(data.email){
          Materialize.toast("Wrong email address type or email address is already being used");  
          $("#email").addClass("invalid"); 
          $("#Register").removeClass("disabledbutton"); 
          $(".progress").hide(); 

        }
        if(data.pass){
          Materialize.toast("Password must contain min 4, max 20 symbols"); 
          $("#pass").addClass("invalid"); 
          $("#Register").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
        if(data.rpass){
          Materialize.toast("2 password fields dont match"); 
          $("#pass").addClass("invalid"); 
          $("#rpass").addClass("invalid"); 
          $("#Register").removeClass("disabledbutton"); 
          $(".progress").hide(); 

        }
  		}
  	})


  	return false; 
  })


  $("#slider").flexslider(); 
  $('select').material_select();

  /* Signin */
  $("#Signin").submit(function () {
    // let user know, form submitted
    Materialize.toast("Please wait",2000);  
    $(this).addClass("disabledbutton"); 
    $(".progress").show(); 
    var form_data = new FormData(this); 

    $.ajax({
      url: homepage + "/user/signin",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data); 
        // parse JSON response
        data = $.parseJSON(data); 

        if(data.status == "ok"){
          Materialize.toast("You have entered",2000,"",function () {
            if(data.checkbox){
              location.href=homepage+"/user?cookie=1"; 
            }
            else{
              location.href=homepage+"/user";             
            }            
          }); 
        }
        if(data.email){
          Materialize.toast("Wrong email address type"); 
          $("#email").addClass("invalid"); 
          $("#Signin").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
        if(data.pass){
          Materialize.toast("Password must have min 4,max 20 symbols");
          $("#pass").addClass("invalid"); 
          $("#Signin").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
        if(data.status == "error"){
          Materialize.toast("Wrong user data");
          $("#email,#pass").addClass("invalid"); 
          $("#Signin").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
      }
    })



    return false; 
  })


  // add to cart
  $(".add-to-cart-btn").click(function(){
    // get prod_id
    var product_id = $(this).data("prod-id"); 
    // disabled button
    $(this).addClass("disabledbutton");

    // ajax request in order to insert prod_id to cart session
    $.ajax({
      url: homepage + "/add-to-cart",
      type: "POST",
      data: {id: product_id},
      success: function(data){
        console.log(data); 
        data = $.parseJSON(data); 
        if(data.status == "ok"){
          Materialize.toast("Product's been added to cart",4000); 
        }
        if(data.status == "error"){
          Materialize.toast("Something went wrong, please try again later, or contact the admin",4000); 
        }
        // set total amount of items in the cart,
        //
        if(data.totalItems){
          if($(".cartItems").length > 0){
            $(".cartItems").text(data.totalItems)
          }
          else{
            $(".countContainer").html('<span class="badge cartItems">'+data.totalItems+"</span>");
          }
        }
      }
    })
  })
  // remove product from cart
  $(".remove").click(function(){
    var id = $(this).data("remove"); 
    // ajax request in order to insert prod_id to cart session
    $.ajax({
      url: homepage + "/remove-product-from-cart",
      type: "POST",
      data: {id: $(this).data("remove")},
      success: function(data){
        // console.log(data);  
        data = $.parseJSON(data); 
        if(data.status == "ok"){
          Materialize.toast("Product was deleted from cart",2000,"",function(){
            location.reload(); 
          }); 
          $("tr[data-id="+id+"]").css({"opacity" : .5}); 
        }
        if(data.status == "error"){
          Materialize.toast("Something went wrong, please try again later, or contact the admin",4000); 
        }
      }
    })
  })
  // remove all products from cart
  $(".removeAll").click(function(){
    var id = $(this).data("remove"); 
    // ajax request in order to insert prod_id to cart session
    $.ajax({
      url: homepage + "/remove-product-from-cart",
      type: "POST",
      data: {removeAll: 1},
      success: function(data){
        // console.log(data);  
        data = $.parseJSON(data); 
        if(data.status == "ok"){
          Materialize.toast("Products were deleted from cart",2000,"",function(){
            location.reload(); 
          }); 
          $("tr").css({"opacity" : .5}); 
        }
        if(data.status == "error"){
          Materialize.toast("Something went wrong, please try again later, or contact the admin",4000); 
        }
      }
    })
  })

  // checkout
  $("#Checkout").submit(function(){
    // let user know, form submitted
    Materialize.toast("Please wait",2000); 
    $("#Checkout").addClass("disabledbutton"); 
    $(".progress").show(); 

    var form_data  = new FormData(this); 
    form_data.append("checkout",1); 

    $.ajax({
      url: homepage + "/checkout",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        console.log(data); 
        data = $.parseJSON(data); 
        if(data.status == "ok"){
          Materialize.toast("You have sucessfully ordered, admin will contact you as soon as possible",5000,"",function(){
            location.href=homepage; 
          }); 

        }
        if(data.name){
          Materialize.toast("Field name must contain min 4, max 20 symbols"); 
          $("#name").addClass("invalid"); 
          $("#Checkout").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
        if(data.cell){
          Materialize.toast("Field cell must contain 9 digits"); 
          $("#cell").addClass("invalid"); 
          $("#Checkout").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
        if(data.email){
          Materialize.toast("Wrong email address type"); 
          $("#email").addClass("invalid"); 
          $("#Checkout").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
        if(data.address){
          Materialize.toast("Field address must contain min 4, max 100 symbols"); 
          $("#address").addClass("invalid"); 
          $("#Checkout").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
        if(data.comment){
          Materialize.toast("Field comment must contain min 4, max 200 symbols"); 
          $("#comments").addClass("invalid"); 
          $("#Checkout").removeClass("disabledbutton"); 
          $(".progress").hide(); 
        }
      }
    })
    return false; 
  })
  /* EditForm */
  $("#Edit").submit(function(){
    // let user know, form's been submitted
    Materialize.toast("Form has been submitted, please wait",2000); 
    $("#Edit").addClass("disabledbutton"); 
    $(".progress").show();  

    var form_data  = new FormData(this); 
    
    $.ajax({
      url: homepage + "/user/edit",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        data = $.parseJSON(data); 
        if(data.status == "ok"){
          Materialize.toast("All changes have been saved",2000,"",function(){
            location.href=homepage + "/user"; 
          }); 
        }
        if(data.nick){
          Materialize.toast("Field Nick must contain min 4, max 20 symbols"); 
          $("#nick").addClass("invalid"); 
          $("#Edit").removeClass("disabledbutton"); 
          $(".progress").hide();  
        }
        if(data.cell){
          Materialize.toast("Field cell must contain 9 digits"); 
          $("#cell").addClass("invalid"); 
          $("#Edit").removeClass("disabledbutton"); 
          $(".progress").hide();  
        }
        if(data.email){
          Materialize.toast("Wrong email address type"); 
          $("#email").addClass("invalid"); 
          $("#Edit").removeClass("disabledbutton"); 
          $(".progress").hide();  
        }
      }
    })
    return false; 
  })

  // upload avatar img
  $("#avaForm").submit(function (e) {
    // let user know, form submitted
    Materialize.toast("Image is being uploaded, it usually takes less than a minute"); 
    $("#avaForm,label[for=avatar]").addClass("disabledbutton"); 
    var form_data = new FormData(this); 
    form_data.append("ava",1); 
    $.ajax({
      url: homepage + "/user/edit",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        console.log(data); 
        data = $.parseJSON(data); 
        if(data.status == "ok"){
          Materialize.toast("Img has sucessfully been added",2000,"",function(){
            location.href=homepage + "/user/crop"; 
          }); 
        }
        if(data.avatar){
          Materialize.toast("Upload img must be (minWith 100px x minHeight 100px, maxWidth 5000px x maxHeight 5000px)"); 
          $("#avaForm,label[for=avatar]").removeClass("disabledbutton"); 

        }
      }
    })
  return false; 
  })
  
  // CROP USER AVA IMG
  $("#cropImg").submit(function (e) {
    // Cropped img data's been send, please wait
    Materialize.toast("Cropped img data's been send, please wait",2000); 
    var form_data = new FormData(this); 
    form_data.append("ava",1); 
    form_data.append("imgWidth",$("#crop").width()); 
    form_data.append("imgHeight",$("#crop").height()); 
    $.ajax({
      url: homepage + "/user/crop",
      type: "POST",
      data: form_data,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        console.log(data); 
        data = $.parseJSON(data); 
        if(data.status == "ok"){
          Materialize.toast("Img has been cropped",2000,"",function(){
            location.href=homepage + "/user"; 
          }); 
        }
        if(data.avatar){
          Materialize.toast("Upload img must be (minWith 100px x minHeight 100px, maxWidth 5000px x maxHeight 5000px)"); 
        }
      }
    })
  return false; 
  })

  $('#crop').imgAreaSelect({ 
      maxWidth: 500,
      minWidth: 100,
      maxHeight: 500,
      minHeight: 100,
      aspectRatio: "4:4", 
      handles: true,
      onSelectEnd: function (img, selection) {
          $('input[name="x1"]').val(selection.x1);
          $('input[name="y1"]').val(selection.y1);
          $('input[name="x2"]').val(selection.x2);
          $('input[name="y2"]').val(selection.y2); 
          $('input[name="breite"]').val(selection.width);
          $('input[name="hohe"]').val(selection.height);

      }
      //
  });

  // make smaller nav if scrollTop more than 100px
  var $window = $(window); 
  $window.scroll(function(){
    if($window.scrollTop() >= 100){
      $("header").addClass("header");
    }
    else{
      $("header").removeClass("header")
    }
    
  })




})