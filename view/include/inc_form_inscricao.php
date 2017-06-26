<?php echo('ERROS: ' . @$erros ?? ''); ?>

<input type="hidden" id="dados" name="dados" value="<?php echo($dados ?? ''); ?>" />

<form method="POST" action="../ctrl/cadastro.php" id="cadCliente">
    <input type="hidden" name="par_id" id="par_id">

    <label for="par_nome">*Nome </label>
    <input type="text" name="par_nome" id="par_nome" maxlength="100" required placeholder="Fulano da Silva">

    <label for="par_rg">RG</label>
    <input type="text" name="par_rg" id="par_rg" maxlength="15" placeholder="__.___.___-__">
    
    <label for="par_cpf">CPF</label>
    <input type="text" name="par_cpf" id="par_cpf" maxlength="15" placeholder="___.___.___-__">
    
    <label for="par_email">*E-Mail </label>
    <input type="email" name="par_email" id="par_email"  maxlength="30" required placeholder="fulano@mail.com">
    
    <label for="par_instituicao">*Instituição de origem </label>
    <input type="text" name="par_instituicao" id="par_instituicao"  maxlength="30" required  placeholder="UTFPR, por exemplo">
    
    <label for="log_cep">*CEP</label>
    <input type="text" name="log_cep" id="log_cep" maxlength="9" required placeholder="_____-___">

    <input type="hidden" name="log_id" id="log_id">

    <label for="log_tipo">*Logradouro</label>
    <select name="log_tipo" id="log_tipo" required readonly>
        <option value="" disabled selected>Tipo do logradouro</option>
        <option value="Alameda">Alameda</option>
        <option value="Avenida">Avenida</option>
        <option value="Praça">Praça</option>
        <option value="Rua">Rua</option>
        <option value="Travessa">Travessa</option>
    </select>
    <input type="text" name="log_nome" id="log_nome"  maxlength="100" required readonly placeholder="Marechal Floriano Peixoto">

    <input type="hidden" name="end_id" id="end_id">

    <label for="end_numero">Número</label>
    <input type="text" name="end_numero" id="end_numero"  maxlength="5" placeholder="234A">

    <label for="end_complemento">Complemento</label>
    <input type="text" name="end_complemento" id="end_complemento" maxlength="50" placeholder="Casa dos fundos">

    <label for="log_bairro">*Bairro</label>
    <input type="text" name="log_bairro" id="log_bairro"  maxlength="30" required readonly placeholder="Centro">

    <input type="hidden" name="cid_id" id="cid_id">

    <label for="cid_nome">*Cidade</label>
    <input type="text" name="cid_nome" id="cid_nome" maxlength="30" required readonly placeholder="Curitiba">

    <label for="est_id">*Estado</label>
    <select name="est_id" id="est_id" required readonly></select>

    <label for="usu_nome">*Usuário </label>
    <input type="text" name="usu_nome" id="usu_nome" maxlength="30" required placeholder="meu_usuario">
    
    <label for="usu_senha">*Senha </label> 
    <input type="password" name="usu_senha" id="usu_senha" required placeholder="*******">

    <input type="hidden" id="processo" name="processo" value="novo" />
    <button type="submit">Cadastrar</button>
</form>