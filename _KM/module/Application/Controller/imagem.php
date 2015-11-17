<?php

namespace Application\Controller;

use Application\Model\Itens;
use Application\Model\Noticias;
use Application\Validator\validacao;
use Application\Validator\Validate;
use Eventviva\ImageResize;

class Imagem extends AbstractController {

    public function index($width, $height) {
        $w = filter_var($width, FILTER_SANITIZE_NUMBER_INT);
        $h = filter_var($height, FILTER_SANITIZE_NUMBER_INT);
        $url = filter_input(INPUT_GET, "url", FILTER_SANITIZE_STRING);
        //exit($h);
        $imagem = new ImageResize(getcwd() . "/{$url}");
        $imagem->crop($w, $h)->output();
    }
}