
$(".methodSelectionLogin a").on('click', function(e){
    if(!$(this).hasClass('active')){ //Если кнопка не активна, что-бы не делать повторных вещей если нажать нескольео раз
        $(".methodSelectionLogin a").removeClass('active'); //Удаляем активную
        $(this).addClass('active'); //Делаем текущую активной
        let name = $(this).data('btn');  //Получаем название поля с которым нужно выполнить действие


        $("#login-form input").removeClass('is-valid').removeClass('is-invalid').val(""); //Убираем маркера указывающие на ошибку
        $("#login-form .help-block").text(''); //Очищаем ощибки

        $("#login-form .blockFields input").attr("disabled", "disabled");
         $("#login-form .blockFields #loginform-" + name).removeAttr('disabled');

        $("#login-form .blockFields .field_block").css('display', 'none');

        $("#login-form .blockFields  .field-loginform-" + name).css('display', 'block');

    }
    return false;

});


$("#login-form").on('beforeSubmit', function(e){
    return false;
});


$("#login-form").on('beforeSubmit', function(e){
    ShowLoadingAnimation();

    $(".errorBigMessage").text("").css("display", "none");
    $("#login-form input").removeClass('is-valid').removeClass('is-invalid'); //Убираем маркера указывающие на ошибку
    $("#login-form .help-block").text(''); //Очищаем ощибки

    $.ajax({
        url:     '/auth/login', //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $(this).serialize(),  // Сеарилизуем объект
        success: function(response) {

            HideLoadingAnimation();
            //Данные отправлены успешно
            let result = $.parseJSON(response);
            console.log(result.result);
            console.log(result['errors']);
            console.log(result);

            if(result["result"] === 'success'){

             window.location.replace(result['referrer'] ?? "/");

            }else if(result["result"] === "error"){

                $.each(result["errors"],function(key,data) {
                    if(key === "email" || key === "phone" || key === "password"){
                        $("#loginform-" + key).addClass("is-invalid").attr('aria-invalid', 'true');
                        $(".field-loginform-" + key + " .invalid-feedback").text(data);
                    }
                   else{
                        $(".centerBlockForm #bigErrorMessage").text(data);
                    }
                });
            }else{
                $(".centerBlockForm #bigErrorMessage").text("На сервере что-то пошло не так, мы уже с этим разбираемся.");
            }

        },
        error: function() { // Данные не отправлены
            $(".centerBlockForm #errorBigMessage").text("Ошибка, попрубуйте перезагрузить страницу.");
        }
    });
    return false;
});


