<?php

class permissaoBO{
    
    public function __construct() {
        
    }
    
    public function buscarPermissao($men_id, $par_id){
        $perDAO = new PermissoesDAO();
       return $perDAO->buscarPermicao($men_id, $par_id);
    }
    
    
    
    
    
    
}

