<?php 
require_once('../dto/EnderecoDTO.php');
require_once('../dao/EnderecoDAO.php');

class EnderecoBO{
	public $endDTO;
        private $endDAO;

	public function __construct($arrayEnd){
		$this->arrayToObjEndereco($arrayEnd);
	}

	public function arrayToObjEndereco($arrayEnd){
		$logBO = new LogradouroBO($arrayEnd);

		$this->endDTO = new EnderecoDTO();
		$this->endDTO->setEndId($arrayEnd['end_id'] ?? 0);
		$this->endDTO->setEndComplemento($arrayEnd['end_complemento'] ?? '');
		$this->endDTO->setEndNumero($arrayEnd['end_numero'] ?? '');
		$this->endDTO->setEndTimestamp($arrayEnd['end_timestamp'] ?? '');
		$this->endDTO->setLog($logBO->logDTO);
	}

	public function salvarDadosEndereco(){
            $endId = 0;
            $this->endDAO = new EnderecoDAO();
            $nrReg = $this->endDAO->salvarDadosEndereco($this->endDTO);
            if($nrReg>0){
                $endOBJ = $this->endDAO->buscarEnderecoPorParticipante($this->endDTO->getParId());
                $endId = $endOBJ->end_id;
            }
            return $endId;
        }
}