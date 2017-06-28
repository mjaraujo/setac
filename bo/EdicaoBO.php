<?php

require_once('../dto/EdicaoDTO.php');
require_once('../dao/EdicaoDAO.php');

require_once('EdicaoBO.php');

/*
 * @autor: Márcio Araújo.
 * @descrição: Classe responsável pela lógica/regra de negócios de Edicao.
 * @data: 08/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */

class EdicaoBO {

    public $ediDTO;
    private $ediDAO;

    public function __construct($arrayEdi) {
        if (!is_null($arrayEdi)) {
            $this->arrayToObjEdicao($arrayEdi);
        }
    }

    public function arrayToObjEdicao($arrayEdi) {
        $ediBO = new EdicaoBO($arrayEdi);

        $this->ediDTO = new EdicaoDTO();
        $this->ediDTO->setEdiTema($arrayEdi['edi_tema'] ?? 0);
        $this->ediDTO->setEdiDescricao($arrayEdi['edi_descricao']);
        $this->ediDTO->setEdiInicio($arrayEdi['edi_inicio'] ?? '');
        $this->ediDTO->setEdiFim($arrayEdi['edi_fim'] ?? '');
        $this->ediDTO->setEdiTimestamp($arrayEdi['timestamp'] ?? '');
        $this->ediDTO->setCid($ediBO->cidDTO);
    }

    public function buscarDadosEdicaoPeloTema($tema) {
        $ediDAO = new EdicaoDAO();
        $edi = $ediDAO->buscarEdicaoPorTema($tema);
        return $edi;
    }

    public function validarDadosEdicao($ediDTO) {
        $erros = "";
        $ediDTO = new EdicaoDTO();
        if ($ediDTO->getEdiId() == 0) {
            $erros .= ($ediDTO->getEdiTema() == "" ? "'TEMA' é obrigatório." : "");
            $erros .= ($ediDTO->getEdiInicio() == "" ? "A data de início da 'Edicao' é obrigatória." : "");
            $erros .= ($ediDTO->getEdiFim() == "" ? "A data de fim da 'Edicao' é obrigatória." : "");
        }
        return $erros;
    }

    public function salvarDadosEdicao() {
        $ediId = 0;
        if (empty($this->ediDTO->getEdiId())) {
            $this->ediDAO = new EdicaoDAO();
            $ediOBJ = $this->ediDAO->buscarEdicaoPorTema($this->ediDTO->getEdiNome());
            $ediId = $ediOBJ->edi_id;
        } else {
            $ediId = $this->ediDTO->getEdiId();
        }
        return $ediId;
    }

    public function buscarTodasEdicoes() {
        $this->ediDAO = new EdicaoDAO();
        return $this->ediDAO->buscarTodasEdicoes();
    }
    
    public function listarEdicoes() {
        $this->ediDAO = new EdicaoDAO();
        return $this->ediDAO->listarEdicoes();
    }


}
