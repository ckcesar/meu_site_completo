<?php

namespace Application\Model;

class ModelUsuario extends Cliente{

    public $id_usuario;
    public $nome;
    public $email;
    public $login;
    public $senha;
    public $data_cadastro;
    public $tipo;
    public $situacao;

    public function gravar_usuario(){

        $dados = array('nome' => $this->nome,
            'email'         => $this->email,
            'login'         => $this->login,
            'senha'         => md5($this->senha),
            'data_cadastro' => date('Y-m-d H:i:s'),
            'tipo_usuario'  => $this->tipo,
            'situacao'      => '1' );
        $this->insert($dados);

    }

    public function alterar_usuario(){

        $id = 'id_usuario';
        $cod = $this->id_usuario;
        $dados = array('nome' => $this->nome,
            'email'         => $this->email,
            'tipo_usuario'  => $this->tipo);
        $where = $id. " = ".$cod;
        $this->update($dados, $where);
    }

    public function situacao(){
        $id = 'id_usuario';
        $cod = $this->id_usuario;

        if($this->situacao === '0'){
            $sit = '1';
        }else if($this->situacao === '1'){
            $sit = '0';
        }

        $dados = array('situacao' => $sit);
        $where = $id. " = ".$cod;
        $this->update($dados, $where);
    }

    public function deletar_usuario(){
        $id = 'id_usuario';
        $cd = $this->id_usuario;
        $where = $id. " = " .$cd;
        $this->del($where);
    }



    public function listar_usuario_geral(){
        $resultset = $this->listar("id_usuario, nome, email, login, senha, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro,  tipo_usuario, situacao ", " tipo_usuario <> 'Administrador' ", " id_usuario desc ", null, null);
        return $resultset->asArray();
    }

    public function listar_usuario_cod($id){
        $resultset = $this->listar("id_usuario, nome, email, login, senha, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro,  tipo_usuario, situacao ","id_usuario = '$id' and tipo_usuario <> 'Administrador' ", "id_usuario desc", null, null);
        return $resultset->asArray();
    }

    public function listar_usuario_desc($desc){
        $resultset = $this->listar(" id_usuario, nome, email, login, senha, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro,  tipo_usuario, situacao "," nome like '%".$desc."%' and tipo_usuario <> 'Administrador' ", " id_usuario desc", null, null);
        return $resultset->asArray();
    }

    public function listar_usuario_sit($id){
        $resultset = $this->listar("id_usuario, nome, email, login, senha, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro,  tipo_usuario, situacao ","id_usuario = '$id' ", "id_usuario desc", null, null);
        return $resultset->asArray();
    }

    public function lista_usuario($usuario){
        $resultset = $this->listar("id_usuario, nome, email, login, senha, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro,  tipo_usuario, situacao "," login = '$usuario' ", "id_usuario desc", " 1 ", null);
        return $resultset->asArray();
    }

    //public function lista_logar($login,$senha){
        //$resultset = $this->listar("id_usuario, nome, email, login, senha, DATE_FORMAT(data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro,  tipo_usuario, situacao "," login = '$login' and senha = '$senha' and (situacao = '1' OR situacao = '2') ", "id_usuario desc", " 1 ", null);
        //return $resultset->asArray();
    //}

    public function lista_logar($login,$senha){
        $resultset = $this->listar("c.url, a.id_usuario, a.nome, a.email, a.login, a.senha, DATE_FORMAT(a.data_cadastro, '%d/%m/%Y - %H:%i') as data_cadastro,  a.tipo_usuario, a.situacao "," b.id_usuario = a.id_usuario and c.id_acessos_id = b.id_acessos_id and a.login = '$login' and a.senha = '$senha' and (a.situacao = '1' OR a.situacao = '2') ", "a.id_usuario desc", null, null);
        return $resultset->asArray();
    }


}