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

    public function __construct($arrayPar){
        if($arrayPar!=null){
            $this->arrayToObjParticipante($arrayPar);
        }
    }

    public function arrayToObjParticipante($arrayPar){
        $endBO = new EnderecoBO($arrayPar);

        $this->parDTO = new ParticipanteDTO();
        $this->parDTO->setParId($arrayPar['par_id'] ?? 0);
        $this->parDTO->setParNome($arrayPar['par_nome'] ?? '');
        $this->parDTO->setParDocTipo($arrayPar['par_doctipo'] ?? '');
        $this->parDTO->setParDocNumero($arrayPar['par_docnumero'] ?? '');
        $this->parDTO->setParEmail($arrayPar['par_email'] ?? '');
        $this->parDTO->setParInstituicao($arrayPar['par_instituicao'] ?? '');
        $this->parDTO->setParFoto($arrayPar['par_foto'] ?? '');
        $this->parDTO->setParTimestamp($arrayPar['par_timestamp'] ?? '');
        $this->parDTO->setEnd($endBO->endDTO);
    }

    public function listarParticipantes(){
        $this->parDAO = new ParticipanteDAO();
        return $this->parDAO->listarParticipantes();
    }

    public function salvarDadosCadastroParticipante($arrayDados){
        echo('<pre>');
        var_dump($this->parDTO);
        echo('</pre>');
        $erros = "";
        $usuBO = new UsuarioBO($arrayDados);
        $cidBO = new CidadeBO($arrayDados);
        $logBO = new LogradouroBO($arrayDados);
        $endBO = new EnderecoBO($arrayDados);

        $erros .= $usuBO->validarDadosUsuario($usuBO->usuDTO);
        $erros .= $cidBO->validarDadosCidade($cidBO->cidDTO);
        $erros .= $logBO->validarDadosLogradouro($logBO->logDTO);
        $erros .= $this->validarDadosParticipante($this->parDTO);

        /*if($erros==""){
                $cidId = $cidBO->salvarDadosCidade();
                $logBO->logDTO->getCid()->setCidId($cidId);
                $logId = $logBO->salvarDadosLogradouro();
                $parId = $this->salvarDadosParticipante();
                $endId = $endBO->salvarDadosEndereco();
        }*/

        echo $erros;
    }

    public function validarDadosParticipante($parDTO){
        $erros = "";
        $erros.= ($parDTO->getParNome()=="" ? "'Nome' é obrigatório." : "");
        $erros.= ($parDTO->getParEmail()=="" ? "'E-Mail' é obrigatório." : "");
        $erros.= ($parDTO->getParDocTipo()=="" ? "A escola de um tipo de 'Documento' é obrigatório." : "");
        $erros.= ($parDTO->getParDocNumero()=="" ? "O número do \'Documento\' é obrigatório." : "");
        return $erros;
    }

    public function salvarDadosParticipante(){

    }
}
