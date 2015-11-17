<?php

namespace Application\Controller;

use Application\Model\ModelBannerSite;
use Application\Model\ModelNoticiasSite;

class Noticia extends AbstractController{

    public function ler($id){

        $banner = new ModelBannerSite("banner a, midia b");
        $dados['listar_banner'] = $banner->listar_banner();

        $noticia = new ModelNoticiasSite("noticias");
        $dados['lista_noticia'] = $noticia->listar_mostrar_noticia($id);

        $listar_foto_noticia = new ModelNoticiasSite("noticias a left join midia b on b.id_noticias = a.id_noticias ");
        $dados['listar_foto_noticia'] = $listar_foto_noticia;


        if($dados['lista_noticia']){
            $this->view("Noticia",$dados);
        }else{
            $banner = new ModelBannerSite("banner a, midia b");
            $dados['listar_banner'] = $banner->listar_banner();
            $this->view("NoticiaVazia",$dados);
        }

    }


}