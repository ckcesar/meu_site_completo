$(document).ready(function (){   
        $('a.mn-item').click(function() {
        var lnk = $(this).attr('id').replace('mn-', '#lnk-');
        var l = $(lnk);
        st = l.offset().top - 60;

        $('html, body').animate({scrollTop: st}, 1000, function() {
            window.location.hash = l.attr('name');
        });
        return false;
    });    
    
    var offset = $('.menu').offset().top;
    var $meuMenu = $('.menu');
    $(document).on('scroll', function () {
        if (offset <= $(window).scrollTop()) {
            $meuMenu.addClass('fixar');
        } else {
            $meuMenu.removeClass('fixar');
        }
    });
    
    window.sr = new scrollReveal({
		reset: true
    });
    
});

function enviar_contato(){
    $.ajax({
       url:'home/enviar', 
       type:'POST',
       data: $('#formulario').serialize(),
       success: function(data) {
         if(data === '1'){
            swal({
                title: "Contato enviado com sucesso!",
                text: '',
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#aedef4",
                confirmButtonText: "OK",
                closeOnConfirm: false,
                closeOnCancel: false
            });
            document.getElementById("formulario").reset();
        }else{
             swal({
                 title:"Atenção!" + data,
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