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
    
    
}