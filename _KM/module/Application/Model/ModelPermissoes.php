<?php

namespace Application\Model;

class ModelPermissoes extends Cliente{

    public $id_acessos_usuario;
    public $id_usuario;
    public $id_acessos_id;


    public function gravar_acessos(){

        $dados = array('id_usuario' => $this->id_usuario,
                       'id_acessos_id' => $this->id_acessos_id );
        $this->insert($dados);

    }

    public function deletar_acessos(){
        $id = 'id_acessos_usuario';
        $cd = $this->id_acessos_usuario;
        $where = $id. " = " .$cd;
        $this->del($where);
    }

    public function deletar_acessos_usuario(){
        $id = 'id_acessos_usuario';
        $cd = $this->id_acessos_usuario;
        $where = $id. " = " .$cd;

        $this->del($where);

    }

    public function listar_usuario_geral(){
        $resultset = $this->listar("id_usuario, nome, email, login, senha, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro,  tipo_usuario, situacao ", " situacao = '1' ", " id_usuario desc ", null, null);
        return $resultset->asArray();
    }

    public function listar_acessos_geral(){
        $resultset = $this->listar(" id_acessos_id, nome, url, situacao ", " situacao = '1' ", " id_acessos_id desc ", null, null);
        return $resultset->asArray();
    }

    public function listar_acessos_checados($usuario, $tela){
        $resultset = $this->listar(" a.id_acessos_id, a.nome, a.url, a.situacao ", " a.id_acessos_id = b.id_acessos_id and b.id_usuario = c.id_usuario and b.id_usuario = '$usuario' and b.id_acessos_id = '$tela' ", null, null, null);
        return $resultset->asArray();
    }

    public function listar_todos_acessos(){
        $resultset = $this->listar(" a.id_acessos_id, a.nome, a.url, a.situacao, c.nome as NomeUsuario, b.id_acessos_usuario ", " a.id_acessos_id = b.id_acessos_id and b.id_usuario = c.id_usuario and c.tipo_usuario <> 'Administrador' ", null, null, null);
        return $resultset->asArray();
    }

    public function listar_id_acessos($id){
        $resultset = $this->listar(" a.id_acessos_id, a.nome, a.url, a.situacao, c.nome as NomeUsuario, b.id_acessos_usuario ", " a.id_acessos_id = b.id_acessos_id and b.id_usuario = c.id_usuario and b.id_acessos_usuario = '$id' and c.tipo_usuario <> 'Administrador' ", null, null, null);
        return $resultset->asArray();
    }

    public function listar_nome_acessos($nome){
        $resultset = $this->listar(" a.id_acessos_id, a.nome, a.url, a.situacao, c.nome as NomeUsuario, b.id_acessos_usuario ", " a.id_acessos_id = b.id_acessos_id and b.id_usuario = c.id_usuario and c.nome like '%".$nome."%' and c.tipo_usuario <> 'Administrador' ", null, null, null);
        return $resultset->asArray();
    }

    public function lista_deletar_acessos($del_acessos){
        $resultset = $this->listar(" id_acessos_usuario, id_usuario "," id_usuario = '$del_acessos' ", null, null, null);
        return $resultset->asArray();
    }



}