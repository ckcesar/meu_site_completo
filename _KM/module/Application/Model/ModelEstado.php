<?php

namespace Application\Model;

class ModelEstado extends Cliente{

    public $codigo;
    public $estado;
    public $sigla;

    public function gravar_estado(){
         $dados = array('estado' => $this->estado, 'sigla' => $this->sigla);
         $this->insert($dados);
    }

    public function alterar_estado(){
        $id = 'id_estado';
        $cod = $this->codigo;
        $dados = array('estado' => $this->estado, 'sigla' => $this->sigla);
        $where = $id. " = ".$cod;
        $this->update($dados, $where);
    }

    public function deletar_estado(){
        $id = 'id_estado';
        $cd = $this->codigo;
        $where = $id. " = " .$cd;
        $this->del($where);
    }

    public function listar_estado_geral(){
        $resultset = $this->listar("id_estado, estado, sigla", null, " estado asc ", null, null);
        return $resultset->asArray();
    }

    public function listar_estado_cod($id){
        $resultset = $this->listar("id_estado, estado, sigla","id_estado = '$id'", "id_estado asc", null, null);
        return $resultset->asArray();
    }

    public function listar_estado_desc($desc){
       $resultset = $this->listar("id_estado, estado, sigla","estado like '%".$desc."%' ", "id_estado asc", null, null);
       return $resultset->asArray();
    }


}


?>