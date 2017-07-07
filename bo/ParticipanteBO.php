<?php

require_once('../dto/ParticipanteDTO.php');
require_once('../dao/ParticipanteDAO.php');

require_once('UsuarioBO.php');
require_once('LogradouroBO.php');
require_once('CidadeBO.php');
require_once('EnderecoBO.php');

/*
 * @autor: Denis Lucas Silva.
 * @descrição: Classe responsável pela lógica de negócios de Participante.
 * @data: 08/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */

class ParticipanteBO {

    public $parDTO;
    private $parDAO;

    public function __construct($arrayPar) {
        if ($arrayPar != null) {
            $this->arrayToObjParticipante($arrayPar);
        }
    }

    public function arrayToObjParticipante($arrayPar) {
        $this->parDTO = new ParticipanteDTO();
        $this->parDTO->setParId($arrayPar['par_id'] ?? 0);
        $this->parDTO->setParNome($arrayPar['par_nome'] ?? '');
        $this->parDTO->setParRG($arrayPar['par_rg'] ?? '');
        $this->parDTO->setParCPF($arrayPar['par_cpf'] ?? '');
        $this->parDTO->setParEmail($arrayPar['par_email'] ?? '');
        $this->parDTO->setParInstituicao($arrayPar['par_instituicao'] ?? '');
        $this->parDTO->setParFoto($arrayPar['par_foto'] ?? '');
        $this->parDTO->setParTimestamp($arrayPar['par_timestamp'] ?? '');
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar N participantes, para paginação.
     *             Retorno uma lista de objetos participante do banco.
     * @data: 20/06/2017.
     * @alterada em: 29/06/2017/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: Denis, nome, nome, etc.
     */
    public function listarParticipantes($apartir, $quantidade) {
        $this->parDAO = new ParticipanteDAO();
        return $this->parDAO->listarParticipantes($apartir, $quantidade);
    }

    public function salvarDadosInscricaoParticipante($arrayDados) {
        $erros = "";
        $cidBO = new CidadeBO($arrayDados);
        $logBO = new LogradouroBO($arrayDados);
        $endBO = new EnderecoBO($arrayDados);
        $usuBO = new UsuarioBO($arrayDados);

        $erros .= $cidBO->validarDadosCidade($cidBO->cidDTO);
        $erros .= $logBO->validarDadosLogradouro($logBO->logDTO);
        $erros .= $this->validarDadosParticipante($this->parDTO);
        $erros .= $usuBO->validarDadosUsuario($usuBO->usuDTO);

        if ($erros == "") {
            try {
                $cidId = $cidBO->salvarDadosCidade();

                $logBO->logDTO->getCid()->setCidId($cidId);
                $logId = $logBO->salvarDadosLogradouro();

                $this->parDAO = new ParticipanteDAO();
                $parOBJ = $this->parDAO->buscarParticipantePorDocumentos($this->parDTO->getParRG(), $this->parDTO->getParCPF());
                $parOBJ1 = $this->parDAO->buscarParticipantePorEmail($this->parDTO->getParEmail());

                if (empty($parOBJ) && empty($parOBJ1)) {
                    //$erros = $this->parDAO->salvarDadosInscricaoParticipante($logId, $this->parDTO, $endBO->endDTO, $usuBO->usuDTO);

                    $parId = $this->salvarParticipante();

                    $endBO->endDTO->getLog()->setLogId($logId);
                    $endBO->endDTO->getPar()->setParId($parId);
                    $endBO->salvarDadosEndereco();

                    $usuBO->usuDTO->getPar()->setParId($parId);
                    $usuBO->salvarDadosUsuario();
                    $erros = true;
                }
            } catch (PDOException $e) {
                $erros = false;
                echo($e->getMessage());
            }
        }
        return $erros; //erros das validações acima, caso contrário true ou false
    }

    public function validarDadosParticipante($parDTO) {
        $erros = "";
        $erros .= ($parDTO->getParNome() == "" ? "'Nome' é obrigatório." : "");
        $erros .= ($parDTO->getParEmail() == "" ? "'E-Mail' é obrigatório." : "");
        /* $erros.= ($parDTO->getParRG()=="" ? "'RG' é obrigatório." : "");
          $erros.= ($parDTO->getParCPF()=="" ? "'CPF' é obrigatório." : ""); Não é obrigatório??? */
        return $erros;
    }

    public function salvarParticipante() {
        $parId = 0;
        $this->parDAO = new ParticipanteDAO();
        $nrReg = $this->parDAO->salvarParticipante($this->parDTO);
        if ($nrReg > 0) {
            $parOBJ = $this->parDAO->buscarParticipantePorNomeDocsEmail($this->parDTO->getParNome(), $this->parDTO->getParRG(), $this->parDTO->getParCPF(), $this->parDTO->getParEmail());
            $parId = $parOBJ->par_id;
        }
        return $parId;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar os dados de um participante através do id.
     *             Retorna um objeto participante do banco.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarParticipantePorId($parId){
        $this->parDAO = new ParticipanteDAO();
        $objPar = $this->parDAO->buscarParticipantePorId($parId);
        return $objPar;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método responsável por atualizar os dados de cadastro de um participante.
     *             Retorna erros das validações, caso contrário true ou false em acordo com o resultado da ação.
     * @data: 26/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function atualizarDadosInscricaoParticipante($arrayDados) {
        $erros = "";
        $cidBO = new CidadeBO($arrayDados);
        $logBO = new LogradouroBO($arrayDados);
        $endBO = new EnderecoBO($arrayDados);
        $usuBO = new UsuarioBO($arrayDados);

        $erros .= $cidBO->validarDadosCidade($cidBO->cidDTO);
        $erros .= $logBO->validarDadosLogradouro($logBO->logDTO);
        $erros .= $this->validarDadosParticipante($this->parDTO);
        $erros .= $usuBO->validarDadosUsuario($usuBO->usuDTO);

        if ($erros=="") {
            try {
                $cidId = $cidBO->cidDTO->getCidId();
                if($cidBO->cidDTO->getCidId()==""){
                    $cidId = $cidBO->salvarDadosCidade();
                }

                $logId = $logBO->logDTO->getLogId();
                if($logBO->logDTO->getLogId()==""){
                    $logBO->logDTO->getCid()->setCidId($cidId);
                    $logId = $logBO->salvarDadosLogradouro();
                }

                $this->parDAO = new ParticipanteDAO();
                $parOBJ = $this->parDAO->buscarParticipantePorDocumentos($this->parDTO->getParRG(), $this->parDTO->getParCPF());
                $parOBJ1 = $this->parDAO->buscarParticipantePorEmail($this->parDTO->getParEmail());

                //Se não existir cadastros com o(s) documento(s) ou e-mail informados ou, existindo, que estes sejam do participante em questão, atualizar
                //Se existir algum cadastro em que o participante não seja o em questão, não pode atualizar, pois documentos e e-mail são individuais.
                if((empty($parOBJ) || $parOBJ->par_id==$this->parDTO->getParId()) && (empty($parOBJ1) || $parOBJ1->par_id==$this->parDTO->getParId())) {
                    //$erros = $this->parDAO->salvarDadosInscricaoParticipante($logId, $this->parDTO, $endBO->endDTO, $usuBO->usuDTO);

                    $parId = $this->atualizarDadosParticipante();

                    $endBO->endDTO->getLog()->setLogId($logId);
                    $endBO->endDTO->getPar()->setParId($parId);
                    if($endBO->endDTO->getEndId()==""){
                        $endBO->salvarDadosEndereco();
                    }else{
                        $endBO->atualizarDadosEndereco();
                    }

                    $usuBO->usuDTO->getPar()->setParId($parId);
                    $objPar = $usuBO->buscarUsuarioPorId($parId);
                    if(empty($objPar)){
                        $usuBO->salvarDadosUsuario();
                    }else{
                        $usuBO->atualizarDadosUsuario();
                    }

                    $erros = true;
                }
            } catch (PDOException $e) {
                $erros = false;
                echo($e->getMessage());
            }
        }
        return $erros; //erros das validações acima, caso contrário true ou false
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método responsável por atualizar os dados de um participante.
     *             Retorna o id atualizado.
     * @data: 26/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function atualizarDadosParticipante() {
        $this->parDAO = new ParticipanteDAO();
        $this->parDAO->atualizarDadosParticipante($this->parDTO);
        return $this->parDTO->getParId();
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para excluir da base de dados TODOS os dados de um participante.
     *             Retorna false, se não excluir, e true, se excluir.
     * @data: 27/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function excluirDadosParticipantePorId($parId){
        $retorno = 0;
        $exEnd = false;
        $exUsu = false;
        $exPar = false;

        $endBO = new EnderecoBO(NULL);
        $objEnd = $endBO->buscarEnderecoPorParticipanteId($parId);
        if(!empty($objEnd)){
            $exEnd = $endBO->excluirEnderecoPorParticipanteId($parId);
        }

        $usuBO = new UsuarioBO(NULL);
        $objUsu = $usuBO->buscarUsuarioPorId($parId);
        if(!empty($objUsu)){
            $exUsu = $usuBO->excluirUsuarioPorId($parId);
        }

        $objPar = $this->buscarParticipantePorId($parId);
        if(!empty($objPar)){
            $this->parDAO = new ParticipanteDAO();
            $exPar = $this->parDAO->excluirParticipantePorId($parId);
        }
        return $exPar; //Se conseguiu excluir o participante, também conseguiu remover as dependencias ou elas não existiam.
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para procurar um participante através de uma string que pode ser seu nome ou documento.
     *             Se identificado que a string parâmetro tem muitos números em relação a seu tamanho (em geral rg 
     *             uns 3 caracteres e cpf 4, diferentes de números), um método para busca por documento é invocado,
     *             senão um método para busca pelo nome.
     * @data: 05/07/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarParticipantePorNomeOuDocumento($parNomeOuDoc){
        $this->parDAO = new ParticipanteDAO();

        $lstObjPar = [];
        $param = $parNomeOuDoc;
        $param = str_replace(".", "", $param);
        $param = str_replace(".", "", $param);
        $param = str_replace("-", "", $param);

        if(ctype_digit($param)){
            $lstObjPar = $this->parDAO->buscarParticipantePorAlgunsNumerosDosDocumentos($parNomeOuDoc);
        }else{
            $lstObjPar = $this->parDAO->buscarParticipantePorNomeParcial($parNomeOuDoc);
        }
        return $lstObjPar;
    }

    /* 
     * @autor: .
     * @descrição: .
     * @data: .
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function prepararDadosParticipanteParaEdicaoPeloId($parId){
        $parBO = new ParticipanteBO(NULL);
        $usuBO = new UsuarioBO(NULL);
        $endBO = new EnderecoBO(NULL);
        $logBO = new LogradouroBO(NULL);
        $cidBO = new CidadeBO(NULL);

        $objPar = $parBO->buscarParticipantePorId($parId);
        $objUsu = $usuBO->buscarUsuarioPorId($parId);
        $objEnd = $endBO->buscarEnderecoPorParticipanteId($parId);
        if(!empty($objEnd)){//Não tem endereço cadastrado
            $objLog = $logBO->buscarLogradouroPorId($objEnd->log_id);
            $objCid = $cidBO->buscarCidadePorId($objLog->cid_id);
        }else{//Só para não dar erro nos foreach
            $objEnd = []; $objLog = []; $objCid = [];
        }
        if(empty($objUsu)){//Não tem usuário cadastrado
            $objUsu = [];
        }
        
        $data = array();
        foreach($objPar as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        foreach($objUsu as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        foreach($objEnd as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        foreach($objLog as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        foreach($objCid as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        return json_encode($data);
    }
}
