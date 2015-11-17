<?php

namespace Application\Http;

class Request {

    const METHOD_GET = "GET";
    const METHOD_POST = "POST";

    private $params;
    private $post;
    private $method;
    private $url;
    private $host;
    private $scheme;

    public function __construct($url = null) {

        if ($url) { $this->setUrl($url); }
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getMethod() {
        return $this->method;
    }

    public function isPost() {
        return $this->method == "POST";
    }

    public function setPost($post) {
        $this->post = $post;
    }

    public function getPost($name) {
        return $this->post[$name];
    }

    public function setParams($params) {
        $this->params = $params;
    }

    public function getParam($name) {
        return $this->params[$name];
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function setScheme($scheme) {
        $this->scheme = $scheme;
    }

}