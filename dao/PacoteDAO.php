<?php 
require_once('Conexao.php');
require_once('../dto/PacoteDTO.php');

class PacoteDAO {
    public function __construct(){}

    public function buscarTodosPacotes(){
        $sql = 'SELECT * FROM pacotes';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetchAll(PDO::FETCH_ASSOC);
    }
}