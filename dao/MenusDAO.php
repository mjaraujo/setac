<?php

class MenusDAO {
   private  $con;
      
   
   
   function __construct() {
       $this->con = Conexao::getInstance();
   }
   
   
   public function buscarMenusDefault(){
        $sql = 'SELECT * FROM menus where';
        $pstmt = $con->prepare($sql);
        $pstmt->execute();
        $end = $pstmt->fetch(PDO::FETCH_OBJ);
        return $end;
   }

}