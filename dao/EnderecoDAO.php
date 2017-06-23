<?php 
require_once('Conexao.php');

class EnderecoDAO {
    
    public function __construct(){}

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar os dados de endereço de um participante através do seu id.
     *             Retorna um objeto endereco do banco.
     * @data: ~08/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarEnderecoPorParticipanteId($parId){
        $sql = 'SELECT * FROM enderecos WHERE par_id = :par';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':par', $parId);
        $pstmt->execute();
        $end = $pstmt->fetch(PDO::FETCH_OBJ);
        return $end;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método responsável por salvar os dados de endereço do participante.
     *             Retorna o número de registros afetado pela query SQL.
     * @data: ~08/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function salvarDadosEndereco($endDTO){
        $sql = 'INSERT INTO enderecos(end_complemento,end_numero,log_id,par_id) VALUES(:complemento,:numero,:log,:par)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':complemento', $endDTO->getEndComplemento(), PDO::PARAM_STR);
        $pstmt->bindValue(':numero', $endDTO->getEndNumero(), PDO::PARAM_STR);
        $pstmt->bindValue(':log', $endDTO->getLog()->getLogId(), PDO::PARAM_INT);
        $pstmt->bindValue(':par', $endDTO->getPar()->getParId(), PDO::PARAM_INT);
        $pstmt->execute();
        return $pstmt->rowCount();
    }
}