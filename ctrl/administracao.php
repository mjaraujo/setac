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
            //Listar participantes na view participantes.php
            case 'liusu': {
                $parBO = new ParticipanteBO(NULL);
                $lstObjPar = $parBO->listarParticipantes();
                $linhasTabela = $this->montarLinhasTabelaParticipantes($lstObjPar);
                include_once("../participantes.php");
                break;
            }
            //Listar participantes na view participantes.php
            case 'edusu': {
                $usuId = isset($_GET['usu']) && !empty($_GET['usu']) ? $_GET['usu'] : 0;
                if($usuId>0){
                    $jsonDados = $this->prepararDadosParticipanteParaEdicaoPeloId($usuId);
                    $dados = str_replace("\"", "aspas", $jsonDados); //Retirando as "s pois este valor ficará dentro de um input hidden, manipulado pelo javascript
                    include_once("../adm_inscricao.php");
                }
                break;
            }
            default: {
                include_once('../view/include/inc_adm_header.php');
                include_once('../view/include/inc_menu_adm.php');
                include_once('../view/include/inc_adm_footer.php');
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
            $linhasTabela .= "<td>:NOME</td>";
            $linhasTabela .= "<td>:EMAIL</td>";
            $linhasTabela .= "<td>:INSTITUICAO</td>";
            $linhasTabela .= "<td>:CIDADE</td>";
            $linhasTabela .= "<td>:DATACAD</td>";
            $linhasTabela .= "<td>:SITUACAO</td>";
            $linhasTabela .= "<td>:LKEDITAR | " .
                                 ":LKEXCLUIR | " . 
                                 ":LKSITUACAO</td>";
            $linhasTabela .= "</tr>";
            
            $cidade = (empty($objPar['cid_nome']) ? 'Sem endereço' : $objPar['cid_nome'] . " (" . $objPar['est_id'] . ")");
            $situacao = (empty($objPar['usu_status']) ? 'Sem acesso' : $objPar['usu_status'] . ($objPar['usu_status']=='A' ? "tivo" : "nativo"));
            $lkeditar = "<a href=\"../ctrl/administracao.php?processo=edusu&usu=:USUARIO\">Editar</a>";
            $lkexcluir = "<a href=\"../ctrl/administracao.php?processo=exusu&usu=:USUARIO\">Excluir</a>";
            $lksituacao = "<a href=\"../ctrl/administracao.php?processo=siusu&usu=:USUARIO\">?</a>";
            $lksituacao = str_replace("?", ($objPar['usu_status']=='A' ? "Inativar" : "Ativar"), $lksituacao);
            
            $linhasTabela = str_replace(":NOME", $objPar['par_nome'], $linhasTabela);
            $linhasTabela = str_replace(":EMAIL", $objPar['par_email'], $linhasTabela);
            $linhasTabela = str_replace(":INSTITUICAO", $objPar['par_instituicao'], $linhasTabela);
            $linhasTabela = str_replace(":CIDADE", $cidade, $linhasTabela);
            $linhasTabela = str_replace(":DATACAD", date("d/m/Y", strtotime($objPar['par_timestamp'])), $linhasTabela);
            $linhasTabela = str_replace(":SITUACAO", $situacao, $linhasTabela);
            $linhasTabela = str_replace(":LKEDITAR", $lkeditar, $linhasTabela);
            $linhasTabela = str_replace(":LKEXCLUIR", $lkexcluir, $linhasTabela);
            $linhasTabela = str_replace(":LKSITUACAO", $lksituacao, $linhasTabela);
            $linhasTabela = str_replace(":USUARIO", $objPar['par_id'], $linhasTabela);
        }
        return $linhasTabela;
    }

    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método responsável por criar um JSON com todos os dados do participanteas para a view inc_form_inscricao.php.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    private function prepararDadosParticipanteParaEdicaoPeloId($parId){
        $parBO = new ParticipanteBO(NULL);
        $usuBO = new UsuarioBO(NULL);
        $endBO = new EnderecoBO(NULL);
        $logBO = new LogradouroBO(NULL);
        $cidBO = new CidadeBO(NULL);

        $objPar = $parBO->buscarParticipantePorId($parId);
        $objUsu = $usuBO->buscarUsuarioPorId($parId);
        $objEnd = $endBO->buscarEnderecoPorParticipanteId($parId);
        if(!empty($objEnd)){//Não tem endereço cadastrado
            $objLog = $logBO->buscarLogradouroPorId($objEnd->log_id);
            $objCid = $cidBO->buscarCidadePorId($objLog->cid_id);
        }else{//Só para não dar erro nos foreach
            $objEnd = []; $objLog = []; $objCid = [];
        }
        if(empty($objUsu)){//Não tem usuário cadastrado
            $objUsu = [];
        }
        
        $data = array();
        foreach($objPar as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        foreach($objUsu as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        foreach($objEnd as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        foreach($objLog as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        foreach($objCid as $indice => $valor) { if(!isset($data[$indice])){ $data[$indice] = $valor; }}
        return json_encode($data);
    }
    
}

$administracaoControle = new administracao();