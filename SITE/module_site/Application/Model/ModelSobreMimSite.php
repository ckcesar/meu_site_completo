<?php

namespace Application\Model;


class ModelSobreMimSite extends Cliente{

    public function listar_sobre(){
        $resultset = $this->listar(" id_sobre, titulo, descricao, situacao "," situacao = '1' ", " id_sobre asc ", "1", null);
        return $resultset->asArray();
    }

}