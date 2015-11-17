<?php

namespace Application\Controller;

use Application\Model\LastId;
use Application\Model\ModelBanner;
use Application\Model\ModelMidia;
use Application\Validator\validacao;
use Application\Validator\Validar_Data;

class banner extends AbstractController{

    public function index(){

        session_start();
        foreach($_SESSION['url'] as $url){

            if($url->url === 'banner/#cadastro'){
                $this->view("Banner");
            }
        }

    }


    public function cadastrar(){

        $val = new validacao();
        $banner = new ModelBanner("banner");

        $codigo = $banner->id_banner = $_POST['codigo'];
        $titulo = $banner->titulo = trim($_POST['titulo']);
        $data_m = $banner->data_mostrar = trim($_POST['data_m']);
        $data_f = $banner->data_final = $_POST['data_f'];


        echo $val->validarCampo('Título', $titulo, '100', '3');
        echo $val->validarData($data_m, '16', '16');

        if ($data_f) {
            $data_2 = substr($data_f, 0, 10);
        }else{
            $data_2 = '00/00/0000';
        }

        $data_1 = substr($data_m, 0, 10);

        $d1 = explode("/", $data_1);
        $d2 = explode("/", $data_2);

        $data_a = $d1['2'].$d1['1'].$d1['0'];
        $data_b = $d2['2'].$d2['1'].$d2['0'];

        $dk = $d1[0];
        $m = $d1[1];
        $y = $d1[2];
        if($data_a){
            $res1 = checkdate($m, $dk, $y);
        }


        if($data_b != '00000000'){
            $dd = $d2[0];
            $mm = $d2[1];
            $yy = $d2[2];
            $res2 = checkdate($mm,$dd,$yy);
        }else{
            $res2 = '00000000';
        }


        if(($res1 == 1) && ($res2 == 1) || ($res1 == 1) && ($res2 == '00000000') ){
            if(($data_b > $data_a) || $data_b === '00000000'){

                if ($val->verifica() && $codigo === '') {
                    $banner->gravar_banner();
                    if($_POST['urls'] != null) {
                        $ultimo_id['id'] = $banner->ultimoIdBanner("banner");
                        foreach ($ultimo_id['id'] as $id_cod) {
                            $img = new ModelMidia("midia");
                            $foto = 'F';

                            for ($r = 0; $r < count($_POST['radios']); $r++) {
                                for ($i = 0; $i < count($_POST['urls']); $i++) {
                                    $tipo = $img->tipo = $foto;
                                    $url = $img->url = $_POST['urls'][$i];
                                    $url_mini = $img->url_mini = $_POST['urls'][$i];
                                    $id_banner = $img->id_banner = $id_cod->id_banner;

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
                    $banner->alterar_banner();
                    $img = new ModelMidia("midia");
                    $foto = 'F';

                    for( $r=0; $r<count($_POST['radios']); $r++ ) {
                        for ($i = 0; $i < count($_POST['urls']); $i++) {
                            if ($_POST['urls'][$i] != '0') {
                                $tipo      = $img->tipo = $foto;
                                $url       = $img->url  = $_POST['urls'][$i];
                                $url_mini  = $img->url_mini = $_POST['urls'][$i];
                                $id_banner = $img->id_banner = $codigo;
                                $radios    = $img->principal = '0';

                                if($_POST['radios'][$r] === $_POST['urls'][$i]){
                                    $itens['radios'] = $img->alterar_acrecentar_radio($codigo);
                                    foreach($itens['radios'] as $itens_radios){
                                        $banner = $img->id_banner = $itens_radios->id_banner;
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

            }else{
                echo"A primeira data é maior que a Segunda Data.";
            }
        }else{
            echo"Data inválida.";
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
                    $banner    = $url_radio->id_banner = $radio->id_banner;

                    if($codigo != ''){
                        $url_radio->alt_radio();

                    }

                }

            }
        }else{

        }

    }

    public function deletar(){

        $del = new ModelBanner("banner");
        $codigo = $del->id_banner = $_POST['codigo'];

        $del_midia = new ModelMidia("midia");
        $midia['del_midia'] = $del_midia->listar_midia($_POST['codigo']);

        if($midia['del_midia']){
            foreach($midia['del_midia'] as $deletar){
                $cod_midia = $del_midia->id_midia = $deletar->id_midia;
                if($cod_midia != ''){
                    $del_midia->deletar_midia();
                    //unlink('../gestor/uploads/banner/'.$deletar->url);
                    unlink('../public_html/uploads/banner/'.$deletar->url);
                }
            }
            if($codigo !== ''){
                $del->deletar_banner();
                echo"1";
            }
        }else{
            if($codigo !== ''){
                $del->deletar_banner();
                echo"1";
            }
        }
    }

    public function altersituacao(){

        $alt_situacao = new ModelBanner("banner");
        $codigo     = $alt_situacao->id_banner = $_POST['cod'];
        $situacao   = $alt_situacao->situacao  = $_POST['sit'];

        if($codigo !== ''){
            $alt_situacao->situacao();
            echo"1";
        }

    }

    public function listSituacao(){

        $lista_s = new ModelBanner("banner");
        $codigo     = $lista_s->id_banner = $_POST['cod'];
        $dados['lista'] = $lista_s->listar_banner_sit($codigo);

        $form = '<form method="post" id="form_banner_control">
                 <input type="hidden"  name="cod_banner" id="cod_banner" />
                 </form>';

            echo $form;

        $mostrar  = '<div class="bloco_consulta" id="bloco_c" >';
        $mostrar .= '<table class="tabela_lista">';
        foreach($dados['lista'] as $itens){
            $mostrar .= '<tr class="tr_lista"><td class="linha_td">'.$itens->id_banner.'</td>
                         <td >'.$itens->titulo.'</td>
                         <td >'.$itens->data_cadastro.'</td>
                         <td class="td_alterar">
                         <a onclick="alterar_banner('.$itens->id_banner.' ,\''.$itens->titulo.'\', \''.$itens->data_mostrar.'\',
                         \''.($itens->data_final != '00/00/0000 00:00' ? $itens->data_final : '').'\');">Alterar</a>
                         </td><td class="td_excluir"><a onclick="excluir('.$itens->id_banner.');" >Excluir</a></td>
                         </td>
                         '.($itens->situacao == '1' ? '<td class="td_situacao_ativa"><a onclick="situacao_alterar('.$itens->id_banner.' ,'.$itens->situacao.');" >Ativo</a></td>'
                    : '<td class="td_situacao_inativo"><a onclick="situacao_alterar('.$itens->id_banner.' ,'.$itens->situacao.');" >Inativo</a></td>').'</tr>';
        }
        $mostrar .= '</table>';
        $mostrar .= '</div>';

        echo $mostrar;
    }

    public function bannerMidia(){

        $cod_midia = $_POST['cod_banner'];
        $midia = new ModelMidia("midia");
        $lista['midia'] = $midia->listar_midia($cod_midia);

        $link = URL_SITE.'uploads/banner/';
        if($lista['midia']){
            if($lista['midia'][0]->id_banner === $cod_midia){
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

    public function listagem(){

        $valor_data = new Validar_Data();

        $id = $_GET['pesquisar'];
        if($_GET['op'] === '0'){

            $inicio = '0';
            $limit  = '10';

            $lista_geral = new ModelBanner("banner");
            $dados['lista'] = $lista_geral->listar_banner_geral($inicio,$limit);

        }else if($_GET['op'] === '1'){

            $lista_cod = new ModelBanner("banner");
            $dados['lista'] = $lista_cod->listar_banner_cod($id);

        }else if($_GET['op'] === '2'){

            $lista_desc = new ModelBanner("banner");
            $dados['lista'] = $lista_desc->listar_banner_desc("$id");

        }

        $form = '<form method="post" id="form_banner_control">
                 <input type="hidden"  name="cod_banner" id="cod_banner" />
                 </form>';
        echo $form;

        $mostrar  = '<div class="bloco_consulta" id="bloco_c" >';
        $mostrar .= '<table class="tabela_lista">';
        foreach($dados['lista'] as $itens){

            $mostrar .= '<tr class="tr_lista"><td class="linha_td">'.$itens->id_banner.'</td>
                         <td >'.$itens->titulo.'</td>
                         <td >'.$itens->data_cadastro.'</td>
                         <td class="td_alterar">
                         <a onclick="alterar_banner('.$itens->id_banner.' ,\''.$itens->titulo.'\', \''.$itens->data_mostrar.'\',
                         \''.($itens->data_final != '00/00/0000 00:00' ? $itens->data_final : '').'\');">Alterar</a>
                         </td><td class="td_excluir"><a onclick="excluir('.$itens->id_banner.');" >Excluir</a></td>
                         </td>
                         '.($itens->situacao == '1' ? '<td class="td_situacao_ativa"><a onclick="situacao_alterar('.$itens->id_banner.' ,'.$itens->situacao.');" >Ativo</a></td>'
                         : '<td class="td_situacao_inativo"><a onclick="situacao_alterar('.$itens->id_banner.' ,'.$itens->situacao.');" >Inativo</a></td>').'</tr>';
        }
        $mostrar .= '</table>';
        $mostrar .= '</div>';

        if($dados['lista'][0]->id_banner){
            echo $mostrar;
        }else{
            echo"<h2>Não há dados!</h2>";
        }


    }

    public function carregarBanner(){
        header ('Content-type: application/json; charset=utf-8');

        $limit = 10;
        $page  = $_GET['page'];

        $inicio = ($page * $limit);
        $itens = new ModelBanner("banner");
        $lista = $itens->listar_banner_geral($inicio, $limit);

        echo json_encode($lista);
    }

    public function fotosBanner(){

        $_UP['tipo'] = array('png','jpg','jpeg');
        $imagem  = $_FILES['imagem'];
        $img     = $_FILES['imagem']['name'];
        $tmp     = $_FILES['imagem']['tmp_name'];
        //$dirname = '../gestor/uploads/banner';
        $dirname = '../public_html/uploads/banner';

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
                   //unlink('../gestor/uploads/banner/'.$_POST['id_imagem']);
                   unlink('../public_html/uploads/banner/'.$_POST['id_imagem']);
                   echo $_POST['id_imagem'];
               }
            }
        }else{
            if($_POST['id_imagem']){
                //unlink('../gestor/uploads/banner/'.$_POST['id_imagem']);
                unlink('../public_html/uploads/banner/'.$_POST['id_imagem']);
                echo $_POST['id_imagem'];
            }
        }

    }

}