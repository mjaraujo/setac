<?php 
require_once('Conexao.php');

class EnderecoDAO {
    
    public function __construct(){}

    public function buscarEnderecoPorParticipante($parId){
        $sql = 'SELECT * FROM enderecos WHERE par_id = :par';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':par', $parId);
        $pstmt->execute();
        $end = $pstmt->fetch(PDO::FETCH_OBJ);
        return $end;
    }

    public function salvarDadosEndereco($endDTO){
        $sql = 'INSERT INTO enderecos(end_complemento,end_numero,log_id,par_id) VALUES(:complemento,:numero,:log,:par)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':complemento', $endDTO->getEndComplemento(), PDO::PARAM_STR);
        $pstmt->bindValue(':numero', $endDTO->getEndNumero(), PDO::PARAM_STR);
        $pstmt->bindValue(':log', $endDTO->getLogId(), PDO::PARAM_INT);
        $pstmt->bindValue(':par', $endDTO->getParId(), PDO::PARAM_INT);
        $pstmt->execute();
        return $pstmt->rowCount();
    }
}