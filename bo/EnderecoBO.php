<?php 
require_once('../dto/EnderecoDTO.php');
require_once('../dao/EnderecoDAO.php');

require_once('LogradouroBO.php');
require_once('ParticipanteBO.php');

class EnderecoBO{
    public $endDTO;
    private $endDAO;

    public function __construct($arrayEnd){
            $this->arrayToObjEndereco($arrayEnd);
    }

    public function arrayToObjEndereco($arrayEnd){
            $logBO = new LogradouroBO($arrayEnd);
            $parBO = new ParticipanteBO($arrayEnd);

            $this->endDTO = new EnderecoDTO();
            $this->endDTO->setEndId($arrayEnd['end_id'] ?? 0);
            $this->endDTO->setEndComplemento($arrayEnd['end_complemento'] ?? '');
            $this->endDTO->setEndNumero($arrayEnd['end_numero'] ?? '');
            $this->endDTO->setLog($logBO->logDTO);
            $this->endDTO->setPar($parBO->parDTO);
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método responsável por preparar os dados de endereço para salvar, chamando o salvar do DAO.
     *             Retorna o id do endereço salvo.
     * @data: ~08/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function salvarDadosEndereco(){
        $endId = 0;
        $this->endDAO = new EnderecoDAO();
        $nrReg = $this->endDAO->salvarDadosEndereco($this->endDTO);
        if($nrReg>0){
            $endOBJ = $this->endDAO->buscarEnderecoPorParticipanteId($this->endDTO->getPar()->getParId());
            $endId = $endOBJ->end_id;
        }
        return $endId;
    }
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar os dados de endereço de um participante através do seu id.
     *             Retorna um objeto endereco do banco.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarEnderecoPorParticipanteId($parId){
        $this->endDAO = new EnderecoDAO();
        $objEnd = $this->endDAO->buscarEnderecoPorParticipanteId($parId);
        return $objEnd;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método responsável por preparar os dados de endereço para atualizar, chamando o atualizar do DAO.
     *             Retorna o id do endereço atualizado.
     * @data: 27/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function atualizarDadosEndereco(){
        $this->endDAO = new EnderecoDAO();
        $this->endDAO->atualizarDadosEndereco($this->endDTO);
        return $this->endDTO->getEndId();
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para excluir um endereço por participante id.
     *             Retorna false, se não excluir, e true, se excluir.
     * @data: 27/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function excluirEnderecoPorParticipanteId($parId){
        $this->endDAO = new EnderecoDAO();
        return $this->endDAO->excluirEnderecoPorParticipanteId($parId);
    }
}