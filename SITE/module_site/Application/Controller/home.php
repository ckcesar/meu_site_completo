<?php

namespace Application\Controller;

use Application\Model\ModelBannerSite;
use Application\Model\ModelNoticiasSite;
use Application\Model\ModelSobreMimSite;
use Application\Validator\validacao;

class Home extends AbstractController {

    public function index() {

        $banner = new ModelBannerSite("banner a, midia b");
        $dados['listar_banner'] = $banner->listar_banner();

        $sobre_nos = new ModelSobreMimSite("sobre_nos");
        $dados['listar_sobre'] = $sobre_nos->listar_sobre();

        $noticias = new ModelNoticiasSite("noticias");
        $dados['listar_noticias'] = $noticias->listar_geral();

        $listar_foto_noticia = new ModelNoticiasSite("noticias a left join midia b on b.id_noticias = a.id_noticias ");
        $dados['listar_foto_noticia'] = $listar_foto_noticia;

        $this->view("Home",$dados);
    }

    
    public function enviar(){

        $val = new validacao();

        $nome      = $_POST['nome'];
        $email     = $_POST['email'];
        $descricao = $_POST['texto'];

        $para      = "ckcesaraugusto@gmail.com";
        $assunto   = "Contato do site!";

        $mensagem  = "<br> <strong>Nome:  </strong>".$nome;
        $mensagem .= "<br> <strong>E-mail:  </strong>".$email;
        $mensagem .= "<br>  <strong>Mensagem: </strong>".$descricao;

        $headers =  "Content-Type:text/html; charset=UTF-8\n";
        $headers .= "From:  cesartsi.com<ckcesaraugusto@gmail.com>\n"; //Vai ser //mostrado que  o email partiu deste email e seguido do nome
        $headers .= "X-Sender:  <ckcesaraugusto@gmail.com>\n"; //email do servidor //que enviou
        $headers .= "X-Mailer: PHP  v".phpversion()."\n";
        $headers .= "X-IP:  ".$_SERVER['REMOTE_ADDR']."\n";
        $headers .= "Return-Path:  <ckcesaraugusto@gmail.com>\n"; //caso a msg //seja respondida vai para  este email.
        $headers .= "MIME-Version: 1.0\n";

        echo $val->validarCampo('Nome', $nome, '100', '3');
        echo $val->validarEmail($email, '100', '3');
        echo $val->validarCampo('Mensagem', $descricao, "1000", "3");

        if(!$val->verifica() ){
            echo"";
        }elseif(!mail($para, $assunto, $mensagem, $headers)){
            echo"";
        }else{
            echo"1";
        }
    }

}