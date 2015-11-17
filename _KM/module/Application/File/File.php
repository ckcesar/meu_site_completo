<?php

/**
 * File
 * 
 * Classe para manipulação de arquivos
 * 
 * ERRO 1 - Arquivo não encontrado - Gerado quando se tenta copiar, mover ou excluir um arquivo e o mesmo não existe.
 * ERRO 2 - Arquivo já existe - Gerado quando se tenta salvar um arquivo e o mesmo já existe.
 */

namespace Application\File;

class File {

    protected $path;
    protected $name;
    protected $extension;
    protected $size;
    protected $content = null;

    public function __construct($path = "") {

        if (!empty($path)) :
            // Substitui as barras pelo separador de diretórios do sistema
            $path = preg_replace("/[\/\\\]/i", DIRECTORY_SEPARATOR, $path);
            $this->path = $path;
            $this->getInfo();
        endif;
    }

    /**
     * Retorna o caminho completo do arquivo
     * 
     * @return string
     */
    public function getPath() {

        return $this->path;
    }

    /**
     * Retorna o nome do arquivo
     * 
     * @return string
     */
    public function getName() {

        return $this->name;
    }

    /**
     * Retorna a extenção do arquivo
     * 
     * @return string
     */
    public function getExtension() {

        return $this->extension;
    }

    /**
     * Put the content into the file
     * 
     * @return void
     */
    public function setContent($content) {

        $this->content = $content;
    }

    /**
     * Retorna o conteúdo do arquivo
     * 
     * @return mixed
     */
    public function getContent() {

        return $this->content;
    }

    /**
     * Retorna o tamanho do arquivo no disco em bytes
     * 
     * @return float
     */
    public function getSize() {

        return $this->size;
    }

    /**
     * Obtem informações do arquivo
     * 
     */
    private function getInfo() {

        $this->name = substr(strrchr($this->path, DIRECTORY_SEPARATOR), 1);
        $this->extension = strtolower(substr(strrchr($this->name, "."), 1));

        if ($this->exists()) :
            $this->size = filesize($this->path);
            $this->content = file_get_contents($this->path);
        endif;
    }

    /**
     * Verifica se o arquivo existe
     * 
     * @return boolean
     */
    public function exists() {

        return file_exists($this->path);
    }

    /**
     * Salva o arquivo
     * 
     * @param boolean $overwrite Reescreve o arquivo caso já exista
     * @return boolean
     */
    public function save($overwrite = false) {

        if ($this->exists() && !$overwrite)
            throw new Exception\FileException("File already exists", 2);

        if (!file_put_contents($this->path, $this->content))
            throw new Exception\FileException("Unknown error", 0);

        return true;
    }

    /**
     * Faz uma cópia do arquivo
     * 
     * @param string $path Novo nome do arquivo
     * @return boolean
     */
    public function copy($path) {

        if (!$this->exists())
            throw new Exception\FileException("File not found", 1);

        if (!copy($this->path, $path))
            throw new Exception\FileException("Unknown error", 0);

        return true;
    }

    /**
     * Move o arquivo com novo ou mesmo nome
     * 
     * @param $path Novo nome do arquivo
     * @return boolean
     */
    public function move($path) {

        if (!$this->exists())
            throw new Exception\FileException("File not found", 1);

        if (!rename($this->path, $path))
            throw new Exception\FileException("Unknown error", 0);

        return true;
    }

    /**
     * Exclui o arquivo
     * 
     * @return boolean
     */
    public function delete() {

        if (!$this->exists())
            throw new Exception\FileException("File not found", 1);

        if (!unlink($this->path))
            throw new Exception\FileException("Unknown error", 0);

        return true;
    }

}
