<?php

namespace Application\Controller;

use Application\Model\Itens;
use Application\Model\ModelSobre;
use Application\Model\ModelUsuario;
use Application\ModelLogar;
use Application\Validator\validacao;
use Application\Validator\Validate;

class Home extends AbstractController {

    public function index() {

        $this->view("Home");
    
    }

    public function logar(){

        session_start();

        $login = $_POST['login'];
        $senha = md5($_POST['senha']);

        $entrar = new ModelUsuario("usuario a, acessos_usuario b, acessos_id c");

        $dados['lista'] = $entrar->lista_logar($login,$senha);
        $_SESSION['url'] = $dados['lista'];
        if($dados['lista']){

            foreach($dados['lista'] as $itens){
                $_SESSION['login'] = $itens->login;
                $_SESSION['senha'] = $itens->senha;
                $_SESSION['nome'] = $itens->nome;
                $_SESSION['id_usuario'] = $itens->id_usuario;
            }

           echo"1";
        }else{
           echo"2";
        }

    }

    
}