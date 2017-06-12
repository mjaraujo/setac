<?php 
class EstadoDTO {
	private $est_id;
	private $est_nome;
	private $est_timestamp;

	public function __construct(){}

	//Setters
	public function setEstId($estId){
		$this->est_id = $estId;
	}
	public function setEstNome($estNome){
		$this->est_nome = $estNome;
	}
	public function setEstTimestamp($estTimestamp){
		$this->est_timestamp = $estTimestamp;
	}

	//getters
	public function getEstId(){
		return $this->est_id;
	}
	public function getEstNome(){
		return $this->est_nome;
	}
	public function getEstTimestamp(){
		return $this->est_timestamp;
	}
}
 ?>