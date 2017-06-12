<?php 
require_once('Conexao.php');
require_once('../dto/LogradouroDTO.php');

class LogradouroDAO {
    public function __construct(){}

    public function getDadosLogradouroDoCep($cep){
        $sql = 'SELECT * FROM logradouros log INNER JOIN cidades cid ON cid.cid_id = log.cid_id WHERE log_cep = :cep';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':cep', $cep, PDO::PARAM_STR);
        $pstmt->execute(); //Resultado desta linha é false ou true, respectivamente, relacionado a falha ou não na execução da query.
        $objLog = $pstmt->fetch(PDO::FETCH_OBJ);
        return $objLog;
    }

    public function validarLogradouroCidade($cep, $cidId){
        $sql = 'SELECT * FROM logradouros WHERE log_cep = :cep AND cid_id = cidId';
        $stmt = Conexao::getInstance()->prepare($sql);
        $stmt->bindValue(':cep', $cep, PDO::PARAM_STR);
        $stmt->bindValue(':cidId', $cidId, PDO::PARAM_INT);
        $stmt->execute();
        $retorno = $stmt->rowCount()>0 ? true : false;
        $stmt->closeCursor();
        return $retorno;
    }
}