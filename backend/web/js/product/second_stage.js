
let modelProductImageFiles = $("#uploadproductimg-imagefiles");
modelProductImageFiles.change(function() {
    preloadingImg(this);
});

function preloadingImg(model){ //Предзагрузка изображений перед отправкой на сервер

    $('#gridImg .not_loaded_picture_box').remove();

    $.each(model.files, function(key) {

        $('#gridImg').append(
            "<div class='itemImg not_loaded_picture_box uploadImg_"+ key + "'>" +

                "<div class='blackout'>" +
                  "<div class='progress'>0%</div>" +
                "</div>" +

                "<a href='#' data-key='"+ key +"' class='delete_picture_box'>x</a>"+

            "</div>");

        let reader = new FileReader();

        reader.onload = function(e) {
            $('#gridImg .uploadImg_' + key).append("<img src='"+e.target.result+"' alt='Ошибка'>");
        }

        reader.readAsDataURL(this);

    });
    let modelCancelUploadImg =  $("#gridImg .not_loaded_picture_box .delete_picture_box");
    modelCancelUploadImg.off(); //Отписаться от всех событий
    modelCancelUploadImg.on('click', cancelUploadImg);

    $("#btn_send_form_upload_img").click();

}

$('#form-upload-img').on('beforeSubmit', function uploadImg(e){

    let tmpFormData = new FormData($(this)[0]);

    let formData = new FormData();

    let token_key;
    let token_value;

        let i = 0;
    for(let pair of tmpFormData.entries()){
        if(i++ === 0){
            token_key = pair[0];
            token_value = pair[1];
        }else
            if(pair[1] !== ""){
                formData.append(pair[0], pair[1]);
            }
    }

  sendFormUploadImg(this, formData, token_key, token_value, 0);

    return false;
});


function sendFormUploadImg(form, intermediateFormData, token_key, token_value, idx){
    let formDataSend = new FormData();
    let newIntermediateFormData = new FormData();

    formDataSend.append(token_key, token_value);

    let i = 0;
    for(let pair of intermediateFormData.entries()){
        if(i++ === 0){
            formDataSend.append(pair[0], pair[1]);
        }else{
            newIntermediateFormData.append(pair[0], pair[1]);
        }
    }


    $(".uploadImg_"+ idx).removeClass("not_loaded_picture_box");
    $(".uploadImg_"+ idx + " .delete_picture_box").off(); //Отписаться от всех событий

    $.ajax({
        xhr: function() {
            let xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    let percentComplete = evt.loaded / evt.total;
                    percentComplete = percentComplete * 100;
                     $(".uploadImg_"+ idx +" .blackout .progress").text(percentComplete + "%");

                    if (percentComplete === 100) {
                       $(".uploadImg_"+ idx +" .blackout").remove();
                        $(".uploadImg_"+ idx + " .delete_picture_box").on('click', deleteImg);
                    }
                }
            }, false);
            return xhr;
        },
        url: form.action,
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        data: formDataSend,
        dataType: "json",
        error: function (){
            alert("Ошибка при отправке данных на сервер.");
        }
    }).done(function(e) { // добавляем обработчик при успешном выполнении запроса

         if(e['result'] === 'success'){
             $(".uploadImg_"+ idx).addClass("uploaded_picture_box");
             $(".uploadImg_"+ idx + " .delete_picture_box")
                 .attr("data-filename", e['filename'])
                 .attr("data-id", $("#gridImg").data('id'));
         }else{
             console.log(e);
         }

        if(Array.from(newIntermediateFormData.keys()).length > 0){
            sendFormUploadImg(form, newIntermediateFormData, token_key, token_value, idx + 1);
        }

    });
}

function cancelUploadImg(){

    let key = parseInt($(this).data('key'));

    let model =  modelProductImageFiles;
    let files = model[0].files;

    let dt = new DataTransfer();

     let len = files.length;

     for(let i = 0; i < len; i++){
            if(i !== key){
                dt.items.add(files[i]);
            }
    }
    model[0].files = dt.files;
    preloadingImg(model[0]);
    return false;
}

$("#gridImg .uploaded_picture_box .delete_picture_box").on('click', deleteImg);

function deleteImg(){
    let model = $(this);
    let id = $(this).data('id');
    let filename = $(this).data('filename');
    $("#commonMessageUploadImg").text("");
    $.ajax({
        url: "/admin/product/delete-img",
        method: 'post',
        dataType: 'json',
        data:  { id : id, filename : filename },
        success: function(response){
            if(response['result'] === 'success'){
                model.parent().append("<div class='curtainDeleted'>Удалено</div>");
                model.remove();

            }else if(response['result'] === 'error'){

                let isShowError = false; //Булева переменная, что-бы отслеживать что мы точно что-то отоброзили в качестве ошибки

                $.each(response["errors"], function (key, value) {
                    isShowError = true;

                    let model = $(".field-uploadproductimg-" + key);

                    if(model.length){
                        let input =  $(".field-uploadproductimg-" + key + ' input');

                        input.removeClass("is-valid");
                        input.addClass("is-invalid");

                        let boxError = $(".field-uploadproductimg-" + key + " .invalid-feedback");
                        $.each(value, function (_, message) {
                            boxError.append(message + "<br>");
                        });
                    }else{
                        $("#commonMessageUploadImg").append(key + ": " + value + "<br>");
                    }

                });

                if(!isShowError){ //Если сообщение об ошибке сервер не передал
                    $("#commonMessageUploadImg").append("Неизвестная ошибка сервера, сервер об этом ничего не сказал!");
                }

            }else{
                $("#commonMessageUploadImg").append("Неизвестная ошибка сервера. " + response.toString());
            }
        },
        error: function(){
            alert("Ошибка отправки данных");
        }
    });


    return false;
}




