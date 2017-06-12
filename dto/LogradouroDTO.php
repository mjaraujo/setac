<?php 
require_once('CidadeDTO.php');

class LogradouroDTO {
	private $log_id;
	private $log_cep;
	private $log_nome;
	private $log_tipo;
	private $log_bairro;
	private $log_timestamp;
	private $cid;

	public function __construct(){}

	//Setters
	public function setLogId($logId){
		$this->log_id = $logId;
	}
	public function setLogCep($logCep){
		$this->log_cep = $logCep;
	}
	public function setLogNome($logNome){
		$this->log_nome = $logNome;
	}
	public function setLogTipo($logTipo){
		$this->log_tipo = $logTipo;
	}
	public function setLogBairro($logBairro){
		$this->log_bairro = $logBairro;
	}
	public function setLogTimestamp($logTimestamp){
		$this->log_timestamp = $logTimestamp;
	}
	public function setCid($objCid){
		$this->cid = $objCid;
	}

	//getters
	public function getLogId(){
		return $this->log_id;
	}
	public function getLogCep(){
		return $this->log_cep;
	}
	public function getLogNome(){
		return $this->log_nome;
	}
	public function getLogTipo(){
		return $this->log_tipo;
	}
	public function getLogBairro(){
		return $this->log_bairro;
	}
	public function getLogTimestamp(){
		return $this->log_timestamp;
	}
	public function getCid(){
		return $this->cid;
	}
}
 ?>