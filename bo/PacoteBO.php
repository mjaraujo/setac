<?php
require_once('../dto/PacoteDTO.php');
require_once('../dao/PacoteDAO.php');

class PacoteBO{
    public $pacDTO;
    private $pacDAO;

    public function __construct($arrayPac){
        if($arrayPac!=null){
            $this->arrayToObjPacote($arrayPac);
        }
    }

    public function arrayToObjPacote($arrayPac){
        $this->pacDTO = new PacoteDTO();
        $this->pacDTO->setPacId($arrayPac['pac_id'] ?? 0);
        $this->pacDTO->setPac($arrayPac['pac_custo'] ?? '');
        $this->pacDTO->setPacTimestamp($arrayPac['pac_timestamp'] ?? '');
    }

    public function validarDadosPacote($pacDTO){   
        $erros = "";
        $erros.= ($pacDTO->getPacCusto() ?? "\'Pacote\' é obrigatório.");
        return $erros;
    }

    public function buscarTodosPacotes(){
        $this->pacDAO = new PacoteDAO();
        return $this->pacDAO->buscarTodosPacotes();
    }
}