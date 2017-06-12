<?php
require_once('../dto/EstadoDTO.php');
require_once('../dao/EstadoDAO.php');

class EstadoBO{
    public $estDTO;
    private $estDAO;

    public function __construct($arrayEst){
        if($arrayEst!=null){
            $this->arrayToObjEstado($arrayEst);
        }
    }

    public function arrayToObjEstado($arrayEst){
        $this->estDTO = new EstadoDTO();
        $this->estDTO->setEstId($arrayEst['est_id'] ?? 0);
        $this->estDTO->setEstNome($arrayEst['est_nome'] ?? '');
        $this->estDTO->setEstTimestamp($arrayEst['est_timestamp'] ?? '');
    }

    public function validarDadosEstado($estDTO){
        $erros = "";
        $erros.= ($estDTO->est_nome ?? "\'Estado\' é obrigatório.");
        return $erros;
    }

    public function buscarTodosEstados(){
        $this->estDAO = new EstadoDAO();
        return $this->estDAO->buscarTodosEstados();
    }
}