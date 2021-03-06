<?php
require_once('../dto/LogradouroDTO.php');
require_once('../dao/LogradouroDAO.php');

require_once('CidadeBO.php');

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Classe responsável pela lógica/regra de negócios de Logradouro.
 * @data: 08/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
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

    public function buscarLogradouroPorCep($cep){
        $logDAO = new LogradouroDAO();
        $log = $logDAO->buscarLogradouroPorCep($cep);
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
        $this->logDAO = new LogradouroDAO();
        $isLog = $this->logDAO->validarLogradouroCidade($cep, $cidId);
        return $isLog;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para salvar os dados do objeto logradouro preenchido pelo usuario. 
     *             Se o id do logradouro vier preenchido é porque o cep informado já está na base de dados.
     *             Buscar-se-a o logradouro pelo seu nome e cidade, se existir retorna o id deste.
     *             Caso contrário, salvar os dados na base.
     *             Retorna o logradouro id.
     * @data: 08/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function salvarDadosLogradouro(){
        $logId = 0;
        if(empty($this->logDTO->getLogId())){
            $this->logDAO = new LogradouroDAO();
            $logOBJ = $this->logDAO->buscarLogradouroPorNomeECidade($this->logDTO->getLogNome(), $this->logDTO->getCid()->getCidId());
            if(empty($logOBJ)){
                $nrReg = $this->logDAO->salvarDadosLogradouro($this->logDTO);
                if($nrReg>0){
                    $logOBJ = $this->logDAO->buscarLogradouroPorNomeECidade($this->logDTO->getLogNome(), $this->logDTO->getCid()->getCidId());
                }
            }
            $logId = $logOBJ->log_id;
        }else{
            $logId = $this->logDTO->getLogId();
        }
        return $logId;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar um logardouro através do seu id.
     *             Retorna um objeto logradouro do banco.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarLogradouroPorId($logId){
        $logDAO = new LogradouroDAO();
        $log = $logDAO->buscarLogradouroPorId($logId);
        return $log;
    }
}