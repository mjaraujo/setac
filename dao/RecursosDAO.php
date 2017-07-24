<?php
require_once('Conexao.php');

class RecurosDAO {

    function __construct(){ }
    
    public function listarRecursos($apartir, $quantidade){
        $sql = 'SELECT * FROM nr_recursos vQuantidade ' .
               'JOIN recursos ' .
               'LIMIT ' . $apartir . ', ' . $quantidade;
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->execute();
        return $rstmt->fetchAll(PDO::FETCH_ASSOC);   
    }

    public function salvarRecurso($recDTO) {
        $sql = 'INSERT INTO recursos(rec_patrimonio,rec_nome,rec_descricao) VALUES(:patrimonio, :nome, :descricao)';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':patrimonio', $recDTO->getRec_patrimonio());
        $rstmt->bindValue(':nome', $recDTO->getRec_nome());
        $rstmt->bindValue(':descricao', $recDTO->getRec_descricao());
        $rstmt->execute();
        return $rstmt->rowCount();
    }

    public function excluirRecurso($ID) {
        $sql = 'DELETE FROM recursos WHERE rec_id = :id';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':id', $ID);
        $rstmt->execute();
        return $rstmt->rowCount();
    }

    public function buscarRecursoPorId($ID){
        $sql = 'SELECT * FROM recursos WHERE rec_id = :id';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':id', $ID);
        $rstmt->execute();
        return $rstmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarRecurso($recDTO) {
        $sql = 'UPDATE recursos SET rec_patrimonio = :patrimonio, rec_nome = :nome, rec_descricao = :descricao '
                . 'WHERE rec_id = :rec_id';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':patrimonio', $recDTO->getRec_patrimonio());
        $rstmt->bindValue(':nome', $recDTO->getRec_nome());
        $rstmt->bindValue(':descricao', $recDTO->getRec_descricao());
        $rstmt->bindValue(':rec_id', $recDTO->getRec_id());
        $rstmt->execute();
        return $rstmt->rowCount();
    }
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar recurso pelo nome.
     *             Retorno uma lista de objetos recurso do banco.
     * @data: 10/07/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarRecursoPorNome($recNome) {
        $sql = 'SELECT * FROM recursos WHERE rec_nome = :nome';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':nome', $recNome);
        $rstmt->execute();
        return $rstmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar recurso pela identificação de patrimonio do recurso.
     *             Retorno um objeto recurso do banco.
     * @data: 10/07/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarRecursoPorPatrimonio($recPatrimonio) {
        $sql = 'SELECT * FROM recursos WHERE rec_nome = :patrimonio';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':patrimonio', $recPatrimonio);
        $rstmt->execute();
        return $rstmt->fetch(PDO::FETCH_ASSOC);
    }

}