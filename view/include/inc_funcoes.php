<?php
	function obterURL(){
        return($_SERVER["PHP_SELF"]);
	}

	function paginacaoTitulo(){
		if(obterURL() == "/setac/index.php"){
			return "Pagina Inicial";
		}
		if(obterURL() == "/setac/agenda.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Programacao / Agenda";
		}
		if(obterURL() == "/setac/palestras.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Programacao / Palestras";
		}
		if(obterURL() == "/setac/minicursos.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Programacao / Minicursos";
		}
		if(obterURL() == "/setac/apresentacao-de-trabalhos.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Programacao / Apresentação de Trabalhos";
		}
		if(obterURL() == "/setac/ctrl/cadastro.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Inscrição";
		}
		if(obterURL() == "/setac/submissao-de-trabalhos.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Contribuição / Submissão de Trabalhos";
		}
		if(obterURL() == "/setac/contato.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Contato";
		}
		if(obterURL() == "/setac/inc_login.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Login";
		}
	}

?>