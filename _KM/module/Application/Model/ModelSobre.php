<?php


namespace Application\Model;

class ModelSobre extends Cliente{

    public $id_sobre;
    public $titulo;
    public $descricao;
    public $situacao;

    public function gravar_sobre(){

        $dados = array('titulo' => $this->titulo,
            'descricao'         => $this->descricao,
            'situacao'          => '1' );
        $this->insert($dados);

    }

    public function alterar_sobre(){

        $id = 'id_sobre';
        $cod = $this->id_sobre;
        $dados = array('titulo'     => $this->titulo,
                       'descricao'  => $this->descricao);
        $where = $id. " = ".$cod;
        $this->update($dados, $where);

    }

    public function situacao(){
        $id = 'id_sobre';
        $cod = $this->id_sobre;

        if($this->situacao === '0'){
            $sit = '1';
        }else if($this->situacao === '1'){
            $sit = '0';
        }

        $dados = array('situacao' => $sit);
        $where = $id. " = ".$cod;
        $this->update($dados, $where);
    }

    public function deletar_sobre(){
        $id = 'id_sobre';
        $cd = $this->id_sobre;
        $where = $id. " = " .$cd;
        $this->del($where);
    }

    public function listar_sobre_geral(){
        $resultset = $this->listar("id_sobre, titulo, descricao, situacao ", null, " id_sobre desc ", null, null);
        return $resultset->asArray();
    }

    public function listar_sobre_cod($id){
        $resultset = $this->listar("id_sobre, titulo, descricao, situacao ","id_sobre = '$id' ", "id_sobre desc", null, null);
        return $resultset->asArray();
    }

    public function listar_sobre_desc($desc){
        $resultset = $this->listar("id_sobre, titulo, descricao, situacao "," titulo like '%".$desc."%' ", " id_sobre desc", null, null);
        return $resultset->asArray();
    }

    public function listar_sobre_sit($id){
        $resultset = $this->listar("id_sobre, titulo, descricao, situacao "," id_sobre = '$id' ", "id_sobre desc", null, null);
        return $resultset->asArray();
    }

    public function ultimoIdSobre(){
        $resultset = $this->listar("id_sobre ", null, " id_sobre desc", " 1 ", null);
        return $resultset->asArray();
    }


}