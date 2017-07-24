<?php
require_once('view/include/inc_adm_header.php');
require_once('view/include/inc_menu_adm.php');

echo('ERROS: ' . @$erros ?? '');
?>

<section>
    <form action="../ctrl/recursoCRT.php"   method="post" id="cadRecurso">
        <label for="rec_patrimonio">Número Patrimônio </label>
        <input type="text" id="rec_patrimonio" name="rec_patrimonio">

        <label for="rec_nome">Nome </label>
        <input type="text" id="rec_nome" name="rec_nome" required>

        <label for="rec_descricao">Descrição </label>
        <textarea id="rec_descricao" name="rec_descricao" cols="100" rows="10" required></textarea>

        <input type="hidden" name="processo" value="cadastrar">
        <button type="submit">Cadastrar</button>
    </form>
</section>

<section>
    <table class="tabela" id="tabRecursos">
        <thead>
            <tr>
                <th> Patrimônio </th>
                <th> Nome </th>
                <th> Descrição </th>
                <th> Cadastrado </th>
                <th> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php //echo($linhasTabela); ?>
        </tbody>
    </table>
    
    <section>
        <select id="selNrRegistrosPorPagina" name="nrRegistros">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
        </select>
        <section id="paginacao"></section>
    </section>
</section>

<?php require_once('view/include/inc_adm_footer.php'); ?>
