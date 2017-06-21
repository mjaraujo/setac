<?php

class MenusDTO {

    private $men_id;
    private $men_nome;
    private $men_nivel;
    private $men_posicao;
    private $men_menpai;
    private $men_evento;
    private $men_sistema;

    function __construct() {
        
    }

    function getMen_id() {
        return $this->men_id;
    }

    function getMen_nome() {
        return $this->men_nome;
    }

    function getMen_nivel() {
        return $this->men_nivel;
    }

    function getMen_posicao() {
        return $this->men_posicao;
    }

    function getMen_menpai() {
        return $this->men_menpai;
    }

    function getMen_evento() {
        return $this->men_evento;
    }

    function getMen_sistema() {
        return $this->men_sistema;
    }

    function setMen_id($men_id) {
        $this->men_id = $men_id;
    }

    function setMen_nome($men_nome) {
        $this->men_nome = $men_nome;
    }

    function setMen_nivel($men_nivel) {
        $this->men_nivel = $men_nivel;
    }

    function setMen_posicao($men_posicao) {
        $this->men_posicao = $men_posicao;
    }

    function setMen_menpai($men_menpai) {
        $this->men_menpai = $men_menpai;
    }

    function setMen_evento($men_evento) {
        $this->men_evento = $men_evento;
    }

    function setMen_sistema($men_sistema) {
        $this->men_sistema = $men_sistema;
    }

}
