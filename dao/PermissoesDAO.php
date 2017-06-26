<?php

require_once '../dao/Conexao.php';

class PermissoesDAO {

    private $con;

    function __construct() {
        $this->con = Conexao::getInstance();
    }

    public function cadMenuUsuario($men_id, $par_id) {
        try {
            $sql = 'INSERT INTO permissoes (men_id,par_id) values ( ? , ? );';
            $pstmt = $this->con->prepare($sql);
            $pstmt->bindParam(1, $men_id, PDO::PARAM_STR);
            $pstmt->bindParam(2, $par_id, PDO::PARAM_STR);
            $pstmt->execute();
            return 1;
        } catch (PDOException $e) {
            return $e;
        }
    }

}
