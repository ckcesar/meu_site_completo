<?php

namespace Application\Model;

class ModelNoticia extends Cliente{

    public $id_noticias;
    public $titulo;
    public $sub;
    public $descricao;
    public $data_cadastro;
    public $data_mostrar;
    public $data_final;
    public $situacao;

    public function gravar_noticias(){

        $data_01 = \DateTime::createFromFormat('d/m/Y H:i',$this->data_mostrar);

        if($this->data_final !== ''){
            $data_02 = \DateTime::createFromFormat('d/m/Y H:i',$this->data_final);
            $data_pronta = $data_02->format('Y-m-d H:i:s');
        }else{
            $data_pronta = '0000-00-00 00:00:00';
        }


        $dados = array('titulo' => $this->titulo,
            'sub_titulo'        => $this->sub,
            'descricao'         => $this->descricao,
            'data_cadastro'     => date('Y-m-d H:i:s'),
            'data_mostrar'      => $data_01->format('Y-m-d H:i:s'),
            'data_final'        => $data_pronta,
            'situacao'          => '1' );
        $this->insert($dados);

    }

    public function alterar_noticias(){

        $data_01 = \DateTime::createFromFormat('d/m/Y H:i',$this->data_mostrar);

        if($this->data_final !== ''){
            $data_02 = \DateTime::createFromFormat('d/m/Y H:i',$this->data_final);
            $data_pronta = $data_02->format('Y-m-d H:i:s');
        }else{
            $data_pronta = '0000-00-00 00:00:00';
        }

        $id = 'id_noticias';
        $cod = $this->id_noticias;
        $dados = array('titulo' => $this->titulo,
            'sub_titulo'        => $this->sub,
            'descricao'         => $this->descricao,
            'data_mostrar'      => $data_01->format('Y-m-d H:i:s'),
            'data_final'        => $data_pronta);
        $where = $id. " = ".$cod;
        $this->update($dados, $where);

    }

    public function situacao(){
        $id = 'id_noticias';
        $cod = $this->id_noticias;

        if($this->situacao === '0'){
            $sit = '1';
        }else if($this->situacao === '1'){
            $sit = '0';
        }

        $dados = array('situacao' => $sit);
        $where = $id. " = ".$cod;
        $this->update($dados, $where);
    }

    public function deletar_noticias(){
        $id = 'id_noticias';
        $cd = $this->id_noticias;
        $where = $id. " = " .$cd;
        $this->del($where);
    }

    public function listar_noticia_geral($ini,$qtd){
        $resultset = $this->listar("id_noticias, titulo, sub_titulo, descricao, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro, DATE_FORMAT(data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar, DATE_FORMAT(data_final, '%d/%m/%Y %H:%i') as data_final, situacao ", null, " id_noticias desc ", " $ini,$qtd ", null);
        return $resultset->asArray();
    }

    public function listar_noticia_cod($id){
        $resultset = $this->listar("id_noticias, titulo, sub_titulo, descricao, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro, DATE_FORMAT(data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar, DATE_FORMAT(data_final, '%d/%m/%Y %H:%i') as data_final, situacao ","id_noticias = '$id' ", "id_noticias desc", null, null);
        return $resultset->asArray();
    }

    public function listar_noticia_desc($desc){
        $resultset = $this->listar(" id_noticias, titulo, sub_titulo, descricao, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro, DATE_FORMAT(data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar, DATE_FORMAT(data_final, '%d/%m/%Y %H:%i') as data_final, situacao "," titulo like '%".$desc."%' ", " id_noticias desc", null, null);
        return $resultset->asArray();
    }

    public function listar_noticia_sit($id){
        $resultset = $this->listar("id_noticias, titulo, sub_titulo, descricao, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro, DATE_FORMAT(data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar, DATE_FORMAT(data_final, '%d/%m/%Y %H:%i') as data_final, situacao ","id_noticias = '$id' ", "id_noticias desc", null, null);
        return $resultset->asArray();
    }

    public function ultimoIdNoticias(){
        $resultset = $this->listar("id_noticias ", null, " id_noticias desc", " 1 ", null);
        return $resultset->asArray();
    }


}