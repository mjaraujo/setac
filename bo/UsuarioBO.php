<?php
require_once('../dto/UsuarioDTO.php');
require_once('../dao/UsuarioDAO.php');

require_once('ParticipanteBO.php');

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
        $parBO = new ParticipanteBO($arrayUsu);

        $this->usuDTO = new UsuarioDTO();
        $this->usuDTO->setUsuNome($arrayUsu['usu_nome'] ?? '');
        $this->usuDTO->setUsuSenha($arrayUsu['usu_senha'] ?? '');
        $this->usuDTO->setUsuStatus($arrayUsu['usu_status'] ?? '');
        $this->usuDTO->setPar($parBO->parDTO);
    }

    public function validarDadosUsuario($usuDTO){
        $erros = "";
        $erros.= ($usuDTO->getUsuNome()=="" ? "'Usuário' é obrigatório." : "");
        $erros.= ($usuDTO->getUsuSenha()=="" ? "'Senha' é obrigatório." : "");
        return $erros;
    }
    
    public function salvarDadosUsuario(){
        $usuId = 0;
        $this->usuDAO = new UsuarioDAO();
        $nrReg = $this->usuDAO->salvarDadosUsuario($this->usuDTO);
        if($nrReg>0){
            $usuOBJ = $this->usuDAO->buscarUsuarioPorParticipante($this->usuDTO->getPar()->getParId());
            $usuId = $usuOBJ->par_id;
        }
        return $usuId;
    }

}
