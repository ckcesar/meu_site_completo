<?php

namespace Application\Validator;

interface ValidatorInterface {

    public function isValid();
    public function getMessages();
}
