<?php

namespace Application\Model;


class ModelBanner extends Cliente{

  public $id_banner;
  public $titulo;
  public $data_cadastro;
  public $data_mostrar;
  public $data_final;
  public $situacao;

  public function gravar_banner(){

      $data_01 = \DateTime::createFromFormat('d/m/Y H:i',$this->data_mostrar);

      if($this->data_final !== ''){
          $data_02 = \DateTime::createFromFormat('d/m/Y H:i',$this->data_final);
          $data_pronta = $data_02->format('Y-m-d H:i:s');
      }else{
          $data_pronta = '0000-00-00 00:00:00';
      }


      $dados = array('titulo' => $this->titulo,
          'data_cadastro'     => date('Y-m-d H:i:s'),
          'data_mostrar'      => $data_01->format('Y-m-d H:i:s'),
          'data_final'        => $data_pronta,
          'situacao'          => '1' );
      $this->insert($dados);
  }

  public function alterar_banner(){

          $data_01 = \DateTime::createFromFormat('d/m/Y H:i',$this->data_mostrar);

          if($this->data_final !== ''){
              $data_02 = \DateTime::createFromFormat('d/m/Y H:i',$this->data_final);
              $data_pronta = $data_02->format('Y-m-d H:i:s');
          }else{
              $data_pronta = '0000-00-00 00:00:00';
          }

        $id = 'id_banner';
        $cod = $this->id_banner;
        $dados = array('titulo' => $this->titulo,
            'data_mostrar'      => $data_01->format('Y-m-d H:i:s'),
            'data_final'        => $data_pronta);
        $where = $id. " = ".$cod;
        $this->update($dados, $where);
  }

  public function deletar_banner(){
        $id = 'id_banner';
        $cd = $this->id_banner;
        $where = $id. " = " .$cd;
        $this->del($where);
  }

  public function situacao(){
      $id = 'id_banner';
      $cod = $this->id_banner;

      if($this->situacao === '0'){
          $sit = '1';
      }else if($this->situacao === '1'){
          $sit = '0';
      }

      $dados = array('situacao' => $sit);
      $where = $id. " = ".$cod;
      $this->update($dados, $where);
  }

  public function listar_banner_geral($ini,$qtd){
        $resultset = $this->listar("id_banner, titulo, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro, DATE_FORMAT(data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar, DATE_FORMAT(data_final, '%d/%m/%Y %H:%i') as data_final, situacao ", null, " id_banner desc ", " $ini,$qtd ", null);
        return $resultset->asArray();
  }

  public function listar_banner_cod($id){
        $resultset = $this->listar("id_banner, titulo, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro, DATE_FORMAT(data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar, DATE_FORMAT(data_final, '%d/%m/%Y %H:%i') as data_final, situacao ","id_banner = '$id' ", "id_banner desc", null, null);
        return $resultset->asArray();
  }

  public function listar_banner_desc($desc){
        $resultset = $this->listar(" id_banner, titulo, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro, DATE_FORMAT(data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar, DATE_FORMAT(data_final, '%d/%m/%Y %H:%i') as data_final, situacao "," titulo like '%".$desc."%' ", " id_banner desc", null, null);
        return $resultset->asArray();
  }

  public function listar_banner_sit($id){
        $resultset = $this->listar("id_banner, titulo, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro, DATE_FORMAT(data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar, DATE_FORMAT(data_final, '%d/%m/%Y %H:%i') as data_final, situacao ","id_banner = '$id' ", "id_banner desc", null, null);
        return $resultset->asArray();
  }

  public function ultimoIdBanner(){
      $resultset = $this->listar("id_banner ", null, " id_banner desc", " 1 ", null);
      return $resultset->asArray();
  }

}