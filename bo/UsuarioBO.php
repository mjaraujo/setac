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

        $this->usuDTO = new UsuarioDTO($arrayUsu);
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
            $usuOBJ = $this->usuDAO->buscarUsuarioPorId($this->usuDTO->getPar()->getParId());
            $usuId = $usuOBJ->par_id;
        }
        return $usuId;
    }

    public function efeturaLogin() {
        $usuDAO = new UsuarioDAO();
        return $usuDAO->logarUser($this->usuDTO);
    }
    
    
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar os dados de um usuário através do id.
     *             Retorna um objeto usuário do banco.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarUsuarioPorId($usuId){
        $this->usuDAO = new UsuarioDAO();
        $objUsu = $this->usuDAO->buscarUsuarioPorId($usuId);
        return $objUsu;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para atualizar os dados de um usuário através do id.
     *             Retorna o id do usuario atualizado.
     * @data: 27/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function atualizarDadosUsuario(){
        $this->usuDAO = new UsuarioDAO();
        $this->usuDAO->atualizarDadosUsuario($this->usuDTO);
        return $this->usuDTO->getPar()->getParId(); //Chave estrangeira e primária.
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para excluir um usuário por seu id.
     *             Retorna false, se não excluir, e true, se excluir.
     * @data: 27/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function excluirUsuarioPorId($usuId){
        $this->usuDAO = new UsuarioDAO();
        return $this->usuDAO->excluirUsuarioPorId($usuId);
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para ativar ou desativar um usuário por seu id, com base no seu status atual.
     *             Retorna false, se não altera, e true, se alterar.
     * @data: 28/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function mudarStatusUsuarioPorId($usuId){
        $resp = false;
        $this->usuDAO = new UsuarioDAO();
        $status = $this->usuDAO->buscarUsuarioPorId($usuId);
        if(!empty($status)){
            $status = $status->usu_status=='I' ? 'A' : 'I';
            $resp = $this->usuDAO->mudarStatusUsuarioPorId($usuId, $status);
        }
        return $resp;
    }

}
