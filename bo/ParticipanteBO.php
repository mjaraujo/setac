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

    public function listarParticipantes() {
        $this->parDAO = new ParticipanteDAO();
        return $this->parDAO->listarParticipantes();
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

                    $parId = $this->salvarDadosParticipante();

                    $endBO->endDTO->getLog()->setLogId($logId);
                    $endBO->endDTO->getPar()->setParId($parId);
                    $endBO->salvarDadosEndereco();

                    $usuBO->usuDTO->getPar()->setParId($parId);
                    $usuBO->salvarDadosUsuario();


                    if ($this->parDTO->getParId != 0) {
                        $parMenu = new MenusBO();
                        $parMenu->cadParticipanteMenus($this->parDTO->getParId);
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

    public function validarDadosParticipante($parDTO) {
        $erros = "";
        $erros .= ($parDTO->getParNome() == "" ? "'Nome' é obrigatório." : "");
        $erros .= ($parDTO->getParEmail() == "" ? "'E-Mail' é obrigatório." : "");
        /* $erros.= ($parDTO->getParRG()=="" ? "'RG' é obrigatório." : "");
          $erros.= ($parDTO->getParCPF()=="" ? "'CPF' é obrigatório." : ""); Não é obrigatório??? */
        return $erros;
    }

    public function salvarDadosParticipante() {
        $parId = 0;
        $this->parDAO = new ParticipanteDAO();
        $nrReg = $this->parDAO->salvarDadosParticipante($this->parDTO);
        if ($nrReg > 0) {
            $parOBJ = $this->parDAO->buscarParticipantePorNomeDocsEmail($this->parDTO->getParNome(), $this->parDTO->getParRG(), $this->parDTO->getParCPF(), $this->parDTO->getParEmail());
            $parId = $parOBJ->par_id;
        }
        return $parId;
    }

}
