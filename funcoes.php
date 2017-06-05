<?php
	function obterURL(){
	return($_SERVER["PHP_SELF"]);
	}

	function paginacaoTitulo(){
		if(obterURL() == "/setac/index.php"){
			return "Pagina Inicial";
		}
		if(obterURL() == "/setac/programacao.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Programacao";
		}
		if(obterURL() == "/setac/chamada-de-trabalhos.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Chamada de Trabalhos";
		}
		if(obterURL() == "/setac/submissao-de-trabalhos.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Submissão de Trabalhos";
		}
		if(obterURL() == "/setac/contato.php"){
			return "<a href='index.php'>Pagina Inicial</a> / Contato";
		}
	}

?>