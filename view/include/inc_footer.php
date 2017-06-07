
	<footer class="footer" id="rodape">
		<div class="container">
			<div class="row">
				<div class="col-md-2">
					<h2 class="titulo-rodape">SeTAC²</h2>
					<ul>
						<li><a href="#">Sobre</a></li>
						<li><a href="#">1ª SeTAC² - 2014</a></li>
						<li><a href="#">2ª SeTAC² - 2015</a></li>
						<li><a href="#">3ª SeTAC² - 2016</a></li>
						<li><a href="#">Anais</a></li>
					</ul>
				</div>
				<div class="col-md-4">
					<h2 class="titulo-rodape">Contato</h2>
					<form id="formularios-setac" action="submeter-contato.php" method="POST">
					<fieldset>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
								<input placeholder="Nome " type="text" class="form-control" id="nome" name="nome" required>
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">@</span>
								<input placeholder="Email" class="form-control"  type="email" class="form-control" id="email" name="email" required>  
							</div>
						</div>

						<div class="form-group">
							<textarea type="text" class="form-control" id="mensagem" name="mensagem" rows="2" required></textarea>
						</div>

					</fieldset>	

					<fieldset class="botoes-comandos">
						<div class="col-md-12">
							<input type="submit" name="enviar" class="btn btn-default">
						</div>
					</fieldset>
				</form>
				</div>
				<div class="col-md-3">
					<h2 class="titulo-rodape">UTFPR</h2>
					<ul>
						<li><a href="#">História</a></li>
						<li><a href="#">Fotos</a></li>
						<li><a href="#">Cursos</a></li>
						<li><a href="#">Ingresso</a></li>
						<li><a href="#">Localização</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h2 class="titulo-rodape">Santa Helena - PR</h2>
				</div>
			</div>
		</div>
	</footer>

	<!-- jQuery (necessario para os plugins Javascript do Bootstrap) -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts-setac.js"></script>

</body>
</html>