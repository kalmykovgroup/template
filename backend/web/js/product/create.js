

 $("#form-create-product").on('beforeSubmit', function(e){
     $("#commonMessageFirstStage").text("");
     $.ajax({
         url: this.action,
         method: 'post',
         dataType: 'json',
         data: $(this).serialize(),
         success: function(response){
             console.log(response);

             if(response['result'] === 'success'){

                 window.location.replace("/admin/product/update?id=" + response['id']);

             }else if(response['result'] === 'error'){

                 let isShowError = false; //Булева переменная, что-бы отслеживать что мы точно что-то отоброзили в качестве ошибки

                 $.each(response["errors"], function (key, value) {
                     isShowError = true;

                     let model = $(".field-product-" + key);

                     if(model.length){
                         let input =  $(".field-product-" + key + ' input');
                             input.removeClass("is-valid");
                             input.addClass("is-invalid");

                         let boxError = $(".field-product-" + key + " .invalid-feedback");
                         $.each(value, function (_, message) {
                             boxError.append(message + "<br>");

                         });
                     }else{
                         model =  $(".field-productinfo-" + key);

                         if(model.length){
                             let input =  $(".field-productinfo-" + key + ' input');
                             input.removeClass("is-valid");
                             input.addClass("is-invalid");

                             let boxError = $(".field-productinfo-" + key + " .invalid-feedback");

                             $.each(value, function (_, message) {
                                 boxError.append(message + "<br>");
                             });
                         }else
                             $("#commonMessageFirstStage").append(key + ": " + value + "<br>");
                     }

                     if(response["errors"]['category_id']){ //Скрытая поле, делаем дополнительную проверку
                         $("#commonMessageFirstStage").append(response["errors"]['category_id'] + "<br>");
                     }

                 });

                 if(!isShowError){ //Если сообщение об ошибке сервер не передал
                     $("#commonMessageFirstStage").append("Неизвестная ошибка сервера, сервер об этом ничего не сказал!");
                 }

             }else{
                 $("#commonMessageFirstStage").append("Неизвестная ошибка сервера. " + response.toString());
             }
         },
         error: function(){
             alert("Ошибка отправки данных");
         }
     });
     return false;
 });


 $( "#blockSelectCategory .category" )
     .on('click', function(){
         let id = $(this).data('id');
         $("#product-category_id").val(id);
         $("#wrapperBlockSelectCategory").css("display", "none");
         $("#product-search_category").val($(this).text());
 });


 let flagSelectCategory = false;
 $( "#blockSelectCategory" ).on( "mouseover", function() {
     flagSelectCategory = true;
 }).on("mouseout", function(){
     flagSelectCategory = false;
 });

 $('#product-search_category').focus(function(){$("#wrapperBlockSelectCategory").css("display", "block"); })
     .blur(function(){
            if(flagSelectCategory === false){
                $("#wrapperBlockSelectCategory").css("display", "none");
                $("#product-search_category").val("");
            }
     });

 $(".unit_of_measurement").on("change", function(){
    $("#product-unit").val($(this).val()).removeClass("is-invalid").addClass("is-valid");
    $(".field-product-unit .invalid-feedback ").val("");

 });

//Экзотика
 $(".plus_5").on('click', function (){
     let value1 =  parseInt($("#product-price").val());
     let value2 =  parseInt($("#product-old_price").val());
     let value = value2 > 0 ? value2 : value1;
     let result = parseInt(value / 100 * 5);
     if(result)
         $("#product-old_price").val(value + result);
     return false;
 });

 $(".minus_5").on('click', function (){
     let value1 =  parseInt($("#product-price").val());
     let value2 =  parseInt($("#product-old_price").val());
     let value = value2 > 0 ? value2 : value1;
     let result = parseInt(value / 100 * 5);
     if(result)
         $("#product-old_price").val(value - result);
     return false;
 });



