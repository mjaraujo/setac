<?php
//require_once('ParticipanteDTO.php');

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Classe representativa de Usuario.
 * @data: 12/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
class UsuarioDTO {
    private $usu_nome;
    private $usu_senha;
    private $usu_status; //(I)nativo, (A)tivo
    private $par; //Participante
    
    public function __construct(){}

    //Getters
    function getUsuNome() {
        return $this->usu_nome;
    }

    function getUsuSenha() {
        return $this->usu_senha;
    }

    function getUsuStatus() {
        return $this->usu_status;
    }

    function getPar() {
        return $this->par;
    }

    //Setters
    function setUsuNome($usu_nome) {
        $this->usu_nome = $usu_nome;
    }

    function setUsuSenha($usu_senha) {
        $this->usu_senha = $usu_senha;
    }

    function setUsuStatus($usu_status) {
        $this->usu_status = $usu_status;
    }

    function setPar($par) {
        $this->par = $par;
    }

}
