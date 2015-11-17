<?php

namespace Application\Controller;

use Application\Model\ModelBannerSite;
use Application\Model\ModelNoticiasSite;

class todasNoticias extends AbstractController{


    public function index(){

        $banner = new ModelBannerSite("banner a, midia b");
        $dados['listar_banner'] = $banner->listar_banner();

        $noticias = new ModelNoticiasSite("noticias");
        $dados['listar_noticias'] = $noticias->listar_todas();

        $this->view("TodasNoticias",$dados);
    }


}