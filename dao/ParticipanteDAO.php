<?php
require_once('Conexao.php');

require_once('CidadeDAO.php');
require_once('LogradouroDAO.php');
require_once('EnderecoDAO.php');
require_once('UsuarioDAO.php');

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Classe responsável pela lógica de banco de dados de Participante.
 * @data: 08/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
class ParticipanteDAO {
    public function __construct(){}

    public function listarParticipantes(){
        /*$sql = 'SELECT * FROM participantes par ' .
               'LEFT OUTER JOIN usuarios usu ON usu.par_id = par.par_id';*/
        $sql = 'SELECT par.par_id, par.par_nome, par.par_email, par.par_instituicao, par.par_timestamp, usu.usu_status, cid.cid_nome, cid.est_id FROM participantes par ' .
               'LEFT OUTER JOIN usuarios usu ON usu.par_id = par.par_id ' .
               'LEFT OUTER JOIN enderecos end ON end.par_id = par.par_id ' .
               'LEFT OUTER JOIN logradouros log ON log.log_id = end.log_id ' .
               'LEFT OUTER JOIN cidades cid ON cid.cid_id = log.cid_id';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->execute();
        return $pstmt->fetchAll();
    }
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar o participante pelo nome, número dos documentos e pelo e-mail.
     *             Retorno um objeto.
     * @data: 14/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarParticipantePorNomeDocsEmail($parNome, $parRG, $parCPF, $parEmail){
        $sql = 'SELECT * FROM participantes WHERE lower(par_nome) = :nome AND (par_rg = :rg OR par_cpf = :cpf) AND lower(par_email) = :email';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', strtolower($parNome), PDO::PARAM_STR);
        $pstmt->bindValue(':rg', $parRG, PDO::PARAM_STR);
        $pstmt->bindValue(':cpf', $parCPF, PDO::PARAM_STR);
        $pstmt->bindValue(':email', $parEmail, PDO::PARAM_STR);
        $pstmt->execute();
        $par = $pstmt->fetch(PDO::FETCH_OBJ);
        return $par;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para salvar os dados de participante (sem foto).
     * @data: 13/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function salvarDadosParticipante($parDTO){
        $sql = 'INSERT INTO participantes(par_nome,par_rg,par_cpf,par_email,par_instituicao) '
                  . 'VALUES(:nome,:rg,:cpf,:email,:instituicao)';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':nome', $parDTO->getParNome(), PDO::PARAM_STR);
        $pstmt->bindValue(':rg', $parDTO->getParRG(), PDO::PARAM_STR);
        $pstmt->bindValue(':cpf', $parDTO->getParCPF(), PDO::PARAM_STR);
        $pstmt->bindValue(':email', $parDTO->getParEmail(), PDO::PARAM_STR);
        $pstmt->bindValue(':instituicao', $parDTO->getParInstituicao(), PDO::PARAM_STR);
        $pstmt->execute();
        return $pstmt->rowCount();
    }
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar o participante pelos números dos documentos.
     *             Retorna um objeto com RG ou CPF igaul ao informado.
     * @data: 14/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarParticipantePorDocumentos($parRG, $parCPF){
        $sql = 'SELECT * FROM participantes WHERE par_cpf = :cpf OR par_rg = :rg';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':cpf', $parCPF, PDO::PARAM_STR);
        $pstmt->bindValue(':rg', $parRG, PDO::PARAM_STR);
        $pstmt->execute();
        $par = $pstmt->fetch(PDO::FETCH_OBJ);
        return $par;
    }
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar o participante pelo e-mail. Retorno um objeto.
     * @data: 14/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarParticipantePorEmail($parEmail){
        $sql = 'SELECT * FROM participantes WHERE lower(par_email) = :email';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':email', $parEmail, PDO::PARAM_STR);
        $pstmt->execute();
        $par = $pstmt->fetch(PDO::FETCH_OBJ);
        return $par;
    }
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para salvar os dados da inscrição de participante, endereço e usuário utilizando transação.
     *             De todos os dados da inscrição somente os supra citados não podem ser orgãos.
     *             Retorno um objeto.
     * @data: 14/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function salvarDadosInscricaoParticipante($logId, $parDTO, $endDTO, $usuDTO){
        $endDAO = new EnderecoDAO();
        $usuDAO = new UsuarioDAO();
        $resp = false;
        $con = Conexao::getInstance();
        try {
            $con->beginTransaction();

            //Salvar participante e pegar o id
            $this->salvarDadosParticipante($parDTO);
            $parId = $con->lastInsertId();
            //$parOBJ = $this->buscarParticipantePorNomeDocsEmail($parDTO->getParNome(), $parDTO->getParRG(), $parDTO->getParCPF(), $parDTO->getParEmail());
            //$parId = $parOBJ->par_id;
            
            $endDTO->getLog()->setLogId($logId);
            $endDTO->getPar()->setParId($parId);
            $endDAO->salvarDadosEndereco($endDTO);

            $usuDTO->getPar()->setParId($parId);
            $usuDAO->salvarDadosUsuario($usuDTO);

            $con->commit();
            $resp = true;
        }catch(PDOException $e){
            $con->rollBack();
            echo($e->getMessage());
        }
        return $resp;
    }
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar o participante pelo id.
     *             Retorno um objeto.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarParticipantePorId($parId){
        $sql = 'SELECT * FROM participantes WHERE par_id = :id';
        $pstmt = Conexao::getInstance()->prepare($sql);
        $pstmt->bindValue(':id', $parId, PDO::PARAM_INT);
        $pstmt->execute();
        $par = $pstmt->fetch(PDO::FETCH_OBJ);
        return $par;
    }
}