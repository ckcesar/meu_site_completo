<?php

namespace Application\Model;

class ModelMidia extends Cliente{

    public $id_midia;
    public $tipo;
    public $url;
    public $url_mini;
    public $principal;
    public $id_banner;
    public $id_noticias;
    public $id_sobre;

    public function gravar_midia(){

        $dados = array('tipo' => $this->tipo,
            'url'       => $this->url,
            'url_mini'  => $this->url_mini,
            'principal' => $this->principal,
            'id_banner' => $this->id_banner,
            'id_noticias' => $this->id_noticias,
            'id_sobre'  => $this->id_sobre);
        $this->insert($dados);
    }

    public function alt_radio(){

        $banner = 'id_banner';
        $cod_banner = $this->id_banner;

        $noticias = 'id_noticias';
        $cod_noticias = $this->id_noticias;

        $sobre = 'id_sobre';
        $cod_sobre = $this->id_sobre;

        $dados = array('principal' => '0');
        if($cod_banner){
            $where = $banner. " = ".$cod_banner;
            $this->update($dados, $where);
        }elseif($cod_noticias){
            $where = $noticias. " = ".$cod_noticias;
            $this->update($dados, $where);
        }elseif($cod_sobre){
            $where = $sobre. " = ".$cod_sobre;
            $this->update($dados, $where);
        }


        $id = 'id_midia';
        $cod = $this->id_midia;

        $dados = array('principal' => '1');
        $where = $id. " = ".$cod;
        $this->update($dados, $where);
    }

    public function alt_radios_acrescentados(){
        $banner = 'id_banner';
        $cod_banner = $this->id_banner;

        $noticias = 'id_noticias';
        $cod_noticias = $this->id_noticias;

        $sobre = 'id_sobre';
        $cod_sobre = $this->id_sobre;

        $dados = array('principal' => '0');
        if($cod_banner){
            $where = $banner. " = ".$cod_banner;
            $this->update($dados, $where);
        }elseif($cod_noticias){
            $where = $noticias. " = ".$cod_noticias;
            $this->update($dados, $where);
        }elseif($cod_sobre){
            $where = $sobre. " = ".$cod_sobre;
            $this->update($dados, $where);
        }


    }

    public function listar_midia($id){
        $resultset = $this->listar(" id_midia, url, url_mini, principal, id_banner ", " id_banner = '$id' ", null, null, null);
        return $resultset->asArray();
    }

    public function listar_midia_noticias($id){
        $resultset = $this->listar(" id_midia, url, url_mini, principal, id_noticias ", " id_noticias = '$id' ", null, null, null);
        return $resultset->asArray();
    }

    public function listar_midia_sobre($id){
        $resultset = $this->listar(" id_midia, url, url_mini, principal, id_sobre ", " id_sobre = '$id' ", null, null, null);
        return $resultset->asArray();
    }

    public function listar_para_alt($url){
        $resultset = $this->listar(" id_midia, url, url_mini, principal, id_banner, id_noticias, id_sobre ", " url = '$url' ",null,null,null);
        return $resultset->asArray();
    }

    public function alterar_acrecentar_radio($codigo){
        $resultset = $this->listar(" id_midia, url, url_mini, principal, id_banner, id_noticias, id_sobre ", " id_banner = '$codigo' OR (id_noticias = '$codigo') OR (id_sobre = '$codigo') ",null,null,null);
        return $resultset->asArray();
    }

    public function deletar_midia(){
        $id = 'id_midia';
        $cd = $this->id_midia;

        $where = $id. " = " .$cd;
        $this->del($where);
    }

}