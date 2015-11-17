<?php

namespace Application\Controller;

use Application\Model\ModelMidia;
use Application\Model\ModelSobre;
use Application\Validator\validacao;
use Application\Validator\Validar_Data;

class sobre extends AbstractController{

    public function index(){

        session_start();
        foreach($_SESSION['url'] as $url){

            if($url->url === 'sobre/#cadastro'){
                $this->view("Sobre");
            }
        }


    }

    public function cadastrar(){

        $val = new validacao();
        $sobre = new ModelSobre("sobre_nos");

        $codigo = $sobre->id_sobre = $_POST['codigo'];
        $titulo = $sobre->titulo = trim($_POST['titulo']);
        $desc   = $sobre->descricao = trim($_POST['descricao']);

        echo $val->validarCampo('Título', $titulo, '100', '3');
        echo $val->validarCampo('Descrição', $desc, '3000', '3');

        if ($val->verifica() && $codigo === '') {
            $sobre->gravar_sobre();
            if($_POST['urls'] != null) {
                $ultimo_id['id'] = $sobre->ultimoIdSobre("sobre_nos");
                foreach ($ultimo_id['id'] as $id_cod) {
                    $img = new ModelMidia("midia");
                    $foto = 'F';

                    for ($r = 0; $r < count($_POST['radios']); $r++) {
                        for ($i = 0; $i < count($_POST['urls']); $i++) {
                            $tipo = $img->tipo = $foto;
                            $url = $img->url = $_POST['urls'][$i];
                            $url_mini = $img->url_mini = $_POST['urls'][$i];
                            $id_banner = $img->id_sobre = $id_cod->id_sobre;

                            if ($_POST['radios'][$r] === $_POST['urls'][$i]) {
                                $radios = $img->principal = '1';
                            } else {
                                $radios = $img->principal = '0';
                            }
                            if ($_POST['urls'][$i]) {
                                $img->gravar_midia();
                            }
                        }
                    }
                }
            }
            echo "1";

        } else if ($val->verifica() && $codigo !== '') {
            $sobre->alterar_sobre();
            $img = new ModelMidia("midia");
            $foto = 'F';

            for( $r=0; $r<count($_POST['radios']); $r++ ) {
                for ($i = 0; $i < count($_POST['urls']); $i++) {
                    if ($_POST['urls'][$i] != '0') {
                        $tipo      = $img->tipo = $foto;
                        $url       = $img->url  = $_POST['urls'][$i];
                        $url_mini  = $img->url_mini = $_POST['urls'][$i];
                        $id_banner = $img->id_sobre = $codigo;
                        $radios    = $img->principal = '0';

                        if($_POST['radios'][$r] === $_POST['urls'][$i]){
                            $itens['radios'] = $img->alterar_acrecentar_radio($codigo);
                            foreach($itens['radios'] as $itens_radios){
                                $banner = $img->id_sobre = $itens_radios->id_sobre;
                                $principal = $img->principal = $itens_radios->principal;

                                $img->alt_radios_acrescentados();
                            }

                            $radios = $img->principal = '1';
                        }else{
                            $radios = $img->principal = '0';
                        }

                        if($_POST['urls'][$i]){
                            $img->gravar_midia();
                        }

                    }

                }
            }
            echo "2";
        }

    }

    public function alterarRad(){

        $url_radio = new ModelMidia("midia");
        $lista['url_radio'] = $url_radio->listar_para_alt($_GET['rd']);

        if($lista['url_radio']){

            foreach($lista['url_radio'] as $radio) {

                if($radio->url === $_GET['rd']){

                    $codigo = $url_radio->id_midia = $radio->id_midia;
                    $principal = $url_radio->principal = $radio->principal;
                    $banner    = $url_radio->id_sobre = $radio->id_sobre;

                    if($codigo != ''){
                        $url_radio->alt_radio();

                    }

                }

            }
        }else{

        }

    }

