<?php

namespace Application;

class Application {

    private $controller;
    private $ctl = "home";
    private $act = "index";
    private $params = array();
    public $phpVersion;

    public function __construct() {

        $this->phpVersion = (float) PHP_VERSION;
        $this->parseURL();
        $this->run();
    }
    
    public static function getBaseUrl() {
        
        return filter_input(INPUT_SERVER, "REQUEST_SCHEME") . "://" . filter_input(INPUT_SERVER, "SERVER_NAME");
    }

    private function setController($name) {

        $this->ctl = $name;
        $this->act = "index";
    }

    private function getController() {

        return $this->ctl;
    }

    private function setAction($name) {

        $this->act = $name;
    }

    private function getAction() {

        return $this->act;
    }

    private function parseURL() {

        $ctl = filter_input(INPUT_GET, "ctl", FILTER_SANITIZE_STRING);
        $act = filter_input(INPUT_GET, "act", FILTER_SANITIZE_STRING);
        $str = filter_input(INPUT_GET, "str", FILTER_SANITIZE_STRING);

        if (!empty($ctl)) {
            $this->setController($ctl);

            if (!empty($act)) {
                $this->setAction(str_replace("-", "", $act));
                $this->params = !empty($str) ? explode("/", $str) : array();
                unset($_GET["act"]);
                unset($_GET["str"]);
            }
            unset($_GET["ctl"]);
        }
    }

    private function run() {

        $controller = "Application\Controller\\" . $this->getController();
        $action = $this->getAction();

        /* E necessario verificar se o arquivo existe antes de instanciar a classe */
        $path = ROOT . DS . str_replace("\\", DS, $controller) . ".php";

        if (file_exists($path)) {
            $this->controller = new $controller;
            $this->controller->init();
            call_user_func_array(array($this->controller, $action), $this->params);
        } else {
            echo "Test";
            //header("location: /404.html");
            exit;
        }
    }

}