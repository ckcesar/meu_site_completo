<?php
/**
 * Created by PhpStorm.
 * User: Soluções Web
 * Date: 20/05/2015
 * Time: 14:28
 */

namespace Application\Controller;

use Application\Model\Itens;
use Application\Model\ModelCidade;
use Application\Model\ModelEstado;
use Application\Validator\validacao;
use Application\Validator\Validate;

class Cidade extends AbstractController {

    public function index(){

        $estado = new ModelEstado("cadastrar_estado");
        $dados['select_estado'] = $estado->listar_estado_geral();

        $this->view("Cidade",$dados);

    }

    public function cadastrar(){

        $val = new Validacao();
        $cidade = new ModelCidade("cadastrar_cidade");

        $codigo = $cidade->codigo = $_POST['codigo'];
        $estado = $cidade->estado = $_POST['estado'];
        $cid    = $cidade->cidade = trim($_POST['cidade']);

        echo $val->validarCampo('Estado', $estado, '100', '1');
        echo $val->validarCampo('Cidade', $cid, '100', '3');


        if($val->verifica() && $codigo === ''){
            $cidade->gravar_cidade();
            echo"1";
        }else if($val->verifica() && $codigo !== ''){
            $cidade->alterar_cidade();
            echo"2";
        }

    }

    public function listagem($id){
        $id = $_GET['pesquisar'];
        if($_GET['op'] === '0'){

           $lista_geral = new ModelCidade("cadastrar_cidade a, cadastrar_estado b");
           $dados['lista'] = $lista_geral->listar_cidade_geral();

        }else if($_GET['op'] === '1'){

            $listar_cod = new ModelCidade("cadastrar_cidade a, cadastrar_estado b");
            $dados['lista'] = $listar_cod->listar_cidade_cod($id);

        }else if($_GET['op'] === '2'){

            $listar_desc = new ModelCidade("cadastrar_cidade a, cadastrar_estado b");
            $dados['lista'] = $listar_desc->listar_cidade_desc("$id");

        }


        $mostrar = '<table class="tabela_lista" >';
        $mostrar .= '<tr class="tr_th_lista">';
        $mostrar .= '<th>Código</th>';
        $mostrar .= '<th>Cidade</th>';
        $mostrar .= '<th>Estado</th>';
        $mostrar .= '<th colspan="2" >Ação</th>';
        $mostrar .= '</tr>';
        foreach($dados['lista'] as $itens){
            $mostrar .= '<tr class="tr_lista"><td>'.$itens->id_cidade.'</td><td>'.$itens->cidade.'</td><td>'.$itens->estado.'</td> <td class="td_alterar"><a onclick="alterar_cidade('.$itens->id_cidade.' ,\''.$itens->estado.'\', \''.$itens->cidade.'\');">Alterar</a></td><td class="td_excluir"><a onclick="excluir('.$itens->id_cidade.');" >Excluir</td> </tr>';
        }
        $mostrar .= '</table>';

        if($dados['lista'][0]->id_cidade){
            echo $mostrar;
        }else{
            echo"<h2>Não há dados!</h2>";
        }

    }

    public function deletar(){
        $del = new ModelCidade("cadastrar_cidade");

        $codigo = $del->codigo = $_POST['codigo'];

        if($codigo !== ''){
            $del->deletar_cidade();
            echo"1";
        }

    }

}