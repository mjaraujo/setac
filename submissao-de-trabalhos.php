
<?php 
$title = "Submissao de Trabalhos - SeTAC²";
require_once('view/include/inc_header.php');
?>

	<!-- CONTEÚDO DO SITE -->
	<section class="container" id="conteudo">
		<div class="row">
			<div class="col-md-12">
				<div class="jumbotron">
					<h1>Submissão de Trabalhos</h1>
					<p>Envie aqui seu artigo científico para avaliação da comissão técnica.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				Atenção: para informações detalhadas a respeito das regras para submissão de trabalhos, leia a <strong><a href="http://localhost/setac/#chamada-de-trabalhos">Chamada de Trabalhos</a></strong>.

				<br><br><br>

				<form id="formularios-setac" action="envia-trabalho.php" method="POST">
					<fieldset>
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
							<label for="assunto">Tema do Trabalho:</label>
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-pushpin"></span></span>
								<input type="text" class="form-control" id="assunto" name="assunto" required>
							</div>
						</div>

						<div class="form-group">
							<label for="docArtigo">Selecione o arquivo .doc com o artigo</label>
							<input type="file" class="form-control" id="docArtigo" name="docArtigo" required>
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

			</div>
		</div>
	</section>

<?php require_once('view/include/inc_footer.php');?>