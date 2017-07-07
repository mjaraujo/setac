<?php

require_once('../bo/EdicaoBO.php');

/*
 * @autor: Márcio Araújo.
 * @descrição: Classe controller responsável pelos cadastros.
 * @data: 06/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */

class edicao {
    /*
     * @autor: Márcio Araújo.
     * @descrição: Construtor responsável por direcionar chamdas das views, sem uma chamada especifica carrega a view inscricao.php.
     * @data: 06/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */

    function __construct() {

        //Capturar chamadas GET e POST usando 'processo' como chave
        $opcao = isset($_POST['processo']) && !empty($_POST['processo']) ? $_POST['processo'] : '';
        $opcao = empty($opcao) && isset($_GET['processo']) && !empty($_GET['processo']) ? $_GET['processo'] : $opcao;
        switch ($opcao) {
            case 'novo': {
                    $ediBO = new EdicaoBO($_POST);
                    $estaSalvo = $ediBO->salvarDadosEdicao($_POST);
                    $dados = json_encode($_POST);
                    $dados = str_replace("\"", "aspas", $dados); //Retirando as "s pois este valor ficará dentro de um input hidden, manipulado pelo javascript 
                    if ($estaSalvo) {
                        header("Location: edicao.php?processo=liedi");
                    } else {
                        echo($estaSalvo);
                        include_once("../adm_edicao.php");
                    }
                    break;
                }
            case 'editar': {
                    $ediBO = new EdicaoBO($_POST);
                    $estaSalvo = $ediBO->salvarDadosEdicao($_POST);
                    echo 'sss' . $estaSalvo;
                    $dados = json_encode($_POST);
                    
                    $dados = str_replace("\"", "aspas", $dados); //Retirando as "s pois este valor ficará dentro de um input hidden, manipulado pelo javascript 
                    if ($estaSalvo) {
                        header("Location: edicao.php?processo=liedi");
                    } else {
                        include_once("../adm_edicao.php");
                    }
                    break;
                }
            case 'edicoes': {
                    echo "ertyuiop";

                    $ediBO = new EdicaoBO(null);
                    $lstObjEdi = $ediBO->buscarTodasEdicoes();
                    $this->montarOpcoesSelectEstados($lstObjEst);
                    break;
                }
            case 'liedi': {
                    $ediBO = new EdicaoBO(NULL);
                    $lstObjEdi = $ediBO->listarEdicoes();
                    $linhasTabela = $this->montarLinhasTabelaEdicoes($lstObjEdi);
                    include_once '../edicoes.php';
                    break;
                }
            case 'exedi': {
                    $ediBO = new EdicaoBO(null);
                    $id = $_GET['edi'];
                    $ediBO->excluirEdicaoPorId($id);
                    header("Location: edicao.php?processo=liedi");

                    break;
                }
            case 'ededi': {
                    $id = $_GET['edi'];
                    $ediBO = new EdicaoBO(null);
                    $edicaoObj = $ediBO->buscarDadosEdicaoPorId($id);
                    //var_dump($edicaoObj);
                    $dados = $this->prepararDadosEditarEdicao($edicaoObj);
                    //echo $dados;
                    header('Location: adm_edicao.php?' . $dados);
                    include_once 'index.php';

                    break;
                }

            default: {
                    include_once("../edicoes.php");
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

    private function montarLinhasTabelaEdicoes($lstObjEdi) {
        if ($lstObjEdi == NULL)
            return;

        $linhasTabela = "";
        foreach ($lstObjEdi as $objEdi) {
            $linhasTabela .= "<tr>";
            $linhasTabela .= "<td>:TEMA</td>";
            $linhasTabela .= "<td>:DESCRIÇÂO</td>";
            $linhasTabela .= "<td>:INÍCIO</td>";
            $linhasTabela .= "<td>:FIM</td>";
            $linhasTabela .= "<td>:LKEDITAR | " .
                    ":LKEXCLUIR | " .
                    ":LKEDITAR</td>";
            $linhasTabela .= "</tr>";

            $edicao = (empty($objEdi['edi_tema']) ? 'Sem tema' : $objEdi['edi_tema'] . " (" . $objEdi['edi_tema'] . ")");
            $situacao = (empty($objEdi['usu_status']) ? 'Sem acesso' : $objEdi['usu_status'] . ($objEdi['usu_status'] == 'A' ? "tivo" : "nativo"));
            $lkeditar = "<a href=\"../ctrl/edicao.php?processo=ededi&edi=:EDICAO\">Editar</a>";
            $lkexcluir = "<a href=\"../ctrl/edicao.php?processo=exedi&edi=:EDICAO\">Excluir</a>";
            $lksituacao = "<a href=\"../ctrl/edicao.php?processo=ededi&edi=:EDICAO\">?</a>";

            $linhasTabela = str_replace(":TEMA", $objEdi['edi_tema'], $linhasTabela);
            $linhasTabela = str_replace(":DESCRICAO", $objEdi['edi_descricao'], $linhasTabela);
            $linhasTabela = str_replace(":INÍCIO", date("d/m/Y", strtotime($objEdi['edi_inicio'])), $linhasTabela);
            $linhasTabela = str_replace(":FIM", date("d/m/Y", strtotime($objEdi['edi_fim'])), $linhasTabela);
            $linhasTabela = str_replace(":LKEDITAR", $lkeditar, $linhasTabela);
            $linhasTabela = str_replace(":LKEXCLUIR", $lkexcluir, $linhasTabela);
            $linhasTabela = str_replace(":LKSITUACAO", $lksituacao, $linhasTabela);
            $linhasTabela = str_replace(":EDICAO", $objEdi['edi_id'], $linhasTabela);
        }
        return $linhasTabela;
    }

    private function prepararDadosEditarEdicao($objEdi) {
        $linha = "";
        $data = array();
        foreach ($objEdi as $indice => $valor) {
            $linha = $linha . $indice . '=' . $valor . '&';
        }


        return $linha;
    }

}

$cadastroControle = new edicao();
