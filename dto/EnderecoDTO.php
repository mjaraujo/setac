<?php 
require_once('LogradouroDTO.php');

class EnderecoDTO {
	private $end_id;
	private $end_complemento;
	private $end_numero;
	private $end_timestamp;
	private $log;

	public function __construct(){}

	//Setters
	public function setEndId($endId){
		$this->end_id = $endId;
	}
	public function setEndComplemento($endComplemento){
		$this->end_complemento = $endComplemento;
	}
	public function setEndNumero($endNumero){
		$this->end_numero = $endNumero;
	}
	public function setEndTimestamp($endTimestamp){
		$this->end_timestamp = $endTimestamp;
	}
	public function setLog($objLog){
		$this->log = $objLog;
	}

	//getters
	public function getEndId(){
		return $this->end_id;
	}
	public function getEndComplemento(){
		return $this->end_complemento;
	}
	public function getEndNumero(){
		return $this->end_numero;
	}
	public function getEndTimestamp(){
		return $this->end_timestamp;
	}
	public function getLog(){
		return $this->log;
	}
}
 ?>