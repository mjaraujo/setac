<?php

class MenusDTO {

    private $men_id;
    private $men_nome;
    private $men_nivel;
    private $men_posicao;
    private $men_menpai;
    private $men_evento;
    private $men_processo;
    private $men_sistema;
    private $men_default = 0;

    function __construct($arrayMenu) {
        $this->fillObjMenus($arrayMenu);
    }
    public function fillObjMenus($arrayMenu){
        $this->setMen_id($arrayMenu['men_id'] ?? '');
        $this->setMen_evento($arrayMenu['men_evento'] ?? '');
        $this->setMen_id($arrayMenu['men_id'] ?? '');
        $this->setMen_nivel($arrayMenu['men_nivel'] ?? '');
        $this->setMen_menpai($arrayMenu['men_menpai'] ?? '');
        $this->setMen_nome($arrayMenu['men_nome'] ?? '');
        $this->setMen_posicao($arrayMenu['men_posicao'] ?? '');
        $this->setMen_sistema($arrayMenu['men_sistema'] ?? '');
        $this->setMen_processo($arrayMenu['men_processo'] ?? '');
        $this->setMen_default($arrayMenu['men_default'] ?? 0 );
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

    function getMen_processo() {
        return $this->men_processo;
    }

    function getMen_default() {
        return $this->men_default;
    }

    function setMen_processo($men_processo) {
        $this->men_processo = $men_processo;
    }

    function setMen_default($men_default) {
        $this->men_default = $men_default;
    }

}
