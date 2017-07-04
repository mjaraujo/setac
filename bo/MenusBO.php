<?php

require_once '../dao/UsuarioDAO.php';
require_once '../dao/MenusDAO.php';
require_once '../dao/PermissoesDAO.php';
require_once '../dto/MenusDTO.php';

class MenusBO {

    private $menuDTO;

    /*
     * busca todos os participantes que estão cadastrados e
     * que não tenha as permissoes de menus, após seta tdas
     *  as permições default para esses usuarios
     */

    public function __construct($arrayMenu) {
        $this->arrayToObjMenus($arrayMenu);
    }

    public function arrayToObjMenus($arrayMenu) {
        $this->menuDTO = new MenusDTO($arrayMenu);
//        $this->menuDTO->setMen_evento($arrayMenu['men_evento'] ?? '');
//        $this->menuDTO->setMen_id($arrayMenu['men_id']?? '');
//        $this->menuDTO->setMen_nivel($arrayMenu['men_nivel']?? '');
//        $this->menuDTO->setMen_menpai($arrayMenu['men_menpai']?? '');
//        $this->menuDTO->setMen_nome($arrayMenu['men_nome']?? '');
//        $this->menuDTO->setMen_posicao($arrayMenu['men_posicao']?? '');
//        $this->menuDTO->setMen_sistema($arrayMenu['men_sistema']?? '');
//        $this->menuDTO->setMen_processo($arrayMenu['men_processo']?? '');
//        $this->menuDTO->setMen_default($arrayMenu['men_default']?? '');
    }

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

    public function salvarMenu() {
        $menusDAO = new MenusDAO();
        try {
            echo 'chegou <pre>';
            var_dump($this->menuDTO);
            if ($this->menuDTO->getMen_id()) {
                $menusDAO->alterarMenu($this->menuDTO);
                return 'alterou';
            } else {
                //$menusDAO->cadastrarMenu($this->menuDTO);
                return 'cadastrou';
            }
        } catch (Exception $ex) {
            return "Erro - " . $ex;
        }
    }

}
