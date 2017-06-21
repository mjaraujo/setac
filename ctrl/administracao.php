<?php
require_once('../bo/ParticipanteBO.php');

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Classe controller responsável pela página gerencia.php.
 * @data: 20/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
class administracao {
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Construtor responsável por direcionar chamdas das views.
     * @data: 20/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    function __construct(){
        //Capturar chamadas GET e POST usando 'processo' como chave
        $opcao = isset($_POST['processo']) && !empty($_POST['processo']) ? $_POST['processo'] : '';
        $opcao = empty($opcao) && isset($_GET['processo']) && !empty($_GET['processo']) ? $_GET['processo'] : $opcao;

        switch($opcao){
            case 'usu': {
                $parBO = new ParticipanteBO(NULL);
                $lstObjPar = $parBO->listarParticipantes();
                $linhasTabela = $this->montarLinhasTabelaParticipantes($lstObjPar);
                include_once("../participantes.php");
                break;
            }
        }
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método responsável por criar as linhas da tabela na view participantes.php.
     * @data: 20/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    private function montarLinhasTabelaParticipantes($lstObjPar){
        $linhasTabela = "";
        foreach ($lstObjPar as $objPar){
            $linhasTabela .= "<tr>";
            $linhasTabela .= "<td>" . $objPar['par_nome'] . "</td>";
            $linhasTabela .= "<td>" . $objPar['par_email'] . "</td>";
            $linhasTabela .= "<td>" . $objPar['par_instituicao'] . "</td>";
            $linhasTabela .= "<td>" . (empty($objPar['cid_nome']) ? 'Sem endereço' : $objPar['cid_nome'] . " (" . $objPar['est_id'] . ")") . "</td>";
            $linhasTabela .= "<td>" . date("d/m/Y", strtotime($objPar['par_timestamp'])) . "</td>";
            $linhasTabela .= "<td>" . (empty($objPar['usu_status']) ? 'Sem acesso' : $objPar['usu_status'] . "nativo") . "</td>";
            $linhasTabela .= "<td>Editar | Excluir | Ativar</td>";
            $linhasTabela .= "</tr>";
        }
        return $linhasTabela;
    }
    
}

$administracaoControle = new administracao();