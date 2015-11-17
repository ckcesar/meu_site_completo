<?php

/**
 * Image
 * 
 * @link http://github.com/edvaldotsi
 */

namespace Application\File;

class Image extends File {

    private $width;
    private $height;
    private $quality = 100;

    public function __construct($path = "") {
        parent::__construct($path);

        switch ($this->extension) {

            case "jpeg":
            case "jpg" : {
                    $this->content = @imageCreateFromJPEG($this->path);
                    break;
                }

            case "png" : {
                    $this->content = @imageCreateFromPNG($this->path);
                    break;
                }
        }

        if (!$this->content)
            throw new Exception\FileException("O arquivo não é um arquivo JPG ou PNG válido.");

        $this->getInfo();
    }

    private function getInfo() {
        $this->width = imagesX($this->content);
        $this->height = imagesY($this->content);
    }

    /**
     * Modifica a largura da imagem
     * 
     * @return void
     */
    public function setWidth($width) {

        $this->width = $width;
    }

    /**
     * Retorna a largura da imagem
     * 
     * @return float
     */
    public function getWidth() {

        return $this->width;
    }

    /**
     * Modifica a altura da imagem
     * 
     * @return void
     */
    public function setHeight($height) {

        $this->height = $height;
    }

    /**
     * Retorna a altura da imagem
     * 
     * @return float
     */
    public function getHeight() {

        return $this->height;
    }

    /**
     * Modifica a qualidade da imagem
     * 
     * @return void
     */
    public function setQuality($quality) {

        $this->quality = $quality;
    }

    /**
     * Retorna a qualidade da imagem
     * 
     * @return int
     */
    public function getQuality() {

        return $this->quality;
    }

    /**
     * Obtem o tamanho da imagem relativo a largura
     * 
     * @param int $width Largura da imagem
     */
    private function getSizeByWidth($width) {

        $ratio = $this->height / $this->width;
        return $width * $ratio;
    }

    /**
     * Obtem o tamanho da imagem relativo a altura
     * 
     * @param int $height Altura da imagem
     */
    private function getSizeByHeight($height) {

        $ratio = $this->width / $this->height;
        return $height * $ratio;
    }

    private function getSizeByAuto($width, $height) {

        if (is_null($width)) {
            $width = $this->getSizeByHeight($height);
        } elseif (is_null($height)) {
            $height = $this->getSizeByWidth($width);
        }

        return array($width, $height);
    }

    public function resize($width, $height) {

        // Verifica se um dos valores não foi informado e calcula proporcionalmente
        list($width, $height) = $this->getSizeByAuto($width, $height);

        $resource = $this->content;
        $this->content = imageCreateTrueColor($width, $height);

        if ($this->extension == "png") {
            imageColorTransparent($this->content, imageColorAllocateAlpha($this->content, 0, 0, 0, 127));
            imageAlphaBlending($this->content, false);
            imageSaveAlpha($this->content, true);
        }

        imageCopyResampled($this->content, $resource, 0, 0, 0, 0, $width, $height, $this->width, $this->height);

        $this->crop($width, $height);

        $this->getInfo(); // Atualiza as informações sobre a imagem
    }

    /**
     * Corta a imagem das dimensões especificadas
     * 
     * @param int $width Largura do corte
     * @param int $height Altura do corte
     */
    public function crop($width, $height) {

        // Verifica se um dos valores não foi informado e calcula proporcionalmente
        //list($width, $height) = $this->getSizeByAuto($width, $height);

        $startX = ($this->width / 2) - ($width / 2);
        $startY = ($this->height / 2) - ($height / 2);

        $resource = $this->content;
        $this->content = imageCreateTrueColor($width, $height);

        if ($this->extension == "png") {
            imageColorTransparent($this->content, imageColorAllocateAlpha($this->content, 0, 0, 0, 127));
            imageAlphaBlending($this->content, false);
            imageSaveAlpha($this->content, true);
        }

        imageCopyResampled($this->content, $resource, 0, 0, $startX, $startY, $width, $height, $width, $height);

        $this->getInfo(); // Atualiza as informações sobre a imagem
    }

    /**
     * Salva o arquivo
     * 
     */
    public function save($path = "", $overwrite = false) {

        $this->path = !empty($path) ? $path : $this->path;

        if ($this->exists() && !$overwrite)
            throw new Exception\FileException("File already exists", 2);

        switch ($this->extension) {

            case "jpeg":
            case "jpg" : {

                    imageJPEG($this->content, $this->path, $this->quality);
                    break;
                }

            case "png" : {

                    $quality = round($this->quality / 100 * 9); // Escalona a qualidade e inverte o valor
                    $quality = 9 - $quality; // 0 = maior qualidade e 9 = menor qualidade

                    imagePNG($this->content, $this->path, $quality);
                    break;
                }
        }
    }

    /**
     * Retorna a imagem renderizada para o navegador
     *
     */
    public function show() {

        switch ($this->extension) {

            case "jpeg":
            case "jpg" : {

                    header("content-type: image/jpg");
                    imageJPEG($this->content, null, $this->quality);
                    break;
                }

            case "png" : {
                    $quality = round($this->quality / 100 * 9); // Escalona a qualidade e inverte o valor
                    $quality = 9 - $quality; // 0 = maior qualidade e 9 = menor qualidade

                    header("content-type: image/png");
                    imagePNG($this->content, null, $quality);
                    break;
                }
        }
    }

}
