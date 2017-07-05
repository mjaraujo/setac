<?php
require_once '../dao/Conexao.php';
require_once '../dto/RecursosDTO.php';

class RecurosDAO extends RecursosDTO{

    function __construct($rec_id, $rec_num_patrimonio,  $rec_nome, $rec_descricao, $rec_timestamp) {
        parent::__construct($rec_id, $rec_num_patrimonio,  $rec_nome, $rec_descricao, $rec_timestamp);
    }
    
    public function listAll(){
        $sql = 'select * from recursos;';
        $rstmt = Conexao::getInstance()->prepare($sql);
        $rstmt->execute();
        return $rstmt->fetchAll();
        
    }
    
    
}