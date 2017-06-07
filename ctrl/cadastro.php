<?php
/*require_once('ParticipanteBO.php');
require_once('UsuarioBO.php');
require_once('CidadeBO.php');
require_once('LogradouroBO.php');
require_once('EnderecoBO.php');*/

class cadastro {
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Construtor responsável por direcionar chamdas das views, sem uma chamada especifica carrega a view inscricao.php.
     * @data: 06/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    function __construct(){
	$retorno = "NAO SETOU";
        /* Executa a opção passada pelo formulário atraves da variavel opcao do tipo hidden */
        $opcao = isset($_POST['processo']) && !empty($_POST['processo']) ? $_POST['processo'] : '';
        switch($opcao){
            case 'novo': {
                //$cliBO = new ClienteBO($_POST);
                //$erros = $cliBO->salvarDadosCadastroCliente($_POST);
                $retorno = "NOVO";
                break;
            }
            case 'Consultar':{

                break;
            }
            case 'altera_consulta':{

                break;
            }
            case 'Alterar':{

                break;
            }
            case 'Deletar':{

                break;
            }
        }
        
        $dados = json_encode($_POST);
        require_once("../view/inscricao.php");
    }
    
}

$cadastroControle = new cadastro();


