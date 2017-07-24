<!-- CONTEÚDO -->
<section class="container" id="conteudo">
	<?php echo('ERROS: ' . @$erros ?? ''); ?>
	<div class="row">
		<div class="col-md-12">
			<div class="jumbotron">
				<h1>INSCRIÇÃO</h1>
				<p>Preencha o formulário para realizar sua inscrição.</p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<input type="hidden" id="dados" name="dados" value="<?php echo($dados ?? ''); ?>" />
			<form method="POST" action="../ctrl/cadastro.php" id="cadCliente">
				<fieldset>
					<input type="hidden" name="par_id" id="par_id">

					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<label for="par_nome">* Nome </label>	
							</div>
							<div class="col-md-4">
								<label for="par_rg">RG</label>	
							</div>
							<div class="col-md-4">
								<label for="par_cpf">CPF</label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<input type="text" name="par_nome" id="par_nome" maxlength="100" required placeholder="Fulano da Silva">
							</div>
							<div class="col-md-4">
								<input type="text" name="par_rg" id="par_rg" maxlength="15" placeholder="__.___.___-__">
							</div>
							<div class="col-md-4">
								<input type="text" name="par_cpf" id="par_cpf" maxlength="15" placeholder="___.___.___-__">
							</div>
						</div>						
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="par_email">* E-Mail </label>
							</div>
							<div class="col-md-6">
								<label for="par_instituicao">* Instituição de origem </label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<input type="email" name="par_email" id="par_email"  maxlength="30" required placeholder="fulano@mail.com">	
							</div>
							<div class="col-md-6">
								<input type="text" name="par_instituicao" id="par_instituicao"  maxlength="30" required  placeholder="UTFPR, por exemplo">
							</div>
						</div>												
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-2">
								<label for="log_cep">* CEP</label>	
							</div>
							<div class="col-md-1">
								<label for="cid_cep_unico">CEP único? </label>
							</div>
							<div class="col-md-8">
								<label for="log_tipo">*Logradouro</label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<input type="text" name="log_cep" id="log_cep" maxlength="9" required placeholder="_____-___">
							</div>
							<div class="col-md-1">
								<input type="checkbox" name="cid_cep_unico" id="cid_cep_unico" readonly>
							</div>

							<div class="col-md-3">
								<input type="hidden" name="log_id" id="log_id">
								<select name="log_tipo" id="log_tipo" required readonly>
									<option value="" disabled selected>Tipo do logradouro</option>
									<option value="Alameda">Alameda</option>
									<option value="Avenida">Avenida</option>
									<option value="Praça">Praça</option>
									<option value="Rua">Rua</option>
									<option value="Travessa">Travessa</option>
								</select>
							</div>

							<div class="col-md-6">
								<input type="text" name="log_nome" id="log_nome"  maxlength="100" required readonly placeholder="Marechal Floriano Peixoto">
							</div>
						</div>
					</div>

					<div class="form-group">

						<div class="row">
							<div class="col-md-4">
								<label for="end_numero">Número</label>
							</div>
							<div class="col-md-4">
								<label for="end_complemento">Complemento</label>
							</div>
							<div class="col-md-4">
								<label for="log_bairro">*Bairro</label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<input type="hidden" name="end_id" id="end_id">
								<input type="text" name="end_numero" id="end_numero"  maxlength="5" placeholder="234A">
							</div>
							<div class="col-md-4">
								<input type="text" name="end_complemento" id="end_complemento" maxlength="50" placeholder="Casa dos fundos">
							</div>
							<div class="col-md-4">
								<input type="text" name="log_bairro" id="log_bairro"  maxlength="30" required readonly placeholder="Centro">
							</div>
						</div>
						
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="cid_nome">* Cidade</label>
							</div>
							<div class="col-md-6">
								<label for="est_id">* Estado</label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<input type="hidden" name="cid_id" id="cid_id">
								<input type="text" name="cid_nome" id="cid_nome" maxlength="30" required readonly placeholder="Curitiba">
							</div>
							<div class="col-md-6">
								<select name="est_id" id="est_id" required readonly></select>
							</div>
						</div>						
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="usu_nome">* Usuário </label>
							</div>
							<div class="col-md-6">
								<label for="usu_senha">* Senha </label> 
							</div>
						</div>		

						<div class="row">
							<div class="col-md-6">
								<input type="text" name="usu_nome" id="usu_nome" maxlength="30" required placeholder="meu_usuario">
							</div>
							<div class="col-md-6">
								<input type="password" name="usu_senha" id="usu_senha" required placeholder="*******">
							</div>
						</div>
					</div>

					<fieldset class="inscricao-botoes">
						
							<input type="hidden" id="processo" name="processo" value="novo" />
							<div class="col-md-6"><button type="submit" class="inscricao-cadastrar">Cadastrar</button></div>
							<div class="col-md-6"><button type="reset" class="inscricao-apagar">Apagar</button></div>
						
					</fieldset>
				</fieldset>
			</form>
		</div>
	</div>
</section>