    public function bannerMidia(){

        $cod_midia = $_POST['cod_sobre'];
        $midia = new ModelMidia("midia");
        $lista['midia'] = $midia->listar_midia_sobre($cod_midia);

        $link = URL_SITE.'uploads/sobre/';

        if($lista['midia']){
            if($lista['midia'][0]->id_sobre === $cod_midia){
                foreach($lista['midia'] as $midia_mostrar){

                    $resultado = '<div class="div-image-pai">
                             <input type="hidden" name="urls[]" value="0" />
                             '.($midia_mostrar->principal === '1' ? '<div style="float: right"><input type="radio" id="radio" onclick="alterarRadio(\''.$midia_mostrar->url.'\');" name="radios[]" value="'.$midia_mostrar->url.'" checked  />Foto Principal</div>' : '<div style="float: right"><input type="radio" id="radio" onclick="alterarRadio(\''.$midia_mostrar->url.'\');" name="radios[]" value="'.$midia_mostrar->url.'"  />Foto Principal</div>').'
                             <div class="width-image" style="background-image: url('.$link.''.$midia_mostrar->url. ' )">
                             <a class="fechar_imagem" data-value="' .$midia_mostrar->url. '" onclick="limpar_foto(this)">[X]</a>
                             </div>
                             </div>';


                    echo $resultado;
                }
            }
        }

    }

    public function tini(){
        $cod_descricao = $_POST['cod_sobre'];
        $sobre = new ModelSobre("sobre_nos");

        $lista['dados'] = $sobre->listar_sobre_cod($cod_descricao);

        foreach($lista['dados'] as $sobre_nos){
            echo $sobre_nos->descricao;
        }

    }

    public function listagem(){

        $valor_data = new Validar_Data();

        $id = $_GET['pesquisar'];
        if($_GET['op'] === '0'){

            $lista_geral = new ModelSobre("sobre_nos");
            $dados['lista'] = $lista_geral->listar_sobre_geral();

        }else if($_GET['op'] === '1'){

            $lista_cod = new ModelSobre("sobre_nos");
            $dados['lista'] = $lista_cod->listar_sobre_cod($id);

        }else if($_GET['op'] === '2'){

            $lista_desc = new ModelSobre("sobre_nos");
            $dados['lista'] = $lista_desc->listar_sobre_desc("$id");

        }

        $form = '<form method="post" id="form_banner_control">
                 <input type="hidden"  name="cod_sobre" id="cod_sobre" />
                 </form>';
        echo $form;

        $mostrar  = '<div class="bloco_consulta" id="bloco_c" >';
        $mostrar .= '<table class="tabela_lista">';
        foreach($dados['lista'] as $itens){

            $mostrar .= '<tr class="tr_lista"><td class="linha_td">'.$itens->id_sobre.'</td>
                         <td >'.$itens->titulo.'</td>
                         <td class="td_alterar">
                         <a onclick="alterar_sobre('.$itens->id_sobre.' ,\''.$itens->titulo.'\');">Alterar</a>
                         </td><td class="td_excluir"><a onclick="excluir('.$itens->id_sobre.');" >Excluir</a></td>
                         </td>
                         '.($itens->situacao == '1' ? '<td class="td_situacao_ativa"><a onclick="situacao_alterar('.$itens->id_sobre.' ,'.$itens->situacao.');" >Ativo</a></td>'
                    : '<td class="td_situacao_inativo"><a onclick="situacao_alterar('.$itens->id_sobre.' ,'.$itens->situacao.');" >Inativo</a></td>').'</tr>';
        }
        $mostrar .= '</table>';
        $mostrar .= '</div>';

