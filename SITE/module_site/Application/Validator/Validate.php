<?php

namespace Application\Validator;

class Validate
{
    private $value;
    private $error;

    public function value($v)
    {
        $this->value = $v;
        return $this;
    }

    public function email()
    {
        if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/i", $this->value))
            $this->error[] = "Endereço de e-mail inválido";
    }

    public function fone()
    {
        if (!preg_match("/^\([0-9]{2}\)\s?[0-9]{4}\-[0-9]{4,5}/", $this->value))
            $this->error[] = "Número de telefone inválido";
    }

    public function isEmpty($fieldName)
    {
        if (!preg_match("/[a-z0-9]/i", $this->value))
            $this->error[] = "Preencha o campo <b>{$fieldName}</b>";
    }

    public function isValid()
    {
        return !count($this->error);
    }

    public function getErrors()
    {
        return $this->error;
    }

} 