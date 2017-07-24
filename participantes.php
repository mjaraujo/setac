<?php
require_once('view/include/inc_adm_header.php');
require_once('view/include/inc_menu_adm.php');

echo('ERROS: ' . @$erros ?? '');
?>
<section>
    <form method="POST" action="administracao.php">
        <input type="hidden" id="processo" name="processo" value="procurarpor">
        <label for="procParticipante">Procurar por </label>
        <input type="text" id="procParticipante" name="procParticipante">
    </form>
</section>

<table class="tabela" id="tabParticipantes">
    <thead>
        <tr>
            <th>Nome</th>
            <th>E-Mail</th>
            <th>Instituição</th>
            <th>Cidade</th>
            <th>Cadastrado</th>
            <th>Situação</th>
            <th>Ações</th>
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

<?php require_once('view/include/inc_adm_footer.php'); ?>
