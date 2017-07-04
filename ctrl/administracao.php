<?php
require_once('../bo/ParticipanteBO.php');
require_once('../bo/RecursosBO.php');
require_once('../bo/EdicaoBO.php');


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

        //Esta variável pode ser usada nas view para dar feedback ao usuário
        //0 - Deu erro, desconhecido no PHP, 1 - Executou todas as instruções sem erro
        //Caso contrário, já vem preenchida com textos de erros especificos de cada método/solicitação
        $erros = (isset($_GET['erros']) && !empty($_GET['erros']) ? $_GET['erros'] : -1);
        $erros = ($erros==1 ? "Operação realizada." : (empty($erros) ? "Operação não pôde ser realizada." : $erros));
        $erros = ($erros==-1 ? "" : $erros);

        switch($opcao){
            //Listar participantes na view participantes.php
            case 'liusu': {
                /*$parBO = new ParticipanteBO(NULL);
                $lstObjPar = $parBO->listarParticipantes(0, 15);
                $linhasTabela = $this->montarLinhasTabelaParticipantes($lstObjPar);*/
                $title = "Administração: Usuários";
                include_once("../participantes.php");
                break;
            }
            //AJAX - Devolve para administracao.paginarParticipantes no javascript a lista de registros
            //para preencher a tabela do CASE liusu.
            case 'ptp': {//preencherTabelaParticipantes
                $parBO = new ParticipanteBO(NULL);
                $pagina = (isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1)-1;
                $quantidade = (isset($_GET['quantidade']) && !empty($_GET['quantidade']) ? $_GET['quantidade'] : 10);
                $lstObjPar = $parBO->listarParticipantes($pagina*$quantidade, $quantidade);
                echo(str_replace("\"", "aspas", json_encode($lstObjPar)));//para AJAX da tabela
                break;
            }
            //Listar edições na view edições.php
            case 'liedi': {
                $ediBO = new EdicaoBO(NULL);
                $lstObjEdi = $ediBO->listarEdicoes();
                $linhasTabela = $this->montarLinhasTabelaEdicoes($lstObjEdi);
                include_once("../edicoes.php");
                break;
            }
            //Buscar os dados do participante para edição com a view adm_inscricao.php
            case 'edusu': {
                $usuId = isset($_GET['usu']) && !empty($_GET['usu']) ? $_GET['usu'] : 0;
                if($usuId>0){
                    $jsonDados = $this->prepararDadosParticipanteParaEdicaoPeloId($usuId);
                    $dados = str_replace("\"", "aspas", $jsonDados); //Retirando as "s pois este valor ficará dentro de um input hidden, manipulado pelo javascript
                    include_once("../adm_inscricao.php");
                }
                break;
            }case 'rec':{
                $recBO = new RecursosBO();
                $listObjRecursos = $recBO->listarRecursos();
                $linhasTabela = $this->montarLinhasTabelaRecursos($listObjRecursos);
                include_once("../recursos.php");
                
                break;
            }
            //Excluir poderia ser AJAX, mas teria que pensar na paginação depois.
            case 'exusu': {
                $usuId = isset($_GET['usu']) && !empty($_GET['usu']) ? $_GET['usu'] : 0;
                if($usuId>0){
                    $parBO = new ParticipanteBO(NULL);
                    $excluiu = $parBO->excluirDadosParticipantePorId($usuId);
                    header("Location: administracao.php?processo=liusu&erros=".$excluiu);
                }
                break;
            }
            //AJAX - Ativação do usuário.
            case 'siusu': {
                $ativou = false;
                $usuId = isset($_GET['usu']) && !empty($_GET['usu']) ? $_GET['usu'] : 0;
                if($usuId>0){
                    $usuBO = new UsuarioBO(NULL);
                    $ativou = $usuBO->mudarStatusUsuarioPorId($usuId);
                }
                echo($ativou);
                break;
            }
            default: {
                $title = "Painel de Administração";
                include_once('../view/include/inc_adm_header.php');
                include_once('../view/include/inc_menu_adm.php');
                include_once('../view/include/inc_adm_footer.php');
                break;
            }
        }
    }

    /* 
     * @autor: .
     * @descrição: .
     * @data: .
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    private function montarLinhasTabelaRecursos($listObjRecursos){
        $linhasTabela = "";
        foreach ($listObjRecursos as $objPar){
            $linhasTabela .= "<tr>";
            $linhasTabela .= "<td>:NUMERO PATRIMONIO</td>";
            $linhasTabela .= "<td>:NOME</td>";
            $linhasTabela .= "<td>:DESCRICAO</td>";
            $linhasTabela .= "<td>:LKEDITAR | " .
                                 ":LKEXCLUIR" .
            $linhasTabela .= "</tr>";
            
            $lkeditar = "<a href=\"../ctrl/administracao.php?processo=rec&funcao=excluir\">Editar</a>";
            $lkexcluir = "<a href=\"../ctrl/administracao.php?processo=rec&funcao=editar\">Excluir</a>";
            
            $linhasTabela = str_replace(":NUMERO PATRIMONIO", $objPar['rec_num_patrimonio'], $linhasTabela);
            $linhasTabela = str_replace(":NOME", $objPar['rec_nome'], $linhasTabela);
            $linhasTabela = str_replace(":DESCRICAO", $objPar['rec_descricao'], $linhasTabela);
            $linhasTabela = str_replace(":LKEDITAR", $lkeditar, $linhasTabela);
            $linhasTabela = str_replace(":LKEXCLUIR", $lkexcluir, $linhasTabela);;
        }
        return $linhasTabela;
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
            $linhasTabela .= "<td class=\"status\">:SITUACAO</td>";
            $linhasTabela .= "<td>:LKEDITAR | " .
                                 ":LKEXCLUIR | " . 
                                 ":LKSITUACAO</td>";
            $linhasTabela .= "</tr>";
            
            $cidade = (empty($objPar['cid_nome']) ? 'Sem endereço' : $objPar['cid_nome'] . " (" . $objPar['est_id'] . ")");
            $situacao = (empty($objPar['usu_status']) ? 'Sem acesso' : $objPar['usu_status'] . ($objPar['usu_status']=='A' ? "tivo" : "nativo"));
            $lkeditar = "<a href=\"../ctrl/administracao.php?processo=edusu&usu=:USUARIO\">Editar</a>";
            $lkexcluir = "<a href=\"../ctrl/administracao.php?processo=exusu&usu=:USUARIO\">Excluir</a>";
            $lksituacao = "<a class=\"chstatus\" href=\"../ctrl/administracao.php?processo=siusu&usu=:USUARIO\">:rotulo</a>";
            $lksituacao = str_replace(":rotulo", ($objPar['usu_status']=='A' ? "Inativar" : "Ativar"), $lksituacao);
            
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
     * @autor: Márcio Araújo
     * @descrição: Método responsável por criar as linhas da tabela na view edicoes.php.
     * @data: 28/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    private function montarLinhasTabelaEdicoes($lstObjEdi){
        $linhasTabela = "";
        foreach ($lstObjEdi as $objEdi){
            $linhasTabela .= "<tr>";
            $linhasTabela .= "<td>:TEMA</td>";
            $linhasTabela .= "<td>:DESCRICAO</td>";
            $linhasTabela .= "<td>:INICIO</td>";
            $linhasTabela .= "<td>:FIM</td>";
            $linhasTabela .= "<td>:LKEDITAR | " .
                                 ":LKEXCLUIR | " . 
                                 ":LKSITUACAO</td>";
            $linhasTabela .= "</tr>";
            
            $lkeditar = "<a href=\"../ctrl/administracao.php?processo=ededi&edi=:USUARIO\">Editar</a>";
            $lkexcluir = "<a href=\"../ctrl/administracao.php?processo=exedi&edi=:USUARIO\">Excluir</a>";
            $lksituacao = "<a href=\"../ctrl/administracao.php?processo=siedi&edi=:USUARIO\">?</a>";
            $lksituacao = str_replace("?", ($objEdi['edi_status']=='A' ? "Inativar" : "Ativar"), $lksituacao);
            
            $linhasTabela = str_replace(":TEMA", $objEdi['edi_tema'], $linhasTabela);
            $linhasTabela = str_replace(":DESCRICAO", $objEdi['edi_descricao'], $linhasTabela);
            $linhasTabela = str_replace(":INICIO", $objEdi['edi_inicio'], $linhasTabela);
            $linhasTabela = str_replace(":FIM", $objEdi['edi_fim'], $linhasTabela);
            $linhasTabela = str_replace(":LKEDITAR", $lkeditar, $linhasTabela);
            $linhasTabela = str_replace(":LKEXCLUIR", $lkexcluir, $linhasTabela);
            $linhasTabela = str_replace(":LKSITUACAO", $lksituacao, $linhasTabela);
            $linhasTabela = str_replace(":EDICAO", $objEdi['par_id'], $linhasTabela);
        }
        return $linhasTabela;
    }

    /* 
     * @autor: .
     * @descrição: .
     * @data: .
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
