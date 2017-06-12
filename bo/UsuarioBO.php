<?php
require_once('../dto/UsuarioDTO.php');
require_once('../dao/UsuarioDAO.php');

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Classe responsável pela lógica/regra de negócios de Usuario.
 * @data: 12/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
class UsuarioBO {
    public $usuDTO;
    private $usuDAO;

    public function __construct($arrayUsu){
        if(!is_null($arrayUsu)){
            $this->arrayToObjUsuario($arrayUsu);
        }
    }

    public function arrayToObjUsuario($arrayUsu){
        $this->usuDTO = new UsuarioDTO();
        $this->usuDTO->setUsuNome($arrayUsu['usu_nome'] ?? '');
        $this->usuDTO->setUsuSenha($arrayUsu['usu_senha'] ?? '');
        $this->usuDTO->setUsuStatus($arrayUsu['usu_status'] ?? '');
    }

    public function validarDadosUsuario($usuDTO){
        $erros = "";
        $erros.= ($usuDTO->getUsuNome()=="" ? "'Usuário' é obrigatório." : "");
        $erros.= ($usuDTO->getUsuSenha()=="" ? "'Senha' é obrigatório." : "");
        return $erros;
    }

}
