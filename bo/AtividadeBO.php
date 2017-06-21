<?php 
require_once('../dto/AtividadeDTO.php');
require_once('../dao/AtividadeDAO.php');

require_once('EdicaoBO.php');

class AtividadeBO{
	public $atiDTO;
	private $atiDAO;

	public function __construct($arrayAti){
            $this->arrayToObjAtividade($arrayAti);
	}

	public function arrayToObjAtividade($arrayAti){
            $estBO = new EstadoBO($arrayAti);

            $this->ediDTO = new AtividadeDTO();
            $this->ediDTO->setAtiId($arrayAti['cid_id'] ?? 0);
            $this->ediDTO->setAtiNome($arrayAti['cid_nome'] ?? '');
            $this->ediDTO->setAtiTimestamp($arrayAti['cid_timestamp'] ?? '');
            $this->ediDTO->setEst($estBO->estDTO);
	}

	public function validarDadosAtividade($atiDTO){
            $erros = "";
            $erros.= ($atiDTO->getAtiNome()=="" ? "'Atividade' é obrigatório." : "");

            return $erros;
	}

        /* 
         * @autor: Denis Lucas Silva.
         * @descrição: Método para salvar os dados do objeto cidade preenchido pelo usuario. Retorna a cidade id.
         * @data: 08/06/2017.
         * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
         * @alterada por: nome, nome, nome, etc.
         */
	public function salvarDadosAtividade(){
            $this->ediDAO = new AtividadeDAO();
            $cidOBJ = $this->ediDAO->verificarAtividadePorNome($this->ediDTO);
            if(empty($cidOBJ)){
                $nrReg = $this->ediDAO->salvarDadosAtividade($this->ediDTO);
                if($nrReg>0){
                    $cidOBJ = $this->ediDAO->verificarAtividadePorNome($this->ediDTO);
                }
            }
            return $cidOBJ->cid_id;
	}
}