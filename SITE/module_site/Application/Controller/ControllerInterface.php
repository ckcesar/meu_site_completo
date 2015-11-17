<?php

namespace Application\Controller;

interface ControllerInterface {

    /**
     * Executado antes de qualquer método do controlador
     * Não recebe nenhuma parâmetro, pois é executado pelo sistema
     * 
     * @return null
     */
    public function init();
}