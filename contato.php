
<?php 
$title = "Contato - SeTAC²";
require_once('view/include/inc_header.php');
?>

	<!-- CONTEÚDO DO SITE -->
	<section class="container" id="conteudo">
		<div class="row">
			<div class="col-md-12">
				<div class="jumbotron">
				    <h1>Entre em contato</h1>
				    <p>Ajude a organização da SeTAC² a melhorar cada vez mais o evento enviando sugestões e críticas.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-7">
				<form id="formularios-setac" action="envia-contato.php" method="POST">
					<fieldset>
						<h2 class="legendas-contato">Formulário</h2>

						<hr>

						<div class="form-group">
							<label for="nome">Nome completo</label>
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
								<input type="text" class="form-control" id="nome" name="nome" required>
							</div>
						</div>

						<div class="form-group">
							<label for="email">Email</label>
							<div class="input-group">
								<span class="input-group-addon">@</span>
								<input class="form-control"  type="email" class="form-control" id="email" name="email" required>  
							</div>
						</div>
						
						<div class="form-group">
							<label for="assunto">Assunto</label>
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-pushpin"></span></span>
								<input type="text" class="form-control" id="assunto" name="assunto" required>
							</div>
						</div>

						<div class="form-group">
							<label for="cpf">Mensagem</label>
							<textarea type="text" class="form-control" id="mensagem" name="mensagem" rows="5" required></textarea>
						</div>

					</fieldset>	

					<p>OBS.: Todos os campos são obrigatórios.</p>

					<hr>

					<fieldset class="botoes-comandos">
						<div class="col-md-12">
							<input type="submit" name="enviar" class="btn btn-default">
							<input type="reset" name="limpar" value="Limpar" class="btn btn-default">
						</div>
					</fieldset>
				</form>
			</div>

			<div class="col-md-5">
				<h2 class="legendas-contato">Contato</h2>

				<hr>
				
				<p>
					<span class="glyphicon glyphicon-home" aria-hidden="true"></span> Prolongamento da Rua Cerejeira, s/n CEP 85892-000<br>
					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Bairro São Luiz - Santa Helena - PR - Brasil<br>
					<span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span> Telefone +55 (45) 3268-8802 <br>

					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <strong>Email:</strong> eventocc-sh@utfpr.edu.br
				</p>
				<br>
				<strong>Organização da SeTAC²</strong>
					<section class="contato-recuo">
						<p>
							<strong>Giuvane Conti</strong> - Presidente da Comissão<br>
							<strong>Email:</strong> giuvaneconti@utfpr.edu.br
							<br><br>
							<strong>Fulano Cicrano</strong> - Vice-Presidente da Comissão<br>
							<strong>Email:</strong> giuvaneconti@utfpr.edu.br
						</p>
					</section>
			</div>
		</div>
	</section>

<?php require_once('view/include/inc_footer.php');?>