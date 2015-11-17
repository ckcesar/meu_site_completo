<?php


namespace Application\Controller;

use Application\Model\ModelCidade;
use Application\Model\ModelEstado;
use Application\Validator\validacao;
use Application\Validator\Validate;




class estado extends AbstractController {

    public function index(){
        $this->view("Estado");
    }

    public function cadastrar(){

         $val = new validacao();
         $estado = new ModelEstado("cadastrar_estado");

         $codigo = $estado->codigo = $_POST['codigo'];
         $est    = $estado->estado = trim($_POST['estado']);
         $sigla  = $estado->sigla  = trim($_POST['sigla']);

         echo $val->validarCampo('Estado', $est, '100', '3');
         echo $val->validarCampo('Sigla', $sigla, "2", "2");


             if ($val->verifica() && $codigo === '') {
                 $estado->gravar_estado();
                 echo "1";
             } else if ($val->verifica() && $codigo !== '') {
                 $estado->alterar_estado();
                 echo "2";
             }

    }

    public function deletar(){

        $del = new ModelEstado("cadastrar_estado");
        $estado = new ModelCidade("cadastrar_cidade a, cadastrar_estado b");
        $dados['list_del'] = $estado->listar_cidade_geral();

        $codigo = $del->codigo = $_POST['codigo'];


        foreach($dados['list_del'] as $d){}
            if($d->cadastrar_estado_id_estado === $codigo){
              echo"Estado tem dependência.";
            }else{
                $del->deletar_estado();
                echo"1";
            }


    }

    public function listagem($id){
        $id = $_GET['pesquisar'];
        if($_GET['op'] === '0'){

            $lista_geral = new ModelEstado("cadastrar_estado");
            $dados['lista'] = $lista_geral->listar_estado_geral();

        }else if($_GET['op'] === '1'){

            $lista_cod = new ModelEstado("cadastrar_estado");
            $dados['lista'] = $lista_cod->listar_estado_cod($id);

        }else if($_GET['op'] === '2'){

            $lista_desc = new ModelEstado("cadastrar_estado");
            $dados['lista'] = $lista_desc->listar_estado_desc("$id");

        }

        $mostrar = '<table class="tabela_lista" >';
        $mostrar .= '<tr class="tr_th_lista">';
        $mostrar .= '<th>Código</th>';
        $mostrar .= '<th>Estado</th>';
        $mostrar .= '<th>Sigla</th>';
        $mostrar .= '<th colspan="2" >Ação</th>';
        $mostrar .= '</tr>';
        foreach($dados['lista'] as $itens){
           $mostrar .= '<tr class="tr_lista"><td>'.$itens->id_estado.'</td><td>'.$itens->estado.'</td><td>'.$itens->sigla.'</td> <td class="td_alterar"><a onclick="alterar_estado('.$itens->id_estado.' ,\''.$itens->estado.'\', \''.$itens->sigla.'\');">Alterar</a></td><td class="td_excluir"><a onclick="excluir('.$itens->id_estado.');" >Excluir</td> </tr>';
        }
        $mostrar .= '</table>';

       if($dados['lista'][0]->id_estado){
           echo $mostrar;
       }else{
           echo"<h2>Não há dados!</h2>";
       }


    }

}