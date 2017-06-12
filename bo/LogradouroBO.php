<?php
require_once('../dto/LogradouroDTO.php');
require_once('../dao/LogradouroDAO.php');

require_once('CidadeBO.php');

class LogradouroBO{
    public $logDTO;
    private $logDAO;

    public function __construct($arrayLog){
        if(!is_null($arrayLog)){
            $this->arrayToObjLogradouro($arrayLog);
        }
    }

    public function arrayToObjLogradouro($arrayLog){
        $cidBO = new CidadeBO($arrayLog);

        $this->logDTO = new LogradouroDTO();
        $this->logDTO->setLogId($arrayLog['log_id'] ?? 0);
        $this->logDTO->setLogCep($arrayLog['log_cep']);
        $this->logDTO->setLogNome($arrayLog['log_nome'] ?? '');
        $this->logDTO->setLogTipo($arrayLog['log_tipo'] ?? '');
        $this->logDTO->setLogBairro($arrayLog['log_bairro'] ?? '');
        $this->logDTO->setLogTimestamp($arrayLog['log_timestamp'] ?? '');
        $this->logDTO->setCid($cidBO->cidDTO);
    }

    public function getDadosLogradouroDoCep($cep){
        $logDAO = new LogradouroDAO();
        $log = $logDAO->getDadosLogradouroDoCep($cep);
        return $log;
    }

    public function validarDadosLogradouro($logDTO){
        $erros = "";
        if($logDTO->getLogId()==0){
            $erros.= ($logDTO->getLogCep()=="" ? "'CEP' é obrigatório." : "");
            $erros.= ($logDTO->getLogTipo()=="" ? "A escola de um tipo de 'Logradouro' é obrigatório." : "");
            $erros.= ($logDTO->getLogNome()=="" ? "'Logradouro' é obrigatório." : "");
            $erros.= ($logDTO->getLogBairro()=="" ? "'Bairro' é obrigatório." : "");
        }
        return $erros;
    }

    public function validarLogradouroCidade($logDTO){
        $cep = $logDTO->getLogCep();
        $cidId = $logDTO->getCid()->getCidId();
        $logDAO = new LogradouroDAO();
        $isLog = $logDAO->validarLogradouroCidade($cep, $cidId);
        return $isLog;
    }

    public function salvarDadosLogradouro(){
        //verificar se o logradouro já existe para a cidade
        $isLog = $this->validarLogradouroCidade($this->logDTO);
echo('<pre>LOGRADOURO ');
print_r($isLog);
echo('</pre>');
    }
}