<?php
    $usuId = $_SESSION['par_id'];
?>
<li class="dropdown">
    <a href="#" class="dropdown-toggle glyphicon glyphicon-user" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo " ".$_SESSION['par_nome']; ?><span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a href="http://localhost/setac/ctrl/cadastro.php?processo=dados&usu=<?php echo($usuId); ?>">Meus dados</a></li>  
       <li role="separator" class="divider"></li> 
       <li><a href="http://localhost/setac/ctrl/login.php">Sair</a></li>
    </ul>
    
</li>