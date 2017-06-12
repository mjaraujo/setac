<?php 
require_once('Conexao.php');
require_once('../dto/EstadoDTO.php');

class EstadoDAO {
    public function __construct(){}

    public function buscarTodosEstados(){
        $sql = 'SELECT * FROM estados ORDER BY est_nome';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetchAll(PDO::FETCH_ASSOC);
    }
}