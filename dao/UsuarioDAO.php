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
    public function buscarUsuarioPorParticipante($parId){
        $sql = 'SELECT * FROM usuarios WHERE par_id = :par';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':par', $parId, PDO::PARAM_INT);
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
        $sql = '  SELECT u.par_id FROM usuarios u JOIN permissoes p on u.par_id != p.par_id;';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        $usu = $pstmt->fetch(PDO::FETCH_OBJ);
        return $usu;
    }

    
}
