<?php

require_once('Conexao.php');
require_once('../dto/EdicaoDTO.php');

/*
 * @autor: Márcio Araújo.
 * @descrição: Classe responsável pela lógica de banco de dados de Edicao.
 * @data: 08/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */

class EdicaoDAO {

    public function __construct() {
        
    }

    public function listarEdicoes() {
        $sql = 'SELECT * FROM edicoes';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetchAll();
    }

    /*
     * @autor: Márcio Araújo.
     * @descrição: Método para buscar o edicao pelo nome, número de documento e pelo e-mail. Retorno um objeto.
     * @data: 13/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */

    public function buscarEdicaoPorTema($ediTema) {
        $ediTema = "%$ediTema%";
        $sql = 'SELECT * FROM edicoes WHERE LOWER(tema) LIKE LOWER(:tema)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':tema', strtolower($ediTema), PDO::PARAM_STR);
        $pstmt->execute();
        $edi = $pstmt->fetch(PDO::FETCH_OBJ);
        return $edi;
    }

    /*
     * @autor: Márcio Araújo.
     * @descrição: Método para salvar os dados de edicao (sem foto).
     * @data: 13/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */

    public function salvarDadosEdicao($ediDTO) {

        $sql = 'INSERT INTO edicoes(edi_tema, edi_descricao, edi_inicio, edi_fim) '
                . ' VALUES(:tema, :descricao, :inicio, :fim)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':tema', $ediDTO->getEdiTema(), PDO::PARAM_STR);
        $pstmt->bindValue(':descricao', $ediDTO->getEdiDescricao(), PDO::PARAM_STR);
        $pstmt->bindValue(':inicio', $ediDTO->getEdiInicio()->format('Y-m-d H:i:s'));
        $pstmt->bindValue(':fim', $ediDTO->getEdiFim()->format('Y-m-d H:i:s'));
        $pstmt->execute();

        return $pstmt->rowCount();
    }

    public function buscarTodasEdicoes() {
        $sql = 'SELECT * FROM edicoes ORDER BY edi_tema';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
