<?php
require_once('view/include/inc_adm_header.php');
require_once('view/include/inc_menu_adm.php');
?>

<table>
    <thead>
        <tr>
            <th>Tema</th>
            <th>Descrição</th>
            <th>Início</th>
            <th>Fim</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php echo($linhasTabela); ?>
    </tbody>
</table>

<?php require_once('view/include/inc_adm_footer.php'); ?>