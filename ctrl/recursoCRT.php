<?php

require_once '../dto/RecursosDTO.php';
require_once '../bo/RecursosBO.php';

class recursoCRT {
    
    public function __construct() {
        $opcao = isset($_POST['processo']) && !empty($_POST['processo']) ? $_POST['processo'] : '';
        $opcao = empty($opcao) && isset($_GET['processo']) && !empty($_GET['processo']) ? $_GET['processo'] : $opcao;

        //Esta variável pode ser usada nas view para dar feedback ao usuário
        //0 - Deu erro, desconhecido no PHP, 1 - Executou todas as instruções sem erro
        //Caso contrário, já vem preenchida com textos de erros especificos de cada método/solicitação
        $erros = (isset($_GET['erros']) && !empty($_GET['erros']) ? $_GET['erros'] : -1);
        $erros = ($erros==1 ? "Operação realizada." : (empty($erros) ? "Operação não pôde ser realizada." : $erros));
        $erros = ($erros==-1 ? "" : $erros);

        switch ($opcao){
            case 'listar':{
                $recBO = new RecursosBO(NULL);
                $pagina = (isset($_GET['pagina']) && !empty($_GET['pagina']) ? $_GET['pagina'] : 1)-1;
                $quantidade = (isset($_GET['quantidade']) && !empty($_GET['quantidade']) ? $_GET['quantidade'] : 10);
                $listObjRec = $recBO->listarRecursos($pagina*$quantidade, $quantidade);
                echo(str_replace("\"", "aspas", json_encode($listObjRec)));//para AJAX da tabela
                break;
            }
            case 'cadastrar':{
                $recurso = new RecursosBO($_POST);
                $salvou = $recurso->salvarRecurso();
                $title = "Administração: Recursos";
                header("Location: administracao.php?processo=rec&erros=".$salvou);
                break;  
            }
            case 'excluir':{
                $recurso = new RecursosBO($_GET);
                $recurso->excluirRecurso();
                header("Location: administracao.php?processo=rec");
                break;
            }
            case 'editar':{
                $recurso = new RecursosBO($_GET);
                $rec = $recurso->buscarRecursoPorId($_GET['id']);
                var_dump($rec);
                break;
            }
        }
    }
}

$var = new recursoCRT();