<?php

require_once('../dto/RecursosDTO.php');
require_once('../dao/RecursosDAO.php');


class RecursosBO extends RecursosDTO{
    
     public $recDTO;
     private $recDAO;

    public function listarRecursos() {
        $this->recDAO = new RecurosDAO(); //alterar o construtor
        return $this->recDAO->listAll();
    }

}

