<?php

namespace Application\Model;


class ModelNoticiasSite extends Cliente{

    public function listar_geral(){
        $resultset = $this->listar(" id_noticias, titulo, DATE_FORMAT(data_mostrar, '%d/%m/%Y') as data_mostrar "," situacao = '1' ", " id_noticias desc ", "6", null);
        return $resultset->asArray();
    }

    public function listar_fotos($id_noticias_fotos){
        $resultset = $this->listar(" a.id_noticias, a.titulo, sub_titulo, DATE_FORMAT(a.data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar,
                                     DATE_FORMAT(a.data_final, '%d/%m/%Y %H:%i') as data_final, a.situacao, b.principal, b.url ",
            " a.situacao = '1' and a.id_noticias = '$id_noticias_fotos' ", null, null, null);
        return $resultset->asArray();
    }

    public function listar_mostrar_noticia($id_noticia){
        $resultset = $this->listar(" id_noticias, titulo, descricao, sub_titulo, DATE_FORMAT(data_mostrar, '%d/%m/%Y') as data_mostrar "," id_noticias = '$id_noticia' and situacao = '1' ", null, "1", null);
        return $resultset->asArray();
    }

    public function listar_todas(){
        $resultset = $this->listar(" id_noticias, titulo, DATE_FORMAT(data_mostrar, '%d/%m/%Y') as data_mostrar "," situacao = '1' ", " id_noticias desc ", null, null);
        return $resultset->asArray();
    }

}