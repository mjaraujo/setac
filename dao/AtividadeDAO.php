<?php 
require_once('Conexao.php');

class AtividadeDAO {
    
    public function __construct(){}

    public function verificarAtividadePorNome($atiDTO){
        $sql = 'SELECT * FROM atividades WHERE lower(ati_nome) = :nome';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', strtolower($atiDTO->getAtiNome()));
        $pstmt->execute();
        $cid = $pstmt->fetch(PDO::FETCH_OBJ);
        return $cid;
    }

    public function salvarDadosAtividade($atiDTO){
        $atiDTO = new AtividadeDTO();
        $sql = 'INSERT INTO atividades(ati_nome, edi_id) VALUES(:nome, :edicao)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', $atiDTO->getAtiNome());
        $pstmt->bindValue(':edicao', $atiDTO->getEdi()->getEdiId());
        $pstmt->execute();
        return $pstmt->rowCount();
    }
}
