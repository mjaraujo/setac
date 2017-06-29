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
    public function __construct(){}
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar o usuario pelo participante. Retorno um objeto.
     * @data: 13/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarUsuarioPorId($usuId){
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
    public function salvarDadosUsuario($usuDTO){
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
    public function buscarUsuNotPermissao(){
        $sql = 'SELECT u.par_id FROM usuarios u WHERE u.par_id NOT IN (SELECT par_id FROM permissoes )';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetch(PDO::FETCH_ASSOC);
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para atualizar os dados de usuario para login.
     * @data: 27/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function atualizarDadosUsuario($usuDTO){
        $sql = 'UPDATE usuarios SET usu_nome = :nome, usu_senha = :senha WHERE par_id = :id';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', $usuDTO->getUsuNome(), PDO::PARAM_STR);
        $pstmt->bindValue(':senha', $usuDTO->getUsuSenha(), PDO::PARAM_STR);
        $pstmt->bindValue(':id', $usuDTO->getPar()->getParId(), PDO::PARAM_INT);
        $pstmt->execute();
        return $pstmt->rowCount();
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para excluir um usuario por seu id.
     *             Retorna false, se não excluir, e true, se excluir.
     * @data: 27/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function excluirUsuarioPorId($usuId){
        $sql = 'DELETE FROM usuarios WHERE  par_id = :id';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':id', $usuId, PDO::PARAM_INT);
        return $pstmt->execute();
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para ativar ou desativar um usuário por seu id, com base no seu status atual.
     *             Retorna false, se não altera, e true, se alterar.
     * @data: 28/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function mudarStatusUsuarioPorId($usuId, $status){
        $sql = 'UPDATE usuarios SET usu_status = :st WHERE  par_id = :id';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':st', $status, PDO::PARAM_STR);
        $pstmt->bindValue(':id', $usuId, PDO::PARAM_INT);
        return $pstmt->execute();
    }
}
