<?php
require_once '../dao/UsuarioDAO.php';

class MenusBO {

    function __construct() {    
        $this->cadParticipanteMenus();
    }
    
    /*
     * busca todos os participantes que estão cadastrados e
     * que não tenha as permissoes de menus, após seta tdas
     *  as permições default para esses usuarios
     */
    public function cadParticipanteMenus(){
            $UsuDao = new UsuarioDAO();
            $arrayObjUsu = $UsuDao->buscarUsuNotPermissao();
            print_r($arrayObjUsu);
        
        
        
    }
    
    
    
    
    

}
new MenusBO();