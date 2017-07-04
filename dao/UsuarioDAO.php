<?php

require_once('Conexao.php');

/*
 * @autor: Denis Lucas Silva.
 * @descrição: Classe responsável pela lógica de banco de dados de Usuario.
 * @data: 12/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */

class UsuarioDAO {

    public function __construct() {
        
    }

    /*
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar o usuario pelo participante. Retorno um objeto.
     * @data: 13/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */

    public function buscarUsuarioPorId($usuId) {
        $sql = 'SELECT * FROM usuarios WHERE par_id = :par';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':par', $usuId, PDO::PARAM_INT);
        $pstmt->execute();
        $usu = $pstmt->fetch(PDO::FETCH_OBJ);
        return $usu;
    }

    /*
     * @autor: Denis Lucas Silva.
     * @descrição: Método para salvar os dados de usuario para login.
     * @data: 13/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */

    public function salvarDadosUsuario($usuDTO) {
        $sql = 'INSERT INTO usuarios(usu_nome,usu_senha,par_id) VALUES(:nome,:senha,:par)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', $usuDTO->getUsuNome(), PDO::PARAM_STR);
        $pstmt->bindValue(':senha', $usuDTO->getUsuSenha(), PDO::PARAM_STR);
        $pstmt->bindValue(':par', $usuDTO->getPar()->getParId(), PDO::PARAM_INT);
        $pstmt->execute();
        return $pstmt->rowCount();
    }

    /*
     * Busca todos os usuarios que não possuem permissões 
     */

    public function buscarUsuNotPermissao() {
        $sql = 'SELECT u.par_id FROM usuarios u WHERE u.par_id NOT IN (SELECT par_id FROM permissoes )';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * Busca usuario com nome e senha informados 
     */

    public function logarUser($usuDTO) {
        $sql = 'SELECT * FROM usuarios u WHERE usu_nome = :nome and usu_senha = :senha and usu_status = 1';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', $usuDTO->getUsuNome(), PDO::PARAM_STR);
        $pstmt->bindValue(':senha', $usuDTO->getUsuSenha(), PDO::PARAM_STR);
        $pstmt->execute();
        return $pstmt->fetch(PDO::FETCH_ASSOC);
    }

}
