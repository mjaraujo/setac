<?php 
$title = "Edição de usuário";

require_once('../view/include/inc_adm_header.php');

require_once('../view/include/inc_menu_adm.php');

echo('ERROS: ' . @$erros ?? ''); ?>

<input type="hidden" id="dados" name="dados" value="<?php echo($dados ?? ''); ?>" />

<form method="POST" action="edicao.php" id="cadEdicao">
    <input type="hidden" name="edi_id" <?php echo isset($_GET['edi_id'])?'value = "'.$_GET['edi_id'] . "\"":"" ?>>

    <label for="edi_tema">Tema </label>
    
    <input <?php echo isset($_GET['edi_tema'])?'value = "'.$_GET['edi_tema'] . "\"":"" ?> type="text" name="edi_tema" id="par_nome" maxlength="100" required placeholder="Tema da edição">

    <label for="edi_descricao">Descrição</label>
    <input <?php echo isset($_GET['edi_descricao'])?'value = "'. $_GET['edi_descricao'] . "\"":"" ?> type="text" name="edi_descricao" id="edi_descricao" maxlength="15" required placeholder="Descrição sobre a edição">
    
    <label for="edi_inicio">Início</label>
    <input <?php echo isset($_GET['edi_inicio'])?'value = "'. substr($_GET['edi_inicio'],0,10) . "\"":"" ?> type="date" name="edi_inicio" id="par_cpf" maxlength="15" required>
    
    <label for="edi_fim">Fim</label>
    <input <?php echo isset($_GET['edi_fim'])?'value = "'. substr($_GET['edi_fim'],0,10) . "\"":"" ?> type="date" name="edi_fim" id="par_cpf" maxlength="15" required>
    
    <input type="hidden" name="processo"  <?php echo isset($_GET['edi_id'])?'value = "editar"' :'value = "novo"' ?> />
    <button type="submit">GRAVAR</button>
</form>

<?php
require_once('../view/include/inc_adm_footer.php');

?>
