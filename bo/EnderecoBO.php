<?php 
require_once('../dto/EnderecoDTO.php');

class EnderecoBO{
	public $endDTO;

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

	public function salvarDadosEndereco(){}
}