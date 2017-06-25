<?php

class MenusDAO {
   private  $con;
      
   
   
   function __construct() {
       $this->con = Conexao::getInstance();
   }
   
   
   public function buscarMenusDefault(){
        $sql = 'SELECT * FROM menus WHERE men_default = 1';
        $pstmt = $this->con->prepare($sql);
        $pstmt->execute();
        $men = $pstmt->fetch(PDO::FETCH_OBJ);
        return $men;
   }

}