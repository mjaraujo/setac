<?php

require_once('CidadeDTO.php');

class EdicaoDTO {

    private $ediId;
    private $ediTema;
    private $ediDescricao;
    private $ediInicio;
    private $ediFim;
    private $ediTimestamp;

    public function __construct() {
        
    }

    function getEdiId() {
        return $this->ediId;
    }

    function getEdiFim() {
        return $this->ediFim;
    }

    function getEdiTema() {
        return $this->ediTema;
    }

    function getEdiDescricao() {
        return $this->ediDescricao;
    }

    function getEdiInicio() {
        return $this->ediInicio;
    }

    function getEdiTimestamp() {
        return $this->ediTimestamp;
    }

    function setEdiId($ediId) {
        $this->ediId = $ediId;
    }

    function setEdiTema($ediTema) {
        $this->ediTema = $ediTema;
    }

    function setEdiDescricao($ediDescricao) {
        $this->ediDescricao = $ediDescricao;
    }

    function setEdiInicio($ediInicio) {
        $this->ediInicio = $ediInicio;
    }

    function setEdiTimestamp($ediTimestamp) {
        $this->ediTimestamp = $ediTimestamp;
    }

    function setEdiFim($ediFim) {
        $this->ediFim = $ediFim;
    }

}

?>