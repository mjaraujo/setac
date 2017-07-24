<?php
require_once('../dto/RecursosDTO.php');
require_once('../dao/RecursosDAO.php');


class RecursosBO extends RecursosDTO {
    public $recDTO;
    private $recDAO;
     
    function __construct($arrayRec){
        if($arrayRec != null){
            $this->arrayToDTOAtividade($arrayRec);
        }
    }
    
    public function arrayToDTOAtividade($arrayRec){
        $this->recDTO = new RecursosDTO();
        $this->recDTO->setRec_patrimonio($arrayRec['rec_patrimonio'] ?? "");
        $this->recDTO->setRec_nome($arrayRec['rec_nome'] ?? "");
        $this->recDTO->setRec_descricao($arrayRec['rec_descricao'] ?? "");
    }

    public function listarRecursos($apartir, $quantidade){
        $this->recDAO = new RecurosDAO();
        return $this->recDAO->listarRecursos($apartir, $quantidade);
    }

    /* 
     * @autor: Luca Prediger.
     * @descrição: Método para salvar recurso.
     *             O recurso só pode ser salvo se não existir cadastrado outro com mesmo patrimonio.
     * @data: 10/07/2017.
     * @alterada em: 10/07/2017, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: Denis, nome, nome, etc.
     */
    public function salvarRecurso() {
        $regComPatrimonio = NULL;
        if(!empty($this->recDTO->getRec_patrimonio)){
            $regComPatrimonio = $this->buscarRecursoPorPatrimonio($this->recDTO->getRec_patrimonio);
        }
        $regsComNome = $this->buscarRecursoPorNome($this->recDTO->getRec_nome);
        
        if(empty($regComPatrimonio) && (empty($regsComNome) || empty($this->recDTO->getRec_patrimonio))){
            $this->recDAO = new RecurosDAO(); 
            return $this->recDAO->salvarRecurso($this->recDTO);
        }
        return 0;
    }
    
    public function excluirRecurso() {
        $this->recDAO = new RecurosDAO(); 
        return $this->recDAO->deleteRecurso($this->recDTO->getRec_id());
    }
    public function buscarRecursoPorId($id) {
        $this->recDAO = new RecurosDAO(); 
        return $this->recDAO->buscarRecursoPorId($id);
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar recurso pelo nome.
     *             Retorno uma lista de objetos recurso do banco.
     * @data: 10/07/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarRecursoPorNome($recNome) {
        $this->recDAO = new RecurosDAO(); 
        return $this->recDAO->buscarRecursoPorNome($recNome);
    }
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método para buscar recurso pela identificação de patrimonio do recurso.
     *             Retorno um objeto recurso do banco.
     * @data: 10/07/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    public function buscarRecursoPorPatrimonio($recPatrimonio) {
        $this->recDAO = new RecurosDAO(); 
        return $this->recDAO->buscarRecursoPorPatrimonio($recPatrimonio);
    }
}

