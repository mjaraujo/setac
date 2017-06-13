<?php
require_once('Conexao.php');

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Classe responsável pela lógica de banco de dados de Participante.
 * @data: 08/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
class ParticipanteDAO {
    public function __construct(){}

    public function listarParticipantes(){
        $sql = 'SELECT * FROM participantes';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetchAll();
    }
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar o participante pelo nome, número de documento e pelo e-mail. Retorno um objeto.
     * @data: 13/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarParticipantePorNomeDocEmail($parNome, $parDoNum, $parEmail){
        $sql = 'SELECT * FROM participantes WHERE lower(par_nome) = :nome AND par_docnumero = :doc AND lower(par_email) = :email';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', strtolower($parNome), PDO::PARAM_STR);
        $pstmt->bindValue(':doc', $parDoNum, PDO::PARAM_STR);
        $pstmt->bindValue(':email', $parEmail, PDO::PARAM_STR);
        $pstmt->execute();
        $par = $pstmt->fetch(PDO::FETCH_OBJ);
        return $par;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para salvar os dados de participante (sem foto).
     * @data: 13/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function salvarDadosParticipante($parDTO){
        $sql = 'INSERT INTO participantes(par_nome,par_doctipo,par_docnumero,par_email,par_instituicao) '
                  . 'VALUES(:nome,:doctipo,:docnumero,:email,:instituicao)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', $parDTO->getParNome(), PDO::PARAM_STR);
        $pstmt->bindValue(':doctipo', $parDTO->getParDocTipo(), PDO::PARAM_STR);
        $pstmt->bindValue(':docnumero', $parDTO->getParDocNumero(), PDO::PARAM_STR);
        $pstmt->bindValue(':email', $parDTO->getParEmail(), PDO::PARAM_STR);
        $pstmt->bindValue(':instituicao', $parDTO->getParInstituicao(), PDO::PARAM_STR);
        $pstmt->execute();
        return $pstmt->rowCount();
    }
}