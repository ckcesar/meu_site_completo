<?php

namespace Application\Database;

class ResultSet {
    
    /**
     * Indica a posição atual do cursor
     * @var int
     */
    private $index = 0;
    
    /**
     * Armazena a quantidade de registro
     * @var int
     */
    private $length = 0;
    
    /**
     * Aemazena o conjunto de dados retornado pela consulta no banco
     * @var array
     */
    private $resource;

    public function __construct($resource) {
        $this->resource = is_array($resource) ? $resource : null;
        $this->length = count($resource);
    }
    
    /**
     * Posiciona o cursor no primeiro registro
     * 
     * @return void
     */
    public function first() {
        $this->index = 0;
    }
    
    /**
     * Posiciona o cursor no próximo registro
     * 
     * @return boolean
     */
    public function next() {
        if ($this->index < ($this->length - 1)) {
            $this->index++;
            return true;
        }
    }
    
    /**
     * Retorna a quantidade de registros
     * 
     * @return int
     */
    public function count() {
        return $this->length;
    }
    
    /**
     * Obtem um valor em uma posição específica nos registros
     * 
     * @param int $index
     * @param string $name
     * @return mixed|null
     */
    public function getValueAt($index, $name) {
        return isset($this->resource[$index]->$name) ? $this->resource[$index]->$name : null;
    }
    
    /**
     * Obtem o valor da posição atual do cursor
     * 
     * @param string $name
     * @return mixed|null
     */
    public function getValue($name) {
        return $this->getValueAt($this->index, $name);
    }
    
    /**
     * Obtem o valor da posição atual do cursor convertido em inteiro
     * 
     * @param string $name
     * @return int
     */
    public function getInt($name) {
        return (int) $this->getValueAt($this->index, $name);
    }
    
    /**
     * Obtem o valor da posição atual do cursor convertido em float
     * 
     * @param string $name
     * @return float
     */
    public function getFloat($name) {
        return (float) $this->getValueAt($this->index, $name);
    }
    
    /**
     * Retorna o conjunto de dados em formato de matriz
     * 
     * @return array
     */
    public function asArray() {
        return $this->resource;
    }

}
