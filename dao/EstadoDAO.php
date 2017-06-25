<?php 
require_once('Conexao.php');
require_once('../dto/EstadoDTO.php');

class EstadoDAO {
    public function __construct(){}

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar todos os estados cadastrados.
     * @data: ~06/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarTodosEstados(){
        $sql = 'SELECT * FROM estados ORDER BY est_nome';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetchAll(PDO::FETCH_ASSOC);
    }
}