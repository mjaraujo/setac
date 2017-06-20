<?php 
$title = "Login²";
include 'view/include/inc_header.php';
?>

<form method="POST" action="../ctrl/cadastro.php" id="login" name="login">
    <label for="usu_nome">Usuário </label>
    <input type="text" name="usu_nome" id="usu_nome">
    
    <label for="usu_senha">Senha </label>
    <input type="password" name="usu_senha" id="usu_senha">

    <input type="hidden" id="processo" name="processo" value="login" />
    <button type="submit">Entrar</button>
</form>

<?php require_once('view/include/inc_footer.php'); ?>
