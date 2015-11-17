<?php

namespace Application\Validator;

abstract class AbstractValidator implements ValidatorInterface {
    
    protected $messages;
    
    /**
     * Adicionar uma mensagem a lista
     * 
     * @param string $message
     * @return void
     */
    protected function addMessage($message) {
        $this->messages[] = $message;
    }
    
    /**
     * Verificar se existe alguma mensagem de erro ou informação
     * 
     * @return boolean
     */
    public function isValid() {
        return count($this->messages) > 0;
    }
    
    /**
     * Retorna como uma array as mensagens armazenadas durante o processo
     * 
     * @return array
     */
    public function getMessages() {
        return array_unique($this->messages);
    }

}
