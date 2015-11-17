<?php

namespace Application\Validator;

class Validar_Data{

    function passar_br($data){
        $data = \DateTime::createFromFormat('Y-m-d H:i:s',$data);
         return $data->format('d/m/Y H:i');
    }

}