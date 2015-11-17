var link_p = 'http://projeto.cesar/';
//var link_p = 'http://gestor.cesartsi.com/';

function enviarImagemBanner(){

    var url_total = window.location.href;
    $('#formulario').ajaxForm({
        beforeSend: function() {
            $('#loading').fadeIn();
        },
        dataType: 'json',
        success: function(data) {
            if(data === 0){
                $("#limpa_imagem").each(function () {
                    $(this).val("");
                });
                swal({
                    title: "Atenção! Envie arquivos com as seguintes extensões: jpg, png ou jpeg ",
                    text: '',
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#aedef4",
                    confirmButtonText: "OK",
                    closeOnConfirm: false,
                    closeOnCancel: false
                });
                $('#loading').fadeOut();
            }else if(data == 1){
                $("#limpa_imagem").each(function () {
                    $(this).val("");
                });
                swal({
                    title: "Atenção! A imagem não foi arquivada. ",
                    text: '',
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#aedef4",
                    confirmButtonText: "OK",
                    closeOnConfirm: false,
                    closeOnCancel: false
                });
                $('#loading').fadeOut();
            }else {
                $(data).each(function (index, value) {
                    if (data) {
                        $('#galery-imagens-banner').append('<div class="div-image-pai"><input type="hidden" name="urls[]" value="'+value+'" />\n\
                            <div style="float: right"><input type="radio" id="radio" onclick="alterarRadio(\''+value+'\');" name="radios[]" value="'+value+'" checked  />Foto Principal</div> \n\
                            <div class="width-image" style="background-image: url(' + link_p + 'uploads/banner/' + value + ' )">\n\
                              <a class="fechar_imagem" data-value="' + value + '" onclick="limpar_foto(this)">[X]</a>\n\
                            </div>\n\
                            </div>');
                        $('#loading').fadeOut();
                    } else {
                        alert('Não gravou.');
                    }
                });
            }
        }
    }).submit();

}

function limpar_foto(objeto){
    var hash = window.location.hash;
    var url_total = window.location.href;
    var url = url_total.replace(link_p, '');
    var url_final = url.replace('/'+hash, '');

    $.ajax({
        beforeSend: function() {
            $('#loading').fadeIn();
        },
        url:url_final+'/deletarimagem',
        data: "id_imagem="+$(objeto).data('value'),
        type: "POST",
        success:function(data){
            if(data){
                $(objeto).parent().parent().remove();
                swal({
                    title: "Imagem deletada com sucesso!",
                    text: '',
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#aedef4",
                    confirmButtonText: "OK",
                    closeOnConfirm: false,
                    closeOnCancel: false
                });
                $('#loading').fadeOut();
                $("#limpa_imagem").each(function () {
                    $(this).val("");
                });
            }
        }
    });
}

function alterarRadio(radio){
    var hash = window.location.hash;
    var url_total = window.location.href;
    var url = url_total.replace(link_p, '');
    var url_final = url.replace('/'+hash, '');

    $.ajax({
        url:url_final+'/alterarRad',
        type:'GET',
        data:{
            rd:radio
        }
    });

}

function enviarImagemNoticia(){

    var url_total = window.location.href;
    $('#formulario').ajaxForm({
        beforeSend: function() {
            $('#loading').fadeIn();
        },
        dataType: 'json',
        success: function(data) {
            if(data === 0){
                $("#limpa_imagem").each(function () {
                    $(this).val("");
                });
                swal({
                    title: "Atenção! Envie arquivos com as seguintes extensões: jpg, png ou jpeg ",
                    text: '',
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#aedef4",
                    confirmButtonText: "OK",
                    closeOnConfirm: false,
                    closeOnCancel: false
                });
                $('#loading').fadeOut();
            }else if(data == 1){
                $("#limpa_imagem").each(function () {
                    $(this).val("");
                });
                swal({
                    title: "Atenção! A imagem não foi arquivada. ",
                    text: '',
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#aedef4",
                    confirmButtonText: "OK",
                    closeOnConfirm: false,
                    closeOnCancel: false
                });
                $('#loading').fadeOut();
            }else {
                $(data).each(function (index, value) {
                    if (data) {
                        $('#galery-imagens-banner').append('<div class="div-image-pai"><input type="hidden" name="urls[]" value="'+value+'" />\n\
                            <div style="float: right"><input type="radio" id="radio" onclick="alterarRadio(\''+value+'\');" name="radios[]" value="'+value+'" checked  />Foto Principal</div> \n\
                            <div class="width-image" style="background-image: url(' + link_p + 'uploads/noticias/' + value + ' )">\n\
                              <a class="fechar_imagem" data-value="' + value + '" onclick="limpar_foto(this)">[X]</a>\n\
                            </div>\n\
                            </div>');
                        $('#loading').fadeOut();
                    } else {
                        alert('Não gravou.');
                    }
                });
            }
        }
    }).submit();

}

function enviarImagemSobre(){

    var url_total = window.location.href;
    $('#formulario').ajaxForm({
        beforeSend: function() {
            $('#loading').fadeIn();
        },
        dataType: 'json',
        success: function(data) {
            if(data === 0){
                $("#limpa_imagem").each(function () {
                    $(this).val("");
                });
                swal({
                    title: "Atenção! Envie arquivos com as seguintes extensões: jpg, png ou jpeg ",
                    text: '',
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#aedef4",
                    confirmButtonText: "OK",
                    closeOnConfirm: false,
                    closeOnCancel: false
                });
                $('#loading').fadeOut();
            }else if(data == 1){
                $("#limpa_imagem").each(function () {
                    $(this).val("");
                });
                swal({
                    title: "Atenção! A imagem não foi arquivada. ",
                    text: '',
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#aedef4",
                    confirmButtonText: "OK",
                    closeOnConfirm: false,
                    closeOnCancel: false
                });
                $('#loading').fadeOut();
            }else {
                $(data).each(function (index, value) {
                    if (data) {
                        $('#galery-imagens-banner').append('<div class="div-image-pai"><input type="hidden" name="urls[]" value="'+value+'" />\n\
                            <div style="float: right"><input type="radio" id="radio" onclick="alterarRadio(\''+value+'\');" name="radios[]" value="'+value+'" checked  />Foto Principal</div> \n\
                            <div class="width-image" style="background-image: url(' + link_p + 'uploads/sobre/' + value + ' )">\n\
                              <a class="fechar_imagem" data-value="' + value + '" onclick="limpar_foto(this)">[X]</a>\n\
                            </div>\n\
                            </div>');
                        $('#loading').fadeOut();
                    } else {
                        alert('Não gravou.');
                    }
                });
            }
        }
    }).submit();

}