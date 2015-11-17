<?php

/**
 * Upload
 * 
 * @link http://github.com/edvaldotsi
 */

namespace Application\File;

class Upload {

    private $file;
    private $count;
    private $maxFileSize = 2; // Valor informado em MB
    private $maxTotalSize = 200; // Valor informado em MB

    public function __construct($input = "anexo") {

        $this->file = isset($_FILES[$input]) ? $_FILES[$input] : null;

        if (!is_array($this->file["name"])):
            throw new Exception\InvalidArgumentException("Invalid input name");
        endif;

        $this->file = $_FILES[$input];
        $this->count = count($this->file["name"]);
    }

    /**
     * Retorna a quantidade de arquivos enviados
     * 
     * @return int
     */
    public function getCount() {

        return $this->count;
    }

    /**
     * Define o tamanho máximo de cada arquivo
     * 
     * @param float $size Tamanho máximo de cada arquivo
     * @return void
     */
    public function setMaxFileSize($size) {

        $this->maxFileSize = $size;
    }

    /**
     * Define o tamanho máximo total do envio
     * Deve ser menor ou igual a configuração do PHP
     * 
     * @param float $size Tamanho máximo total do envio
     * @return void
     */
    public function setMaxTotalSize($size) {

        $this->maxTotalSize = $size;
    }

    /**
     * Salva os arquivos enviados no diretório
     * 
     * @param string $path Diretório de destino
     * @return void
     */
    public function save($path) {

        if (!file_exists($path)):
            if (!mkdir($path, 0755, true)):
                throw new \Exception("Failed to create the directory");
            endif;
        endif;

        $f = new File("");

        for ($x = 0; $x < $this->getCount(); $x++):
            $ext = explode(".", $this->file["name"][$x]);
            $ext = end($ext);

            $f->setPath($this->file["tmp_name"][$x]);
            $f->copy("$path/");
        endfor;
    }

}
