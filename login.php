<?php
$title = "Login²";
include 'view/include/inc_header.php';
?>

<div id="modalLogin" class="modal fade bs-example-modal-sm" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Logar</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="ctrl/login.php" id="login" name="login">
                    <label for="usu_nome">Usuário </label>
                    <input type="text" name="usu_nome" id="usu_nome">

                    <label for="usu_senha">Senha </label>
                    <input type="password" name="usu_senha" id="usu_senha">

                    <input type="hidden" id="processo" name="processo" value="login" />
                    <button type="submit">Entrar</button>
                    <div class="modal-footer">
                        <input type="reset" name="reset"  class="btn btn-danger btn-sm" value="Limpar">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

<?php require_once('view/include/inc_footer.php'); ?>
