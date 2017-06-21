<?php

require_once('./EdicaoDTO.php');

class AtividadeDTO {

    private $atiId;
    private $atiNome;
    private $atiDescricao;
    private $atiMinistrante;
    private $atiTipo;
    private $atiArquivo;
    private $atiCusto;
    private $atiTimestamp;
    private $edi;

    public function __construct() {
        
    }
    
    function getAtiId() {
        return $this->atiId;
    }

    function getAtiNome() {
        return $this->atiNome;
    }

    function getAtiDescricao() {
        return $this->atiDescricao;
    }

    function getAtiMinistrante() {
        return $this->atiMinistrante;
    }

    function getAtiTipo() {
        return $this->atiTipo;
    }

    function getEdi() {
        return $this->ediId;
    }

    function getAtiArquivo() {
        return $this->atiArquivo;
    }

    function getAtiCusto() {
        return $this->atiCusto;
    }

    function getAtiTimestamp() {
        return $this->atiTimestamp;
    }

    function setAtiId($atiId) {
        $this->atiId = $atiId;
    }

    function setAtiNome($atiNome) {
        $this->atiNome = $atiNome;
    }

    function setAtiDescricao($atiDescricao) {
        $this->atiDescricao = $atiDescricao;
    }

    function setAtiMinistrante($atiMinistrante) {
        $this->atiMinistrante = $atiMinistrante;
    }

    function setAtiTipo($atiTipo) {
        $this->atiTipo = $atiTipo;
    }

    function setEdi($objEdi) {
        $this->edi = $ediId;
    }

    function setAtiArquivo($atiArquivo) {
        $this->atiArquivo = $atiArquivo;
    }

    function setAtiCusto($atiCusto) {
        $this->atiCusto = $atiCusto;
    }

    function setAtiTimestamp($atiTimestamp) {
        $this->atiTimestamp = $atiTimestamp;
    }


}

?>