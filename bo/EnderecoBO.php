<?php 
require_once('../dto/EnderecoDTO.php');
require_once('../dao/EnderecoDAO.php');

require_once('LogradouroBO.php');
require_once('ParticipanteBO.php');

class EnderecoBO{
	public $endDTO;
        private $endDAO;

	public function __construct($arrayEnd){
		$this->arrayToObjEndereco($arrayEnd);
	}

	public function arrayToObjEndereco($arrayEnd){
		$logBO = new LogradouroBO($arrayEnd);
                $parBO = new ParticipanteBO($arrayEnd);

		$this->endDTO = new EnderecoDTO();
		$this->endDTO->setEndId($arrayEnd['end_id'] ?? 0);
		$this->endDTO->setEndComplemento($arrayEnd['end_complemento'] ?? '');
		$this->endDTO->setEndNumero($arrayEnd['end_numero'] ?? '');
		$this->endDTO->setLog($logBO->logDTO);
                $this->endDTO->setPar($parBO->parDTO);
	}

	public function salvarDadosEndereco(){
            $endId = 0;
            $this->endDAO = new EnderecoDAO();
            $nrReg = $this->endDAO->salvarDadosEndereco($this->endDTO);
            if($nrReg>0){
                $endOBJ = $this->endDAO->buscarEnderecoPorParticipante($this->endDTO->getPar()->getParId());
                $endId = $endOBJ->end_id;
            }
            return $endId;
        }
}