
var hash = window.location.hash;
var url_total = window.location.href;
var url = url_total.replace('http://projeto.cesar/', '');
var link_p = 'http://projeto.cesar/';

if(hash === ''){
    var link_s = 'http://projeto.cesar/'+url+'#consulta';
    var link_t = 'http://projeto.cesar/'+url+'#cadastro';
}else{
    var link_s = 'http://projeto.cesar/'+url;
    var link_t = 'http://projeto.cesar/'+url;
}


$(document).ready(function(){

    var hash = window.location.hash;
    var url_total = window.location.href;
    var url = url_total.replace(link_p, '');
    var url_final = url.replace(hash , '');

    if(hash != '') {
        $('.abas li a[href="'+url_final+'' + hash + '"]').parent().addClass('ativo');
        if(hash ===  '#consulta'){
            $('#cadastro').hide();
            $('#consulta').show();

        }else if(hash === '#cadastro'){
            $('#consulta').hide();
            $('#cadastro').show();
        }
    } else {
        $('.abas li a[href="'+url_final+'#cadastro"]').parent().addClass('ativo');
    }

    $('.abas li .link').click(function(){

        $('.abas li').removeClass('ativo');
        $(this).parent().addClass('ativo');

        if(hash === ''){

            var ancora = $(this).attr('href').replace(url_final, '');

                if(ancora ===  '#consulta'){
                    $('#cadastro').hide();
                    $('#consulta').show();

                }else if(ancora === '#cadastro'){
                    $('#consulta').hide();
                    $('#cadastro').show();

                }else if(ancora ===  '/#consulta'){
                     location.href= link_s;
                } else if(ancora === '/#cadastro'){
                    location.href= link_t;
                }
        }else{

            var ancora = $(this).attr('href').replace(url_final, '');

            if(ancora ===  '#consulta'){
                $('#cadastro').hide();
                $('#consulta').show();

            }else if(ancora === '#cadastro'){
                $('#consulta').hide();
                $('#cadastro').show();

            }
        }

    });

});


    function gravar_cadastro(codigo){
        var hash = window.location.hash;
        var url_total = window.location.href;
        var url = url_total.replace(link_p, '');
        var url_final = url.replace('/'+hash, '');
        tinyMCE.triggerSave();
        $.ajax({
            url: url_final+'/cadastrar',
            type:'POST',
            data: $('#formulario').serialize(),
            success: function(data){
                //alert(data);
               if(data === '1'){
                   swal({
                       title: "Cadastrado com sucesso!",
                       text: '',
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#aedef4",
                       confirmButtonText: "OK",
                       closeOnConfirm: false,
                       closeOnCancel: false
                   });
                   document.getElementById("formulario").reset();
                   document.getElementById("galery-imagens-banner").innerHTML="";
               }else if(data === '2') {
                   document.getElementById("formulario").reset();
                   $("#codigo").each(function () {
                       $(this).val("");
                   });
                   swal({
                       title: "Alterado com sucesso!",
                       text: '',
                       type: "success",
                       showCancelButton: false,
                       confirmButtonColor: "#aedef4",
                       confirmButtonText: "OK",
                       closeOnConfirm: false,
                       closeOnCancel: false
                   });
                   document.getElementById("galery-imagens-banner").innerHTML = "";
               }else if(data === '26'){
                   swal({
                       title: "Atenção! Este usuário já existe. ",
                       text: '',
                       type: "error",
                       showCancelButton: false,
                       confirmButtonColor: "#aedef4",
                       confirmButtonText: "OK",
                       closeOnConfirm: false,
                       closeOnCancel: false
                   });
               }else if(data === '23'){
                   swal({
                       title: "Atenção! Já esta cadastrada essa opção. ",
                       text: '',
                       type: "error",
                       showCancelButton: false,
                       confirmButtonColor: "#aedef4",
                       confirmButtonText: "OK",
                       closeOnConfirm: false,
                       closeOnCancel: false
                   });
               }else{
                    swal({
                        title: "Atenção! " + data,
                        text: '',
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#aedef4",
                        confirmButtonText: "OK",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    });
                }
            }
        });
    }

    function listagem(opcao, codigo) {
        var hash = window.location.hash;
        var url_total = window.location.href;
        var url = url_total.replace(link_p, '');
        var url_final = url.replace('/' + hash, '');

        if ($('.mostrar_dados').text() >= '1' && opcao == '0') {
            swal({
                title: "Atenção! Para buscar tudo novamente clique em [Atualizar] ",
                text: '',
                type: "error",
                showCancelButton: false,
                confirmButtonColor: "#aedef4",
                confirmButtonText: "OK",
                closeOnConfirm: false,
                closeOnCancel: false
            });
        }else {
            $.ajax({
                beforeSend: function() {
                    $('#loading2').fadeIn();
                },
                url: url_final + '/listagem',
                type: 'GET',
                data: {
                    op: opcao,
                    pesquisar: codigo
                },
                success: function (data) {
                    $('.mostrar_dados').html(data);
                    $('#loading2').fadeOut();
                    $('#loading2').hide();
                }
            });
        }
    }

    function atualiza() {
        window.location.reload();
    }

    function midia_banner(){
        var hash = window.location.hash;
        var url_total = window.location.href;
        var url = url_total.replace(link_p, '');
        var url_final = url.replace('/'+hash, '');

        $.ajax({
            beforeSend: function() {
                $('#loading').fadeIn();
            },
            url:url_final+'/bannerMidia',
            type:'POST',
            data: $('#form_banner_control').serialize(),
            success:function(data){
               $('#galery-imagens-banner').html(data);
               $('#loading').fadeOut();
            }
        });
    }

    function alterar_banner(codigo,titulo,data_m,data_f){

       var hash = window.location.hash;
       var url_total = window.location.href;
       var url = url_total.replace(link_p, '');
       var url_final = url.replace(hash , '');

       if(hash === '#consulta'){
           $('.abas li').removeClass('ativo');
           $('.abas li a[href="'+url_final+'#cadastro"]').parent().addClass('ativo');
           $('#consulta').hide();
           $('#cadastro').show();
           location.href=link_t;

           $('#codigo').val(codigo);
           $('#titulo').val(titulo);
           $('#data_m').val(data_m);
           $('#data_f').val(data_f);


           $('#cod_banner').val(codigo);

           midia_banner();

       }

   }

    function mostrar_tinymce(){
        var hash = window.location.hash;
        var url_total = window.location.href;
        var url = url_total.replace(link_p, '');
        var url_final = url.replace('/'+hash, '');

        $.ajax({
            beforeSend: function() {
                $('#loading').fadeIn();
            },
            url:url_final+'/tini',
            type:'POST',
            data: $('#form_banner_control').serialize(),
            success:function(data){
                tinymce.activeEditor.setContent(data);
                $('#loading').fadeOut();
            }
        });
    }


    function midia_noticias(){
        var hash = window.location.hash;
        var url_total = window.location.href;
        var url = url_total.replace(link_p, '');
        var url_final = url.replace('/'+hash, '');

        $.ajax({
            beforeSend: function() {
                $('#loading').fadeIn();
            },
            url:url_final+'/bannerMidia',
            type:'POST',
            data: $('#form_banner_control').serialize(),
            success:function(data){
                $('#galery-imagens-banner').html(data);
                $('#loading').fadeOut();
            }
        });
    }

    function alterar_noticias(codigo,titulo,sub,data_m,data_f){

        var hash = window.location.hash;
        var url_total = window.location.href;
        var url = url_total.replace(link_p, '');
        var url_final = url.replace(hash , '');

        if(hash === '#consulta'){
            $('.abas li').removeClass('ativo');
            $('.abas li a[href="'+url_final+'#cadastro"]').parent().addClass('ativo');
            $('#consulta').hide();
            $('#cadastro').show();
            location.href=link_t;

            $('#codigo').val(codigo);
            $('#titulo').val(titulo);
            $('#sub').val(sub);
            $('#data_m').val(data_m);
            $('#data_f').val(data_f);

            $('#cod_noticias').val(codigo);

            mostrar_tinymce();
            midia_noticias();

        }

    }

    function midia_sobre(){
        var hash = window.location.hash;
        var url_total = window.location.href;
        var url = url_total.replace(link_p, '');
        var url_final = url.replace('/'+hash, '');

        $.ajax({
            beforeSend: function() {
                $('#loading').fadeIn();
            },
            url:url_final+'/bannerMidia',
            type:'POST',
            data: $('#form_banner_control').serialize(),
            success:function(data){
                $('#galery-imagens-banner').html(data);
                $('#loading').fadeOut();
            }
        });
    }


    function alterar_sobre(codigo,titulo){

        var hash = window.location.hash;
        var url_total = window.location.href;
        var url = url_total.replace(link_p, '');
        var url_final = url.replace(hash , '');

        if(hash === '#consulta'){
            $('.abas li').removeClass('ativo');
            $('.abas li a[href="'+url_final+'#cadastro"]').parent().addClass('ativo');
            $('#consulta').hide();
            $('#cadastro').show();
            location.href=link_t;

            $('#codigo').val(codigo);
            $('#titulo').val(titulo);

            $('#cod_sobre').val(codigo);

            midia_sobre();
            mostrar_tinymce();

        }

    }

    function alterar_usuario(codigo,nome,email,login,tipo){

        var hash = window.location.hash;
        var url_total = window.location.href;
        var url = url_total.replace(link_p, '');
        var url_final = url.replace(hash , '');

        if(hash === '#consulta'){
            $('.abas li').removeClass('ativo');
            $('.abas li a[href="'+url_final+'#cadastro"]').parent().addClass('ativo');
            $('#consulta').hide();
            $('#cadastro').show();
            location.href=link_t;

            $('#codigo').val(codigo);
            $('#nome').val(nome);
            $('#email').val(email);
            $('#login').val(login);
            $('#tipo').val(tipo);

        }

    }


   function excluir(codigo){

       var hash = window.location.hash;
       var url_total = window.location.href;
       var url = url_total.replace(link_p, '');
       var url_final = url.replace('/'+hash, '');

       swal({
               title: "Deseja realmente excluir este item ?",
               type: "warning",
               showCancelButton: true,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "Deletar",
               cancelButtonText: "Cancelar",
               closeOnConfirm: false,
               closeOnCancel: false
           },
           function(isConfirm){
               if (isConfirm) {
                   $.ajax({
                       url:url_final+'/deletar',
                       type:'POST',
                       data:'codigo=' +codigo,
                       success:function(data){
                           if(data === '1'){
                               document.getElementById('click_del').click();
                               swal("Deletado com sucesso! Atualize o formulário");
                               document.getElementById("formulario").reset();
                               $("#codigo").each(function () {
                                   $(this).val("");
                               });
                               document.getElementById("galery-imagens-banner").innerHTML="";
                           }else{
                               swal({
                                   title: "Atenção! " +data,
                                   text: '',
                                   type: "error",
                                   showCancelButton: false,
                                   confirmButtonColor: "#aedef4",
                                   confirmButtonText: "OK",
                                   closeOnConfirm: false,
                                   closeOnCancel: false
                               });
                           }
                       }
                   });
               } else {
                   swal("Cancelado");
               }
           });

   }

   function situacao_alterar(codigo,situacao){

       var hash = window.location.hash;
       var url_total = window.location.href;
       var url = url_total.replace(link_p, '');
       var url_final = url.replace('/'+hash, '');

       $.ajax({
           url:url_final+'/altersituacao',
           type:'POST',
           data:{
               cod : codigo,
               sit : situacao
           },
           success:function(data){
               if(data === '1'){
                   $.ajax({
                       url: url_final + '/listSituacao',
                       type: 'POST',
                       data: {
                           cod: codigo
                       },
                       success: function (data) {
                           $('.mostrar_dados').html(data);
                       }
                   });
               }else{
                   swal({
                       title: "Atenção! " + data,
                       text: '',
                       type: "error",
                       showCancelButton: false,
                       confirmButtonColor: "#aedef4",
                       confirmButtonText: "OK",
                       closeOnConfirm: false,
                       closeOnCancel: false
                   });
               }
           }
       });


   }

   function logar(){

       $.ajax({
           url: 'home/logar',
           type: 'POST',
           data: $('#formulario').serialize(),
           success: function(data){
             if(data === '1'){
                 location.href='logado';
             }else if(data === '2'){
                 swal({
                     title: "Atenção! Usuário ou senha está errado. ",
                     text: '',
                     type: "error",
                     showCancelButton: false,
                     confirmButtonColor: "#aedef4",
                     confirmButtonText: "OK",
                     closeOnConfirm: false,
                     closeOnCancel: false
                 });
             }
           }
       });

   }