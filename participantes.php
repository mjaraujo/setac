<?php
require_once('view/include/inc_adm_header.php');
require_once('view/include/inc_menu_adm.php');
?>

<table>
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
        <?php echo($linhasTabela); ?>
    </tbody>
</table>

<?php require_once('view/include/inc_adm_footer.php'); ?>