<?php 
require_once('Conexao.php');

class CidadeDAO {
    
    public function __construct(){}

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar os dados de uam cidade através de um nome informado pelo usuario.
     *             Retorna um objeto cidade do banco.
     * @data: 08/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarCidadePorNome($cidNome){
        $sql = 'SELECT * FROM cidades WHERE lower(cid_nome) = :nome';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', strtolower($cidNome));
        $pstmt->execute();
        $cid = $pstmt->fetch(PDO::FETCH_OBJ);
        return $cid;
    }

    public function salvarDadosCidade($cidDTO){
        $sql = 'INSERT INTO cidades(cid_nome, est_id) VALUES(:nome, :estado)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', $cidDTO->getCidNome(), PDO::PARAM_STR);
        $pstmt->bindValue(':estado', $cidDTO->getEst()->getEstId(), PDO::PARAM_STR);
        $pstmt->execute();
        return $pstmt->rowCount();
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar os dados de uam cidade através do seu id.
     *             Retorna um objeto cidade do banco.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarCidadePorId($cidId){
        $sql = 'SELECT * FROM cidades WHERE cid_id = :id';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':id', $cidId, PDO::PARAM_INT);
        $pstmt->execute();
        $cid = $pstmt->fetch(PDO::FETCH_OBJ);
        return $cid;
    }
}
