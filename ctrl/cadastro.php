<?php

require_once('../bo/ParticipanteBO.php');
/* require_once('UsuarioBO.php'); */
require_once('../bo/CidadeBO.php');
require_once('../bo/LogradouroBO.php');
require_once('../bo/EnderecoBO.php');
require_once ('../bo/MenusBO.php');

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
    function __construct() {
        //Capturar chamadas GET e POST usando 'processo' como chave
        $opcao = isset($_POST['processo']) && !empty($_POST['processo']) ? $_POST['processo'] : '';
        $opcao = empty($opcao) && isset($_GET['processo']) && !empty($_GET['processo']) ? $_GET['processo'] : $opcao;

        //Esta variável pode ser usada nas view para dar feedback ao usuário
        //0 - Deu erro, desconhecido no PHP, 1 - Executou todas as instruções sem erro
        //Caso contrário, já vem preenchida com textos de erros especificos de cada método/solicitação
        $erros = (isset($_GET['erros']) && !empty($_GET['erros']) ? $_GET['erros'] : -1);
        $erros = ($erros==1 ? "Operação realizada." : (empty($erros) ? "Operação não pôde ser realizada." : $erros));
        $erros = ($erros==-1 ? "" : $erros);

        switch ($opcao) {
            case 'novo': {
                $parBO = new ParticipanteBO($_POST);
                $estaSalvo = $parBO->salvarDadosInscricaoParticipante($_POST);
                $dados = json_encode($_POST);
                $dados = str_replace("\"", "aspas", $dados); //Retirando as "s pois este valor ficará dentro de um input hidden, manipulado pelo javascript 
                $menuBO = new MenusBO();
                $menuBO->cadParticipanteMenus();
                if ($estaSalvo) {
                    header("Location: index.php");
                } else {
                    echo($estaSalvo);
                    include_once("../inscricao.php");
                }
                break;
            }
            case 'editar': {
                $parBO = new ParticipanteBO($_POST);
                $erros = $parBO->atualizarDadosInscricaoParticipante($_POST);
                $menuBO = new MenusBO();
                $menuBO->cadParticipanteMenus();
                //Redirecionar para o controller origem (VER NA EDIÇÃO PELO USUARIO)
                $redir = $_SERVER["HTTP_REFERER"];
                $redir = str_replace($_SERVER["HTTP_ORIGIN"], "", $redir);
                $redir .=  "&erros=" . $erros;
                header("Location: " . $redir);
                break;
            }
            case 'cep': {//AJAX
                $pCep = $_GET['cep'];
                $objLog = new LogradouroBO(null);
                $jsonLog = json_encode($objLog->buscarLogradouroPorCep($pCep));
                echo($jsonLog);
                break;
            }
            case 'estados': {//AJAX
                $estBO = new EstadoBO(null);
                $lstObjEst = $estBO->buscarTodosEstados();
                echo(json_encode($lstObjEst));
                //$this->montarOpcoesSelectEstados($lstObjEst);
                break;
            }
            case 'edicoes': {
                $ediBO = new EdicaoBO(null);
                $lstObjEdi = $ediBO->buscarTodasEdicoes();
                $this->montarOpcoesSelectEstados($lstObjEst);
                break;
            }
            case 'cidade': {//AJAX
                $cidNome = $_GET['cidade'];
                $cidBO = new CidadeBO(null);
                $jsonCid = json_encode($cidBO->buscarCidadePorNome($cidNome));
                echo($jsonCid);
                break;
            }
            default: {
                include_once("../inscricao.php");
            }
        }
    }

    private function montarOpcoesSelectEstados($estList) {
        $optSelect = '';
        $optSelect = '<option value="" disabled selected>Selecione</option>';
        foreach ($estList as $est) {
            $optSelect .= "<option value=\":sigla\">:rotulo</option><br>";
            $optSelect = str_replace(":sigla", $est['est_id'], $optSelect);
            $optSelect = str_replace(":rotulo", $est['est_nome'], $optSelect);
        }
        echo($optSelect);
    }

}

$cadastroControle = new cadastro();
