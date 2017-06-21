<?php 
require_once('../dto/CidadeDTO.php');
require_once('../dao/CidadeDAO.php');

require_once('EstadoBO.php');

class CidadeBO{
	public $cidDTO;
	private $cidDAO;

	public function __construct($arrayCid){
            $this->arrayToObjCidade($arrayCid);
	}

	public function arrayToObjCidade($arrayCid){
            $estBO = new EstadoBO($arrayCid);

            $this->cidDTO = new CidadeDTO();
            $this->cidDTO->setCidId($arrayCid['cid_id'] ?? 0);
            $this->cidDTO->setCidNome($arrayCid['cid_nome'] ?? '');
            $this->cidDTO->setCidTimestamp($arrayCid['cid_timestamp'] ?? '');
            $this->cidDTO->setEst($estBO->estDTO);
	}

	public function validarDadosCidade($cidDTO){
            $erros = "";
            $erros.= ($cidDTO->getCidNome()=="" ? "'Cidade' é obrigatório." : "");

            return $erros;
	}

        /* 
         * @autor: Denis Lucas Silva.
         * @descrição: Método para salvar os dados do objeto cidade preenchido pelo usuario. 
         *             Se a cidade já existir, através do nome, ela será usada.
         *             Retorna a cidade id.
         * @data: 08/06/2017.
         * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
         * @alterada por: nome, nome, nome, etc.
         */
	public function salvarDadosCidade(){
            $this->cidDAO = new CidadeDAO();
            $cidOBJ = $this->cidDAO->verificarCidadePorNome($this->cidDTO);
            if(empty($cidOBJ)){
                $nrReg = $this->cidDAO->salvarDadosCidade($this->cidDTO);
                if($nrReg>0){
                    $cidOBJ = $this->cidDAO->verificarCidadePorNome($this->cidDTO);
                }
            }
            return $cidOBJ->cid_id;
	}
}