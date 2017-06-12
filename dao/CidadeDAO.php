<?php 
require_once('Conexao.php');

class CidadeDAO {
    
    public function __construct(){}

    public function verificarCidadePorNome($cidDTO){
        $sql = 'SELECT * FROM cidades WHERE lower(cid_nome) = :nome';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', strtolower($cidDTO->getCidNome()));
        $pstmt->execute();
        $cid = $pstmt->fetch(PDO::FETCH_OBJ);
        return $cid;
    }

    public function salvarDadosCidade($cidDTO){
        $sql = 'INSERT INTO cidades(cid_nome, est_id) VALUES(:nome, :estado)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', $cidDTO->getCidNome());
        $pstmt->bindValue(':estado', $cidDTO->getEst()->getEstId());
        $pstmt->execute();
        return $pstmt->rowCount();
    }
}
 ?>
