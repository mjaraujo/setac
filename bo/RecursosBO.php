<?php

require_once('../dto/RecursosDTO.php');
require_once('../dao/RecursosDAO.php');


class RecursosBO extends RecursosDTO{
    
     public $recDTO;
     private $recDAO;
     
     public function __construct($arrayRec){
            if($arrayRec != null){
                $this->arrayToObjAtividade($arrayRec);
            }
            
	}
    
    public function arrayToObjAtividade($arrayRec){
        $this->recDTO = new RecursosDTO();
        $this->recDTO->setRec_num_patrimonio($arrayRec['rec_num_patrimonio'] ?? 0);
        $this->recDTO->setRec_nome($arrayRec['rec_nome'] ?? '');
        $this->recDTO->setRec_descricao($arrayRec['rec_descricao'] ?? '');
    }

    public function listarRecursos() {
        $this->recDAO = new RecurosDAO();
        return $this->recDAO->listAll();
    }
    
    public function cadastroRecurso() {
        $this->recDAO = new RecurosDAO(); 
        return $this->recDAO->cadastroRecurso($this->recDTO);
    }
    
    public function deleteRecurso($id) {
        $this->recDAO = new RecurosDAO(); 
        return $this->recDAO->deleteRecurso($id);
    }
    public function selectRecurso($id) {
        $this->recDAO = new RecurosDAO(); 
        return $this->recDAO->selectRecurosByID($id);
    }
}

