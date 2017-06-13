<?php 
require_once('EstadoDTO.php');

class CidadeDTO {
	private $cid_id;
	private $cid_nome;
        private $cid_cepunico;
	private $cid_timestamp;
	private $est;

	public function __construct(){}

	//Setters
	public function setCidId($cidId){
		$this->cid_id = $cidId;
	}
	public function setCidNome($cidNome){
		$this->cid_nome = $cidNome;
	}
        public function setCidCepUnico($cidCepUnico){
		$this->cid_cepunico = $cidCepUnico;
	}
	public function setCidTimestamp($cidTimestamp){
		$this->cid_timestamp = $cidTimestamp;
	}
	public function setEst($objEst){
		$this->est = $objEst;
	}

	//getters
	public function getCidId(){
		return $this->cid_id;
	}
	public function getCidNome(){
		return $this->cid_nome;
	}
        public function getCidCepUnico(){
		return $this->cid_cepunico;
	}
	public function getCidTimestamp(){
		return $this->cid_timestamp;
	}
	public function getEst(){
		return $this->est;
	}
}
 ?>