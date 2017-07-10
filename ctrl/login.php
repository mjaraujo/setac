<?php

require_once '../bo/UsuarioBO.php';

class login {

    public function __construct() {
        $opcao = isset($_POST['processo']) && !empty($_POST['processo']) ? $_POST['processo'] : '';
        $opcao = empty($opcao) && isset($_GET['processo']) && !empty($_GET['processo']) ? $_GET['processo'] : $opcao;

        switch ($opcao) {
            case 'login': {
                $userBO = new UsuarioBO($_POST);
                $objUsu = $userBO->efeturaLogin();
                if($objUsu!=NULL){
                    $participanteBO = new ParticipanteBO(NULL);
                    $partDTO = $participanteBO->buscarParticipantePorId($objUsu->par_id);
                    session_start();
                    $_SESSION["usu_nome"] = $userDTO["usu_nome"];
                    $_SESSION["par_nome"] = $partDTO["par_nome"];
                    $_SESSION["par_id"] = $partDTO["par_id"];
                    header('location:../index.php');
                }else{
                    $this->logout();
                }
                break;
            }
            default : {
                $this->logout();
            }
        }
    }

    private function logout() {
        session_start();
        session_destroy();
        header('location:../index.php');
    }

    private function validaUser($post, $userBD) {
//        if ($post['usu_nome'] == $userBD['usu_nome'] && $post['usu_senha'] == $userBD['usu_senha']) {
//            return true;
//        }
//        return false;
        return true;
    }

}

$login = new login();
