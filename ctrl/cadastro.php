<?php
require_once('../bo/ParticipanteBO.php');
/*require_once('UsuarioBO.php');*/
require_once('../bo/CidadeBO.php');
require_once('../bo/LogradouroBO.php');
require_once('../bo/EnderecoBO.php');

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Classe controller responsável pelos cadastros.
 * @data: 06/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
class cadastro {
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Construtor responsável por direcionar chamdas das views, sem uma chamada especifica carrega a view inscricao.php.
     * @data: 06/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    function __construct(){
        //Capturar chamadas GET e POST usando 'processo' como chave
        $opcao = isset($_POST['processo']) && !empty($_POST['processo']) ? $_POST['processo'] : '';
        $opcao = empty($opcao) && isset($_GET['processo']) && !empty($_GET['processo']) ? $_GET['processo'] : $opcao;

        switch($opcao){
            case 'novo': {
                $parBO = new ParticipanteBO($_POST);
                $erros = $parBO->salvarDadosCadastroParticipante($_POST);
                $dados = json_encode($_POST);
                $dados = str_replace("\"", "aspas", $dados);
                include_once("../inscricao.php");
                break;
            }
            case 'cep':{
                $pCep = $_GET['cep'];
                $objLog = new LogradouroBO(null);
                $jsonLog = json_encode($objLog->buscarDadosLogradouroPeloCep($pCep));
                echo($jsonLog);
                break;
            }
            case 'estados':{
                $estBO = new EstadoBO(null);
                $lstObjEst = $estBO->buscarTodosEstados();
                $this->montarOpcoesSelectEstados($lstObjEst);
                break;
            }
            case 'edicoes':{
                $ediBO = new EdicaoBO(null);
                $lstObjEdi = $ediBO->buscarTodasEdicoes();
                $this->montarOpcoesSelectEstados($lstObjEst);
                break;
            }
            default:{
               include_once("../inscricao.php");
            }
        }
    }
    
    private function montarOpcoesSelectEstados($estList){
        $optSelect = '';
        foreach ($estList as $est){
            $optSelect .= "<option value=\":sigla\">:rotulo</option>";
            $optSelect = str_replace(":sigla", $est['est_id'], $optSelect);
            $optSelect = str_replace(":rotulo", $est['est_nome'], $optSelect);
        }
        echo($optSelect);
    }
    
}

$cadastroControle = new cadastro();