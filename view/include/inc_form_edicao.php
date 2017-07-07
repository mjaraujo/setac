<?php echo('ERROS: ' . @$erros ?? ''); ?>

<input type="hidden" id="dados" name="dados" value="<?php echo($dados ?? ''); ?>" />

<form method="POST" action="../ctrl/edicao.php" id="cadEdicao">
    <input type="hidden" name="edi_id" id="par_id">

    <label for="edi_tema">Nome </label>
    <input type="text" name="edi_tema" id="edi_tema" maxlength="100" value =
        <?php echo isset($_POST['editTema'])?$_POST['tema']:"" ;
                ?> required placeholder="Tema da edição">

    <label for="edi_descricao">RG</label>
    <input type="text" name="edi_descricao" id="edi_descricao" maxlength="15" required placeholder="Descrição sobre a edição">
    
    <label for="edi_inicio">Início</label>
    <input type="date" name="edi_inicio" id="edi_inicio" maxlength="15" required>
    
    <label for="edi_fim">Fim</label>
    <input type="date" name="edi_fim" id="edi_fim" maxlength="15" required>
    
    <input type="hidden" id="processo" name="processo" value="novo" />
    <button type="submit">Cadastrar</button>
</form>
