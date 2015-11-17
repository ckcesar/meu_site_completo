<?php

namespace Application\Controller;

use Application\Http\Request;
use Application\Exception\FileNotFoundException;

abstract class AbstractController implements ControllerInterface {

    public function __call($class, $params) {
        $this->error($class, $params);
    }

    /**
     * Metodo executado antes de qualquer action
     */
    public function init() {
        
    }

    /**
     * Mostra a view
     * 
     * @param string $name Nome da view
     * @param mixed $data Dados a serem passados para a view
     * @return boolean
     */
    public function view($name, $data = null) {

        if (is_array($data)) {
            extract($data, EXTR_PREFIX_ALL, "view");
        } elseif (is_object($data)) {
            $view = $data;
        }

        $path = ROOT . DS . "Application/View/" . $name . ".phtml";
        if (!file_exists($path)) :
            throw new FileNotFoundException("The view file was not found", 1);
        else :
            return include $path;
        endif;

        exit;
    }

    /**
     * Retorna um objeto do tipo Request com os parâmetros da requisição
     * 
     * @return Application\Http\Request
     */
    public function getRequest() {

        $request = new Request();

        $request->setParams(filter_input_array(INPUT_GET));
        $request->setPost(filter_input_array(INPUT_POST));

        $url  = filter_input(INPUT_SERVER, "REQUEST_SCHEME", FILTER_SANITIZE_STRING) . "://";
        $url .= filter_input(INPUT_SERVER, "HTTP_HOST", FILTER_SANITIZE_STRING);
        $url .= filter_input(INPUT_SERVER, "REQUEST_URI", FILTER_SANITIZE_STRING);
        $request->setUrl($url);

        $method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_STRING);
        $request->setMethod($method);

        $host = filter_input(INPUT_SERVER, "HTTP_HOST", FILTER_SANITIZE_STRING);
        $request->setHost($host);

        $scheme = filter_input(INPUT_SERVER, "REQUEST_SCHEME", FILTER_SANITIZE_STRING);
        $request->setScheme($scheme);

        return $request;
    }

    /**
     * Redirecionar para a url informada
     * 
     * @param string $url
     * @return void
     */
    public function redirect($url = "/") {

        header("location: " . $url);
        exit;
    }

    public function index() {

        echo "Metodo padrao. Reescreva este metodo no controlador atual.";
    }

    public function error() {

        $this->redirect("/404.html");
    }

}