<?php

require_once '../dto/RecursosDTO.php';
require_once '../bo/RecursosBO.php';

class recursoCRT {
    
public function __construct() {
    $opcao = isset($_POST['processo']) && !empty($_POST['processo']) ? $_POST['processo'] : '';
    $opcao = empty($opcao) && isset($_GET['processo']) && !empty($_GET['processo']) ? $_GET['processo'] : $opcao;
    
    switch ($opcao){
        case 'cadastrar':{
            $recurso = new RecursosBO($_POST);
            $recurso->cadastroRecurso();
            header("Location: administracao.php?processo=rec");
            break;  
        }
        case 'excluir':{
            $recurso = new RecursosBO($_GET);
            $recurso->deleteRecurso($_GET['id']);
            header("Location: administracao.php?processo=rec");
            break;
        }
        case 'update':{
            $recurso = new RecursosBO($_GET);
            $rec = $recurso->selectRecurso($_GET['id']);
            var_dump($rec);
            
            
            
        }
    }
}
    
    
    
}

$var = new recursoCRT();