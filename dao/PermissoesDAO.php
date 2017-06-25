<?php
require_once './Conexao.php';


class PermissoesDAO {
    private $con;
    function __construct() {
        $this->con = Conexao::getInstance();
    }
    
   
}
