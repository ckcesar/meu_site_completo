<?php

namespace Application\Controller;

class Sair extends AbstractController{

    public function index() {

        session_start();

        session_destroy();

        $this->view("Home");

    }

}