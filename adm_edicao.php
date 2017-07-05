<?php 
$title = "Edição de usuário";

require_once('view/include/inc_adm_header.php');

require_once('view/include/inc_menu_adm.php');

echo('ERROS: ' . @$erros ?? ''); ?>

<input type="hidden" id="dados" name="dados" value="<?php echo($dados ?? ''); ?>" />

<form method="POST" action="./edicao.php" id="cadEdicao">
    <input type="hidden" name="edi_id" id="par_id">

    <label for="edi_tema">Nome </label>
    <input type="text" name="edi_tema" value="Robótica" id="par_nome" maxlength="100" required placeholder="Tema da edição">

    <label for="edi_descricao">RG</label>
    <input type="text" name="edi_descricao" value="Descrição" id="edi_descricao" maxlength="15" required placeholder="Descrição sobre a edição">
    
    <label for="edi_inicio">Início</label>
    <input type="date" name="edi_inicio" value="2010-10-10" id="par_cpf" maxlength="15" required>
    
    <label for="edi_fim">Fim</label>
    <input type="date" name="edi_fim" value="2010-11-10"  id="par_cpf" maxlength="15" required>
    
    <input type="hidden" id="processo"  value="novo" />
    <button type="submit">Cadastrar</button>
</form>
<li><a href="ctrl/edicao.php?processo=liedi">Edições</a></li>
<?php
require_once('view/include/inc_adm_footer.php');

?>
