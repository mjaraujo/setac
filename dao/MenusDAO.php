<?php

class MenusDAO {
   private  $con;
      
   
   
   function __construct() {
       $this->con = Conexao::getInstance();
   }
   
   
   public function buscarMenusDefault(){
        $sql = 'SELECT men_id FROM menus WHERE men_default = 1';
        $pstmt = $this->con->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetch(PDO::FETCH_ASSOC);
   }

}