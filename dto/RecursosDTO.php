<?php
//serve como base do objeto com as variaveis de cada objeto

class RecursosDTO {
    private $rec_id;
    private $rec_num_patrimonio; //mostra
    private $rec_nome;          //mostra
    private $rec_descricao;     //mostra
   // private $rec_timestamp;
    
    public function __construct(){}

    function getRec_num_patrimonio() {
        return $this->rec_num_patrimonio;
    }

    function getRec_nome() {
        return $this->rec_nome;
    }

    function getRec_descricao() {
        return $this->rec_descricao;
    }

    function setRec_num_patrimonio($rec_num_patrimonio) {
        $this->rec_num_patrimonio = $rec_num_patrimonio;
    }

    function setRec_nome($rec_nome) {
        $this->rec_nome = $rec_nome;
    }

    function setRec_descricao($rec_descricao) {
        $this->rec_descricao = $rec_descricao;
    }

   

    

}
