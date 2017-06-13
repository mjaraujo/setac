<?php 
require_once('Conexao.php');
require_once('../dto/LogradouroDTO.php');

class LogradouroDAO {
    public function __construct(){}

    public function buscarDadosLogradouroPeloCep($cep){
        $sql = 'SELECT * FROM logradouros log INNER JOIN cidades cid ON cid.cid_id = log.cid_id WHERE log_cep = :cep';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':cep', $cep, PDO::PARAM_STR);
        $pstmt->execute(); //Resultado desta linha é false ou true, respectivamente, relacionado a falha ou não na execução da query.
        $objLog = $pstmt->fetch(PDO::FETCH_OBJ);
        return $objLog;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar o logradouro pelo nome e pela cidade informada. Retorno um objeto.
     * @data: 12/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function verificarLogradouroPorNomeECidade($logNome, $cidId){
        $sql = 'SELECT * FROM logradouros WHERE lower(log_nome) = :nome AND cid_id = :cidade';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', strtolower($logNome), PDO::PARAM_STR);
        $pstmt->bindValue(':cidade', $cidId, PDO::PARAM_INT);
        $pstmt->execute();
        $cid = $pstmt->fetch(PDO::FETCH_OBJ);
        return $cid;
    }

    public function salvarDadosLogradouro($logDTO){
        $sql = 'INSERT INTO logradouros(log_cep,log_nome,log_tipo,log_bairro,cid_id) VALUES(:cep,:nome,:tipo,:bairro,:cidade)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':cep', $logDTO->getLogCep(), PDO::PARAM_STR);
        $pstmt->bindValue(':nome', $logDTO->getLogNome(), PDO::PARAM_STR);
        $pstmt->bindValue(':tipo', $logDTO->getLogTipo(), PDO::PARAM_STR);
        $pstmt->bindValue(':bairro', $logDTO->getLogBairro(), PDO::PARAM_STR);
        $pstmt->bindValue(':cidade', $logDTO->getCid()->getCidId(), PDO::PARAM_INT);
        $pstmt->execute();
        return $pstmt->rowCount();
    }
}