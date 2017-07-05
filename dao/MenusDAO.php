<?php

class MenusDAO {

    private $con;

    function __construct() {
        $this->con = Conexao::getInstance();
    }

    public function buscarMenusDefault() {
        $sql = 'SELECT men_id FROM menus WHERE men_default = 1';
        $pstmt = $this->con->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrarMenu($menu) {
        
    }

    public function alterarMenu($menu) {
       // $menu = new MenusDTO($arrayMenu);
        try {
            $sql = "UPDATE menus SET `men_nome`= ?, `men_nivel`= ?, `men_posicao`= ?, `men_menpai`= ?,
            men_evento`= ?, `men_processo`= ?,
            `men_sistema`= ?, `men_default`= ? WHERE `men_id`= ?;";
            $pstmt = $this->con->prepare($sql);
             $pstmt->bindValue(1,$menu->getMen_nome());
             $pstmt->bindValue(2,$menu->getMen_nivel());
             $pstmt->bindValue(3,$menu->getMen_posicao());
             $pstmt->bindValue(4,$menu->getMen_menpai());
             $pstmt->bindValue(5,$menu->getMen_evento());
             $pstmt->bindValue(6,$menu->getMen_processo());
             $pstmt->bindValue(7,$menu->getMen_sistema());
             $pstmt->bindValue(8,$menu->getMen_default());
             $pstmt->bindValue(9,$menu->getMen_id());
            $pstmt->execute();
            return 1;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function buscarMenusEventoProcesso($menu){
     //   $menu = new MenusDTO($arrayMenu);
        try {
            $sql = "SELECT * FROM menus WHERE men_evento = '".$menu->getMen_evento()."'  and men_processo like'%".$menu->getMen_processo()."%';";
            $pstmt = $this->con->prepare($sql);
            $pstmt->execute();
            return $pstmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        
        
    }

}