        if($dados['lista'][0]->id_sobre){
            echo $mostrar;
        }else{
            echo"<h2>Não há dados!</h2>";
        }


    }

    public function altersituacao(){

        $alt_situacao = new ModelSobre("sobre_nos");
        $codigo     = $alt_situacao->id_sobre = $_POST['cod'];
        $situacao   = $alt_situacao->situacao  = $_POST['sit'];

        if($codigo !== ''){
            $alt_situacao->situacao();
            echo"1";
        }

    }

    public function listSituacao(){

        $lista_s = new ModelSobre("sobre_nos");
        $codigo     = $lista_s->id_sobre = $_POST['cod'];
        $dados['lista'] = $lista_s->listar_sobre_sit($codigo);

        $form = '<form method="post" id="form_banner_control">
                 <input type="hidden"  name="cod_sobre" id="cod_sobre" />
                 </form>';

        echo $form;

        $mostrar  = '<div class="bloco_consulta" id="bloco_c" >';
        $mostrar .= '<table class="tabela_lista">';
        foreach($dados['lista'] as $itens){
            $mostrar .= '<tr class="tr_lista"><td class="linha_td">'.$itens->id_sobre.'</td>
                         <td >'.$itens->titulo.'</td>
                         <td class="td_alterar">
                         <a onclick="alterar_sobre('.$itens->id_sobre.' ,\''.$itens->titulo.'\');">Alterar</a>
                         </td><td class="td_excluir"><a onclick="excluir('.$itens->id_sobre.');" >Excluir</a></td>
                         </td>
                         '.($itens->situacao == '1' ? '<td class="td_situacao_ativa"><a onclick="situacao_alterar('.$itens->id_sobre.' ,'.$itens->situacao.');" >Ativo</a></td>'
                    : '<td class="td_situacao_inativo"><a onclick="situacao_alterar('.$itens->id_sobre.' ,'.$itens->situacao.');" >Inativo</a></td>').'</tr>';
        }
        $mostrar .= '</table>';
        $mostrar .= '</div>';

        echo $mostrar;
    }

    public function deletar(){

        $del = new ModelSobre("sobre_nos");
        $codigo = $del->id_sobre = $_POST['codigo'];

        $del_midia = new ModelMidia("midia");
        $midia['del_midia'] = $del_midia->listar_midia_sobre($_POST['codigo']);

        if($midia['del_midia']){
            foreach($midia['del_midia'] as $deletar){
                $cod_midia = $del_midia->id_midia = $deletar->id_midia;
                if($cod_midia != ''){
                    $del_midia->deletar_midia();
                    unlink('../gestor/uploads/sobre/'.$deletar->url);
                    //unlink('../public_html/uploads/sobre/'.$deletar->url);
                }
            }
            if($codigo !== ''){
                $del->deletar_sobre();
                echo"1";
            }
        }else{
            if($codigo !== ''){
                $del->deletar_sobre();
                echo"1";
            }
        }
    }

    public function fotosSobre(){

        $_UP['tipo'] = array('png','jpg','jpeg');
        $imagem  = $_FILES['imagem'];
        $img     = $_FILES['imagem']['name'];
        $tmp     = $_FILES['imagem']['tmp_name'];
        $dirname = '../gestor/uploads/sobre';
        //$dirname = '../public_html/uploads/sobre';

        $count = count($imagem['name']);

        if($count > 0){

            $fotos = array();
            for($i = 0; $i < $count; $i++){

                $ext = substr(strrchr($imagem['name'][$i], '.'), 1);

                if(array_search($ext, $_UP['tipo']) === false){
                    echo "0";
                    exit();
                }else{
                    $oldname = $tmp[$i];
                    $newname = date('YmdHis') . $i . '.' . $ext;
                    if(move_uploaded_file($oldname, $dirname . '/' . $newname)) {
                        $fotos[] = $newname;
                    }else{
                        echo"1";
                        exit();
                    }
                }
            }
            echo json_encode($fotos);
        }
    }

    public function deletarimagem(){

        $del = new ModelMidia("midia");
        $img['lista'] = $del->listar_para_alt($_POST['id_imagem']);

        if($img['lista']){
            foreach($img['lista'] as $imagem){
                $codigo = $del->id_midia = $imagem->id_midia;
                if($codigo != ''){
                    $del->deletar_midia();
                    unlink('../gestor/uploads/sobre/'.$_POST['id_imagem']);
                    //unlink('../public_html/uploads/sobre/'.$_POST['id_imagem']);
                    echo $_POST['id_imagem'];
                }
            }
        }else{
            if($_POST['id_imagem']){
                unlink('../gestor/uploads/sobre/'.$_POST['id_imagem']);
                //unlink('../public_html/uploads/sobre/'.$_POST['id_imagem']);
                echo $_POST['id_imagem'];
            }
        }

    }

}