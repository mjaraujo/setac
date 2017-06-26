<?php

require_once '../dao/UsuarioDAO.php';
require_once '../dao/MenusDAO.php';
require_once '../dao/PermissoesDAO.php';

class MenusBO {

    function __construct() {    }

    /*
     * busca todos os participantes que estão cadastrados e
     * que não tenha as permissoes de menus, após seta tdas
     *  as permições default para esses usuarios
     */

    public function cadParticipanteMenus() {

        try {
            $UsuDao = new UsuarioDAO();
            $arrayObjUsu = $UsuDao->buscarUsuNotPermissao() ?? 0;

            if ($arrayObjUsu) {
                $menuDAO = new MenusDAO();
                $arrayIdMenus = $menuDAO->buscarMenusDefault();
             

                foreach ($arrayObjUsu as $participante) {
                    foreach ($arrayIdMenus as $menu) {
                           $permissoesDAO = new PermissoesDAO();
                        $permissoesDAO->cadMenuUsuario($menu['men_id'], $participante['par_id']);
                    }
                }
////            while ($participante = $arrayObjUsu->fetch()){
////                while($menu  = $arrayIdMenus->fetch()){
////                    $permissoesDAO->cadMenuUsuario($menu['men_id'], $participante['par_id']);
////                }
////                
////            }
////                for ($i = 0; $i < count($arrayObjUsu); $i++) {
////                    for ($j = 0; $j < count($arrayIdMenus); $j++) {
////                        $permissoesDAO->cadMenuUsuario($arrayIdMenus['men_id'], $arrayObjUsu['par_id']);
//                    
//                   }
            }
        } catch (Exception $ex) {
            echo 'Erro ao executar ação - ' . $ex;
        }

    }

}


