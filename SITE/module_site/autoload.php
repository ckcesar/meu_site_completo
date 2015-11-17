<?php

define("ROOT", __DIR__);
define("DS", DIRECTORY_SEPARATOR);
define("URL_NOTICIA", 'http://projeto.cesar/uploads/noticias/');
define("URL_BANNER", 'http://projeto.cesar/uploads/banner/');

spl_autoload_register(function($class) {

    $class = ltrim($class, "\\");
    $path = ROOT . DS . $class . ".php";
    $path = str_replace("\\", DS, $path);

    if (file_exists($path))
        require_once $path;
});