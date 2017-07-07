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
        if ($arrayEdi != null) {
            $this->arrayToObjEdicao($arrayEdi);
        }
    }

    public function arrayToObjEdicao($arrayEdi) {
        $this->ediDTO = new EdicaoDTO();
        $this->ediDTO->setEdiId($arrayEdi['edi_id']);
        $this->ediDTO->setEdiTema($arrayEdi['edi_tema']);
        $this->ediDTO->setEdiDescricao($arrayEdi['edi_descricao']);
        $this->ediDTO->setEdiInicio(new DateTime($arrayEdi['edi_inicio']) ?? '');
        $this->ediDTO->setEdiFim(new DateTime($arrayEdi['edi_fim']) ?? '');
        $this->ediDTO->setEdiTimestamp($arrayEdi['timestamp'] ?? '');
    }

    public function buscarDadosEdicaoPeloTema($tema) {
        $ediDAO = new EdicaoDAO();
        $edi = $ediDAO->buscarEdicaoPorTema($tema);
        return $edi;
    }

    public function buscarDadosEdicaoPorId($id) {
        $ediDAO = new EdicaoDAO();
        $edi = $ediDAO->buscarEdicaoPorId($id);
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

        if (empty($this->ediDTO->getEdiId())) {
            $this->ediDAO = new EdicaoDAO();
            $nrReg = $this->ediDAO->salvarDadosEdicao($this->ediDTO);
            if ($nrReg > 0) {
                var_dump($this->ediDTO);  
                $ediOBJ = $this->ediDAO->buscarEdicaoPorTema($this->ediDTO->getEdiTema());
                
                $ediId = $ediOBJ->edi_id;
            }
             return $ediId;
        }else{
            $this->ediDAO = new EdicaoDAO();
            $nrReg = $this->ediDAO->atualizarDadosEdicao($this->ediDTO);
            
            $ediId =0;
            if ($nrReg > 0) {
                echo 'DDDDTTOOO:';
                var_dump($this->ediDTO);
                $ediOBJ = $this->ediDAO->buscarEdicaoPorId($this->ediDTO->getEdiId());
                
                $ediId = $ediOBJ->edi_id;
            }
            return $ediId;
        }
       
    }

    public function buscarTodasEdicoes() {
        $this->ediDAO = new EdicaoDAO();
        return $this->ediDAO->buscarTodasEdicoes();
    }

    public function listarEdicoes() {
        $this->ediDAO = new EdicaoDAO();
        return $this->ediDAO->listarEdicoes();
    }
    
    /* 
     * @autor: Márcio Araújo
     * @descrição: Método para excluir uma edição a partir do id.
     *             Retorna false, se não excluir, e true, se excluir.
     * @data: 05/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function excluirEdicaoPorId($ediId){
        $sql = 'DELETE FROM edicoes WHERE  edi_id = :id';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':id', $ediId, PDO::PARAM_INT);
        return $pstmt->execute();
    }

}
