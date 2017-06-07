
<?php 
$title = "Inscrição²";
require_once('view/include/inc_header.php');
?>

<!-- CONTEÚDO DO SITE -->
<form method="POST" action="../ctrl/cadastro.php" id="cadCliente">
    <label for="par_nome">Nome </label>
    <input type="text" name="par_nome" id="par_nome" value="<?php  ?>">

    <label for="par_doctipo">Documento</label>
    <select name="par_doctipo" id="cli_doctipo">
        <option value="CPF" value="<?php  ?>">CPF</option>
        <option value="RG" value="<?php  ?>">RG</option>
        <option value="RA" value="<?php  ?>">RA</option>
    </select>
    <input type="text" name="par_docnumero" id="par_docnumero" value="<?php  ?>">
    
    <label for="par_email">E-Mail </label>
    <input type="text" name="par_email" id="par_email" value="<?php  ?>">
    
    <label for="par_instituicao">Instituição de origem </label>
    <input type="text" name="par_instituicao" id="par_instituicao" value="<?php  ?>">
    
    <label for="usu_nome">Usuário </label>
    <input type="text" name="usu_nome" id="usu_nome" value="<?php  ?>">
    
    <label for="usu_senha">Senha </label>
    <input type="password" name="usu_senha" id="usu_senha" value="<?php  ?>">

    <label for="log_cep">CEP</label>
    <input type="text" name="log_cep" id="log_cep" value="<?php  ?>">

    <input type="hidden" name="log_id" id="log_id"  value="<?php  ?>">

    <label for="log_tipo">Logradouro</label>
    <select name="log_tipo" id="log_tipo" readonly>
        <option value="Avenida">Avenida</option>
        <option value="Praça">Praça</option>
        <option value="Rua">Rua</option>
        <option value="Travessa">Travessa</option>
    </select>
    <input type="text" name="log_nome" id="log_nome" readonly>

    <label for="end_numero">Número</label>
    <input type="text" name="end_numero" id="end_numero" value="<?php  ?>">

    <label for="end_complemento">Complemento</label>
    <input type="text" name="end_complemento" id="end_complemento" value="<?php  ?>">

    <label for="log_bairro">Bairro</label>
    <input type="text" name="log_bairro" id="log_bairro" readonly>

    <label for="cid_nome">Cidade</label>
    <input type="text" name="cid_nome" id="cid_nome" readonly>

    <label for="est_id">Estado</label>
    <select name="est_id" id="est_id" readonly>
        <option value="LA">lalal</option>
    </select>

    <input type="hidden" id="processo" name="processo" value="novo" />
    <button type="submit">Gravar Dados</button>
</form>

<pre>
    <?php var_dump($dados); ?>
</pre>

<?php echo $retorno; require_once('view/include/inc_footer.php');?>