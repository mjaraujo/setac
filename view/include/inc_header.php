<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">

    <!-- Garante renderização apropriada e zoom ao toque para todos os dispositivos -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Os controles deverão setar a variavel $title -->
    <?php include 'inc_funcoes.php';?>

    <title><?php echo $title; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet">
    <link href="http://localhost/setac/css/bootstrap.css" rel="stylesheet">
    <link href="http://localhost/setac/css/estilo.css" rel="stylesheet">
</head>

<body onload="contagemRegressiva()">
    <!-- NAVBAR FIXADO AO TOPO -->
    <nav class="navbar navbar-default navbar-fixed-top" id="nav-fixa">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Alternar navegação</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="logo-setac" class="navbar-brand" href="#">SeTAC²</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Página Inicial</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Programação <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="http://localhost/setac/agenda.php">Agenda</a></li>
                            <li><a href="http://localhost/setac/palestras.php">Palestras</a></li>
                            <li><a href="http://localhost/setac/minicursos.php">Minicursos</a></li>
                            <li><a href="http://localhost/setac/apresentacao-de-trabalhos.php">Apresentação de Trabalhos</a></li>
                        </ul>
                    </li>

                    <!--li><a href="inscricao.php">Inscrição</a></li-->
                    <li><a href="http://localhost/setac/ctrl/cadastro.php">Inscrição</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contribuição <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="http://localhost/setac/#before-call">Chamada de Trabalhos</a></li>
                            <li><a href="http://localhost/setac/submissao-de-trabalhos.php">Submissão de Trabalhos</a></li>
                        </ul>
                    </li>
                    <li><a href="http://localhost/setac/contato.php">Contato</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <header id="topo" class="container-fluid">
        <div class="header-bloco">
            <div class="row">				
                <div id="info-setac" class="col-md-6">
                    <h2 class="header-titulo">SOBRE A SeTAC²</h2>
                    <p class="text-justify">A Semana Tecnológica Acadêmica de Ciência da Computação tem como objetivo disseminar o conhecimento tecnológico e científico entre profissionais, estudantes, pesquisadores e alunos do curso de Ciência da Computação da UTFPR e à comunidade externa, por meio de palestras e minicursos que serão oferecidos em outubro de 2017, na Universidade Tecnológica Federal do Paraná – UTFPR, Câmpus Santa Helena.</p>
                </div>
                <div class="col-md-6">
                    <h2 class="header-titulo">Chamada de Trabalhos</h2><br>
                    <p>A chamada de trabalhos para a IV SeTAC² irá iniciar a partir do dia ?? de ?? de 2017. </p>
                    <br>
                    <p class="col-md-6"><a href="index.php#before-call" class="btn btn-default" role="button">Chamada de Trabalhos</a></p>
                    <p class="col-md-6"><a href="submissao-de-trabalhos.php" class="btn btn-default" role="button">Submissão de Trabalhos</a></p>
                </div>
            </div>
        </div>

        <div class="header-contagem">
            <div class="row">	
                <div class="col-md-12">
                    <h2>CONTAGEM REGRESSIVA PARA IV SeTAC²</h2>
                </div>
            </div>

            <div class="row">	
                <div class="col-md-3 ">
                    <h2 id="cont-dias"></h2>
                    <p>dias</p>
                </div>
                <div class="col-md-3">
                    <h2 id="cont-horas"></h2>
                    <p>horas</p>
                </div>
                <div class="col-md-3">
                    <h2 id="cont-minutos"></h2>
                    <p>minutos</p>
                </div>
                <div class="col-md-3">
                    <h2 id="cont-segundos"></h2>
                    <p>segundos</p>
                </div>
            </div>
        </div>
    </header>

    <section id="paginacao" class="container-fluid">
        <div class="container">
                <p>Você está aqui:	<?php echo paginacaoTitulo(); ?></p>			
        </div>		
    </section>