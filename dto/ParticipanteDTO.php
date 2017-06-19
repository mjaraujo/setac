<?php
/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Classe representativa de Participante.
 * @data: 08/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
class ParticipanteDTO {

    private $par_id;
    private $par_nome;
    private $par_rg;
    private $par_cpf;
    private $par_email;
    private $par_instituicao;
    private $par_foto;
    private $par_timestamp;

    public function __construct(){}
    
    //GETTERS
    function getParId(){
        return $this->par_id;
    }
    function getParNome(){
        return $this->par_nome;
    }
    function getParRG(){
        return $this->par_rg;
    }
    function getParCPF(){
        return $this->par_cpf;
    }
    function getParEmail(){
        return $this->par_email;
    }
    function getParInstituicao(){
        return $this->par_instituicao;
    }
    function getParFoto(){
        return $this->par_foto;
    }
    function getParTimestamp(){
        return $this->par_timestamp;
    }

    //SETTERS
    function setParId($par_id){
        $this->par_id = $par_id;
    }
    function setParNome($par_nome){
        $this->par_nome = $par_nome;
    }
    function setParRG($par_rg){
        $this->par_rg = $par_rg;
    }
    function setParCPF($par_cpf){
        $this->par_cpf = $par_cpf;
    }
    function setParEmail($par_email){
        $this->par_email = $par_email;
    }
    function setParInstituicao($par_instituicao){
        $this->par_instituicao = $par_instituicao;
    }
    function setParFoto($par_foto){
        $this->par_foto = $par_foto;
    }
    function setParTimestamp($par_timestamp){
        $this->par_timestamp = $par_timestamp;
    }

}
