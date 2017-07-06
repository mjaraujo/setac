<?php
require_once '../dao/Conexao.php';


class RecurosDAO extends RecursosDTO{

    function __construct() { }
    
    public function listAll(){
        $sql = 'select * from recursos;';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->execute();
        return $rstmt->fetchAll();   
    }
    public function cadastroRecurso($recDTO) {
        $sql = 'INSERT INTO recursos(rec_num_patrimonio, rec_nome, rec_descricao, rec_timestamp) VALUES(:patrimonio, :nome, :descricao, :time)';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':patrimonio', $recDTO->getRec_num_patrimonio());
        $rstmt->bindValue(':nome', $recDTO->getRec_nome());
        $rstmt->bindValue(':descricao', $recDTO->getRec_descricao());
        $time = date('Y-m-d H:i:s');
        $rstmt->bindValue(':time', $time);
        $rstmt->execute();
        return $rstmt->rowCount();
    }
    public function deleteRecurso($ID) {
        $sql = 'delete from recursos where rec_id = :id';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':id', $ID);
        $rstmt->execute();
        return $rstmt->rowCount();
    }
    public function selectRecurosByID($ID){
        $sql = 'Select * from recursos where rec_id = :id';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':id', $ID);
        $rstmt->execute();
        return $rstmt->fetchAll();
    }

    public function updateRecurso($recDTO) {
        $sql = 'update recursos set rec_num_patrimonio = :patrimonio, rec_nome = :nome, rec_descricao = :descricao'
                . 'where rec_id = :rec_id';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->bindValue(':patrimonio', $recDTO->getRec_num_patrimonio());
        $rstmt->bindValue(':nome', $recDTO->getRec_nome());
        $rstmt->bindValue(':descricao', $recDTO->getRec_descricao());
        $rstmt->execute();
        return $rstmt->rowCount();
    }
    
    
}