<?php

namespace Application\Model;



class ModelCidade extends Cliente{

   public $codigo;
   public $estado;
   public $cidade;

   public function gravar_cidade(){
       $dados = array('cadastrar_estado_id_estado' => $this->estado, 'cidade' => $this->cidade);
       $this->insert($dados);
   }

   public function alterar_cidade(){
      $id  = "id_cidade";
      $cod = $this->codigo;
      $dados = array('cadastrar_estado_id_estado' => $this->estado, 'cidade' => $this->cidade);
      $where = $id ." = ".$cod;
      $this->update($dados,$where);
   }

   public function deletar_cidade(){
     $id = "id_cidade";
     $cod = $this->codigo;
     $where = $id ." = ".$cod;
     $this->del($where);

   }

   public function listar_cidade_geral(){
       $resultset = $this->listar("a.id_cidade, a.cadastrar_estado_id_estado, a.cidade, b.estado","a.cadastrar_estado_id_estado = b.id_estado","a.cidade asc", null, null);
       return $resultset->asArray();
   }

   public function listar_cidade_cod($id){
       $resultset = $this->listar("a.id_cidade, a.cadastrar_estado_id_estado, a.cidade, b.estado","a.cadastrar_estado_id_estado = b.id_estado and a.id_cidade = '$id'","a.cidade asc", null, null);
       return $resultset->asArray();
   }

   public function listar_cidade_desc($desc){
       $resultset = $this->listar("a.id_cidade, a.cadastrar_estado_id_estado, a.cidade, b.estado","a.cadastrar_estado_id_estado = b.id_estado and a.cidade like '%".$desc."%' ","a.cidade asc", null, null);
       return $resultset->asArray();
   }

}