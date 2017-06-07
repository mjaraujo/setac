<?php

class cadastro {
    
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Construtor responsável por direcionar chamdas das views, sem uma chamada especifica carrega a view inscricao.php.
     * @data: 06/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    function __construct(){
		
        /* Executa a opção passada pelo formulário atraves da variavel opcao do tipo hidden */
        $opcao = isset($_POST['opcao']) && !empty($_POST['opcao']) ? $_POST['opcao'] : '';
        switch($opcao){
            case 'Incluir': {

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
        
        header("Location: ../view/inscricao.php");
    }
    
}

$cadastroControle = new cadastro();


