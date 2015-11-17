<?php

namespace Application\Controller;

use Application\Model\Itens;
use Application\ModelLogar;
use Application\Validator\validacao;
use Application\Validator\Validate;

class Logado extends AbstractController {

    public function index() {

        $this->view("Logado");

    }




}