<?php
require_once('view/include/inc_adm_header.php');
require_once('view/include/inc_menu_adm.php');
?>

<body> 
    <div>
    <table>
        <thead>
            <tr>
                <th> Número Patrimônio </th>
                <th> Nome </th>
                <th> Destrição </th>
                <th> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php echo($linhasTabela); ?>
        </tbody>
    </table>

   </div>


    <div>
        <div >
            <h1>Cadastro de novo Recurso</h1>   
            <!-- Formulário de novo cadastro  -->
            <form action="recursoCRT.php"   method="post">
                <input type="hidden" name="processo" value="cadastrar">
                <div >
                    <div>
                        <label>Número Patrimônio: </label>
                        <input type="text" name="rec_num_patrimonio" value="">
                    </div>
                </div> <!-- fim input text Número Patrimônio -->

                <!-- Input Nome recuros -->
                <div>
                    <div>
                        <label>Nome: </label>
                        <input type="text" name="rec_nome" value="">
                    </div>
                </div>
                <div >
                    <div>
                        <label>Descrição:</label>
                        <input type="text" name="rec_descricao" value="">
                    </div>
                </div>
                <br/>
                <div >
                    <div>
                        <button type="submit">Cadastrar</button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<?php require_once('view/include/inc_adm_footer.php'); ?>
