<?php

namespace Application\Controller;

use Application\Model\ModelPermissoes;
use Application\Model\ModelUsuario;
use Application\Validator\validacao;

class Acessos extends AbstractController{

    public function index(){
        session_start();
       $usuario = new ModelPermissoes("usuario");
       $dados['lista_usuario'] = $usuario->listar_usuario_geral();

       $acessos = new ModelPermissoes("acessos_id");
       $dados['lista_acessos'] = $acessos->listar_acessos_geral();


        foreach($_SESSION['url'] as $url){

            if($url->url === 'acessos/#cadastro'){
                $this->view("Permissao",$dados);
            }
        }



    }

    public function cadastrar(){

        $val = new validacao();

        $per = new ModelPermissoes("acessos_usuario");

        $codigo = $per->id_acessos_usuario = $_POST['codigo'];
        $uer    = $per->id_usuario = $_POST['tipo'];
        $acer   = $per->id_acessos_id = $_POST['tipo_acessos'];

        echo $val->validarCampo('Nome', $uer, '100', '1');
        echo $val->validarCampo('Telas', $acer, '100', '1');

        if($val->verifica() && $codigo === ''){
            $ver_acessos = new ModelPermissoes("acessos_id a, acessos_usuario b, usuario c");
            $dados['lista_acessos'] = $ver_acessos->listar_acessos_checados($uer,$acer);
            if($dados['lista_acessos']){
                echo"23";
            }else{
                $per->gravar_acessos();
                echo"1";
            }

        }

    }

    public function listagem(){

        $id = $_GET['pesquisar'];
        if($_GET['op'] === '0'){

            $lista_geral = new ModelPermissoes("acessos_id a, acessos_usuario b, usuario c");
            $dados['lista'] = $lista_geral->listar_todos_acessos();

        }else if($_GET['op'] === '1'){

            $lista_cod = new ModelPermissoes("acessos_id a, acessos_usuario b, usuario c");
            $dados['lista'] = $lista_cod->listar_id_acessos($id);

        }else if($_GET['op'] === '2'){

            $lista_desc = new ModelPermissoes("acessos_id a, acessos_usuario b, usuario c");
            $dados['lista'] = $lista_desc->listar_nome_acessos("$id");

        }

        $mostrar  = '<div class="bloco_consulta" id="bloco_c" >';
        $mostrar .= '<table class="tabela_lista">';
        foreach($dados['lista'] as $itens){

            $mostrar .= '<tr class="tr_lista"><td class="linha_td">'.$itens->id_acessos_usuario.'</td>
                         <td >'.$itens->NomeUsuario.'</td>
                         <td class="td_excluir"><a onclick="excluir('.$itens->id_acessos_usuario.');" >Excluir</a></td>
                         </td>
                         </tr>';
        }
        $mostrar .= '</table>';
        $mostrar .= '</div>';

        if($dados['lista'][0]->id_acessos_usuario){
            echo $mostrar;
        }else{
            echo"<h2>Não há dados!</h2>";
        }


    }

    public function deletar(){

        $del = new ModelPermissoes("acessos_usuario");
        $codigo = $del->id_acessos_usuario = $_POST['codigo'];

        if($codigo !== ''){
            $del->deletar_acessos();
            echo"1";
        }

    }

}