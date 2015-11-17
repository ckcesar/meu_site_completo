<?php

namespace Application\Controller;

use Application\Model\ModelMidia;
use Application\Model\ModelPermissoes;
use Application\Model\ModelUsuario;
use Application\Validator\validacao;
use Application\Validator\Validar_Data;

class usuario extends AbstractController{

    public function index(){

        session_start();
        foreach($_SESSION['url'] as $url){

            if($url->url === 'usuario/#cadastro'){
                $this->view("Usuario");
            }
        }

    }

    public function cadastrar(){

        $val = new validacao();
        $val_insert = new Validacao();
        $usuario = new ModelUsuario("usuario");

        $codigo = $usuario->id_usuario = $_POST['codigo'];
        $nome   = $usuario->nome = trim($_POST['nome']);
        $email    = $usuario->email = trim($_POST['email']);
        $login    = $usuario->login = trim($_POST['login']);
        $senha    = $usuario->senha = trim($_POST['senha']);
        $tipo     = $usuario->tipo = trim($_POST['tipo']);


        echo $val->validarCampo('Nome', $nome, '100', '3');
        echo $val->validarEmail($email, '200', '3');
        echo $val->validarCampo('Tipo', $tipo, '100', '4');



        if($codigo === ''){
            echo $val_insert->validarCampo('Login', $login, '100', '3');
            echo $val_insert->validarCampo('Senha', $senha, '12', '12');
            $ver_usuario = $usuario->lista_usuario($login);

            if($ver_usuario){
                echo"26";
            }else{
                if($val->verifica() && $val_insert->verifica()){
                    $usuario->gravar_usuario();
                    echo"1";
                }
            }
        }elseif($codigo !== ''){
            if($val->verifica()){
                $usuario->alterar_usuario();
                echo"2";
            }
        }

    }

    public function listagem(){

        $valor_data = new Validar_Data();

        $id = $_GET['pesquisar'];
        if($_GET['op'] === '0'){

            $lista_geral = new ModelUsuario("usuario");
            $dados['lista'] = $lista_geral->listar_usuario_geral();

        }else if($_GET['op'] === '1'){

            $lista_cod = new ModelUsuario("usuario");
            $dados['lista'] = $lista_cod->listar_usuario_cod($id);

        }else if($_GET['op'] === '2'){

            $lista_desc = new ModelUsuario("usuario");
            $dados['lista'] = $lista_desc->listar_usuario_desc("$id");

        }

        $mostrar  = '<div class="bloco_consulta" id="bloco_c" >';
        $mostrar .= '<table class="tabela_lista">';
        foreach($dados['lista'] as $itens){

            $mostrar .= '<tr class="tr_lista"><td class="linha_td">'.$itens->id_usuario.'</td>
                         <td >'.$itens->nome.'</td>
                           <td >'.$itens->data_cadastro.'</td>
                         <td class="td_alterar">
                         <a onclick="alterar_usuario('.$itens->id_usuario.' ,\''.$itens->nome.'\', \''.$itens->email.'\', \''.$itens->login.'\', \''.$itens->tipo_usuario.'\' );">Alterar</a>
                         </td><td class="td_excluir"><a onclick="excluir('.$itens->id_usuario.');" >Excluir</a></td>
                         </td>
                         '.($itens->situacao == '1' ? '<td class="td_situacao_ativa"><a onclick="situacao_alterar('.$itens->id_usuario.' ,'.$itens->situacao.');" >Ativo</a></td>'
                    : '<td class="td_situacao_inativo"><a onclick="situacao_alterar('.$itens->id_usuario.' ,'.$itens->situacao.');" >Inativo</a></td>').'</tr>';
        }
        $mostrar .= '</table>';
        $mostrar .= '</div>';

        if($dados['lista'][0]->id_usuario){
            echo $mostrar;
        }else{
            echo"<h2>Não há dados!</h2>";
        }


    }

    public function altersituacao(){

        $alt_situacao = new ModelUsuario("usuario");
        $codigo     = $alt_situacao->id_usuario = $_POST['cod'];
        $situacao   = $alt_situacao->situacao  = $_POST['sit'];

        if($codigo !== ''){
            $alt_situacao->situacao();
            echo"1";
        }

    }

    public function listSituacao(){

        $lista_s = new ModelUsuario("usuario");
        $codigo     = $lista_s->id_usuario = $_POST['cod'];
        $dados['lista'] = $lista_s->listar_usuario_sit($codigo);



        $mostrar  = '<div class="bloco_consulta" id="bloco_c" >';
        $mostrar .= '<table class="tabela_lista">';
        foreach($dados['lista'] as $itens){
            $mostrar .= '<tr class="tr_lista"><td class="linha_td">'.$itens->id_usuario.'</td>
                         <td >'.$itens->nome.'</td>
                           <td >'.$itens->data_cadastro.'</td>
                         <td class="td_alterar">
                         <a onclick="alterar_usuario('.$itens->id_usuario.' ,\''.$itens->nome.'\', \''.$itens->email.'\', \''.$itens->login.'\', \''.$itens->tipo_usuario.'\' );">Alterar</a>
                         </td><td class="td_excluir"><a onclick="excluir('.$itens->id_usuario.');" >Excluir</a></td>
                         </td>
                         '.($itens->situacao == '1' ? '<td class="td_situacao_ativa"><a onclick="situacao_alterar('.$itens->id_usuario.' ,'.$itens->situacao.');" >Ativo</a></td>'
                    : '<td class="td_situacao_inativo"><a onclick="situacao_alterar('.$itens->id_usuario.' ,'.$itens->situacao.');" >Inativo</a></td>').'</tr>';
        }
        $mostrar .= '</table>';
        $mostrar .= '</div>';

        echo $mostrar;
    }

    public function deletar(){

        $del = new ModelUsuario("usuario");
        $codigo = $del->id_usuario = $_POST['codigo'];

        $del_acessos = new ModelPermissoes("acessos_usuario");
        $dados['limpar'] = $del_acessos->lista_deletar_acessos($_POST['codigo']);

        if($dados['limpar']){
            foreach($dados['limpar'] as $limpar){
                $cod = $del_acessos->id_acessos_usuario = $limpar->id_acessos_usuario;
                if($cod !== ''){
                    $del_acessos->deletar_acessos_usuario();
                }
            }
            if($codigo !== ''){
                $del->deletar_usuario();
                echo"1";
            }
        }else{
            if($codigo !== ''){
                $del->deletar_usuario();
                echo"1";
            }
        }


    }


}