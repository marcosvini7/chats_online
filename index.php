<?php

    session_start();

    if(isset($_SESSION['id'])){
        header('location: views/home.php');
    }
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Chats Online</title>
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	</head>

	<body class="bg-light">
		<nav class="navbar navbar-expand-md navbar-light cor mb-5">
		  <a class="navbar-brand" href="index.php">		  				
			 <h2 class="text-info ml-5"><i class="far fa-comments"></i> Chats Online</h2>	  
		  </a>
          <!--
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
          -->
		  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav ml-auto">
		      
		    </ul>
		  </div>
		</nav>

		<div class="container">	
			<div class="row">
				<div class="col-md-6 d-none d-md-block">					
					<ul class="text-secondary">
						<li><h4>Conecte-se com o mundo</h4></li>
						<li><h4>Faça amizades e conheça novas pessoas</h4></li>
						<li><h4>Cadastre-se em 1 minuto e comesse a conversar no outro</h4></li>
					</ul>
					<img src="imagens/imagem1.jpg" class="img-fluid">
				</div>
			
				<div class="col-12 col-md-4 ml-md-auto">
					<div class="card p-4">
						<h4 class="text-center">Login</h4>
						<form action="controllers/cadastro_controller.php" method="post">
							<h5>E-mail: </h5>
							<input class="form-control" type="email" name="email" placeholder="Digite seu e-mail...">
							<h5>Senha: </h5>
							<input class="form-control" type="password" name="senha" placeholder="Digite sua senha..."> <br>
							<input type="hidden" name="acao" value="login">

							<?php if(isset($_GET['login']) and $_GET['login'] == 2) { ?>
								<p class="text-danger">Existem campos obrigatórios que não foram preenchidos</p>
							<?php } ?>

							<?php if(isset($_GET['login']) and $_GET['login'] == 3) { ?>
								<p class="text-danger">E-mail ou senha incorretos</p>
							<?php } ?>

							<input class="form-control btn btn-primary" type="submit" value="Entrar">
						</form>
					
						<h5>Não tem uma conta?</h5>
						<h5><a href="views/cadastro.php">Cadastre-se aqui</a></h5>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>