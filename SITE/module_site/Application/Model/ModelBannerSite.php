<?php

namespace Application\Model;


class ModelBannerSite extends Cliente{

    public function listar_banner(){
        $resultset = $this->listar("a.id_banner, a.titulo, DATE_FORMAT(a.data_mostrar, '%d/%m/%Y %H:%i') as data_mostrar,
                                     DATE_FORMAT(a.data_final, '%d/%m/%Y %H:%i') as data_final, a.situacao, b.principal, b.url ",
            " a.id_banner = b.id_banner and b.principal = '1' and a.situacao = '1' and a.data_mostrar >= a.data_final ", " a.id_banner asc ", "1", null);
        return $resultset->asArray();
    }

}