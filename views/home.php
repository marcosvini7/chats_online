 <?php 
  
	session_start();
	
	if(!isset($_SESSION['id'])){
		header('location: ../index.php');
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

		<script type="text/javascript">
         
			function removerCor(){			
				$('#global').removeClass('bg-success text-light')
				$('#pesquisar').removeClass('bg-success text-light')
				$('#conversas').removeClass('bg-success text-light')
				$('#perfil').removeClass('bg-success text-light')	
				$('#feed').removeClass('bg-success text-light')													
			}

            let intervalo = null
            let rolar = null

			$(() => {

				$('#feed').addClass('bg-success text-light')
				$('#area').load('feed.php')

				$('#feed').click(() => {
					removerCor()
					clearInterval(intervalo)
					clearInterval(rolar)
					$('#feed').addClass('bg-success text-light')
					$('#area').load('feed.php')
				})
				            
				$('#global').click(() => {
					removerCor()
					clearInterval(rolar)
					$('#global').addClass('bg-success text-light')
					$('#area').load('bate_papo.php')
				})

				$('#pesquisar').click(() => {
					removerCor()
					clearInterval(rolar)
                    clearInterval(intervalo)
					$('#pesquisar').addClass('bg-success text-light')	
					$('#area').load('pesquisar_usuarios.php')			
				})

				$('#conversas').click(() => {
					removerCor()
					clearInterval(rolar)
                    clearInterval(intervalo)
					$('#conversas').addClass('bg-success text-light')		
					$('#area').load('conversas.php')						
				})

				$('#perfil').click(() => {
					removerCor()
					clearInterval(rolar)
                    clearInterval(intervalo)
					$('#perfil').addClass('bg-success text-light')
					$('#area').load('perfil.php')
				})
				
			})
		</script>
	</head>

	<body class="bg-light">
				
		<nav class="navbar navbar-expand-md navbar-light cor mb-5">
		  <a class="navbar-brand" href="home.php">		  				
			 <h2 class="text-info ml-5"><i class="far fa-comments"></i> Chats Online</h2>	  
		  </a>
		  
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarNav"> 
		    <ul class="navbar-nav ml-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="../controllers/cadastro_controller.php?acao=sair"><h5>Sair</h5></a>
		      </li>
		    </ul>
		
		</nav>

		<div class="container">	
			<div class="row">
				<ul class="list-group col-11 ml-3 ml-md-0 col-md-3" id="navegacao">	

					<li class="list-group-item" id="feed">
						<h5>Feed</h5>
					</li>

					<li class="list-group-item" id="perfil">			
						<h5>Meu Perfil</h5>
					</li>

					<li class="list-group-item" id="global">
						<h5>Chat Global</h5>
					</li>

					<li class="list-group-item" id="conversas">
						<h5>Conversas</h5>
					</li>

					<li class="list-group-item" id="pesquisar">
						<h5>Pesquisar Pessoas</h5>
					</li>

				</ul>
          
				<div id="area" class="col-11 col-md-8 ml-3 ml-md-0 mt-3 mt-md-0 mb-3 mb-4 card">
					
				</div>			
		  </div>
        </div>
	</body>
</html>