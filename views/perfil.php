<?php
	session_start();
	
	function mostrar($dado){
		if(!is_null($dado)){
			echo $dado;
		}
	}

	$proprio = 1;

	$id_perfil = $_SESSION['id'];
	$nome = $_SESSION['nome'];
	$nascimento = $_SESSION['nascimento'];

	if(isset($_GET['id_perfil'])){
		$proprio = 0;
		$id_perfil = $_GET['id_perfil']; 
		$nome = $_GET['nome'];
		$nascimento = $_GET['nascimento'];
		$acao = 'recuperar_dados_privados';
	} else {
		$acao = 'recuperar_dados';
	}	

	require '../controllers/perfil_controller.php';

	if(!isset($_SESSION['id'])){
		header('location: ../index.php');
	}
	
	$acao1 = 'recuperar_postagens_proprias';
	require '../controllers/feed_controller.php';
	$tamanho = sizeof($postagens);

	$rolarRapido = isset($_GET['rolar']) ? $_GET['rolar'] : 'nao';

?>


<script type="text/javascript">

	function proprio_perfil(){
		$('#area').load('perfil.php');
	}

	function rolar_baixo(){
		$('html, body').animate({scrollTop:1000}, 'slow')
	}

	function perfil(id, nome, nascimento){
		clearInterval(intervalo) 
		$('#area').load('perfil.php' , `id_perfil=${id}&nome=${nome}&nascimento=${nascimento}`)
	}

	if('<?=$rolarRapido?>' == 'nao'){
		$('html, body').animate({scrollTop:0}, 'slow')
	} else {
		$('html, body').scrollTop(0)
	}
	

	if('<?=$proprio?>' == '0'){
		if('<?=$registros[0]['sobre']?>' == ''){
			$('#sobre2').hide()
		}
		if('<?=$registros[0]['cidade']?>' == ''){
			$('#mora2').hide()
		}
		if('<?=$registros[0]['trabalho']?>' == ''){
			$('#trabalho2').hide()
		}
		if('<?=$registros[0]['faculdade']?>' == ''){
			$('#faculdade2').hide()
		}
		if('<?=$registros[0]['hobbies']?>' == ''){
			$('#hobbies2').hide()
		}


		$('#nome1').hide()		
		$('#sobre1').hide()
		$('#aniversario1').hide()
		$('#mora1').hide()
		$('#trabalho1').hide()
		$('#faculdade1').hide()
		$('#hobbies1').hide()
	}

	function conversa(){

		$('#area').load('bate_papo.php', `id_destinatario=<?=$id_perfil?>&nome=<?=$nome?>`)
	}
	
	function verificar(){
		
		$.ajax({
			url: '../controllers/seguir_controller.php',
			type: 'post',
			data: `id=<?=$id_perfil?>&acao=verificar`,
			dataType: 'json',
			success: dados => {
				if(dados.seguindo == 1){
					$('#segue').removeClass('text-info')
					$('#segue').addClass('text-primary')
				} else {
					$('#segue').removeClass('text-primary')
					$('#segue').addClass('text-info')
				}
			}
		})
	}

	verificar()

	function seguir(){
		$.ajax({
			url: '../controllers/seguir_controller.php',
			type: 'post',
			data: 'id=<?=$id_perfil?>&acao=seguir',
			success: () => {
				verificar()
				calcular()
			}
		})
	}

	function calcular(){

		$.ajax({
			url: '../controllers/seguir_controller.php',
			type: 'post',
			dataType: 'json',
			data: `id=<?=$id_perfil?>&acao=calcular`,
			success: dados => {
				$('#seguidores').text(dados[0])
				$('#seguindo').text(dados[1])
			}
		})
	}

	calcular()

	function verSeguidores(id){
		$('#area').load('pesquisar_usuarios.php', `id=${id}&acao=verseguidores&nome=<?=$nome?>&nascimento=<?=$nascimento?>`)
	}

	function verSeguindo(id){
		$('#area').load('pesquisar_usuarios.php', `id=${id}&acao=verseguindo&nome=<?=$nome?>&nascimento=<?=$nascimento?>`)
	}

	function editar(item){
		let valor = $('#' + item).text().trim()

		$('#nome1').hide()		
		$('#sobre1').hide()
		$('#aniversario1').hide()
		$('#mora1').hide()
		$('#trabalho1').hide()
		$('#faculdade1').hide()
		$('#hobbies1').hide()

		if(item == 'aniversario'){

			$('#' + item).html(`				
				<input id="inp" value="${valor}" onblur="acao('${item}')" class="form-control mt-2 mr-2" type="date">
				</div>
				
			`)

		} else {

			$('#' + item).html(`				
				<input id="inp" value="${valor}"  onblur="acao('${item}')" class="form-control mt-2 mr-2" type="text">
				</div>
				
			`)
		}
					
	}

	function acao(item){
		let valor = $('#inp').val()

		$.ajax({
			url: '../controllers/perfil_controller.php',
			type: 'post',
			dataType: 'json',
			data: `item=${item}&valor=${valor}`,
			success: registro => {
				$('#' + item).html(registro)
				
			},
			error: erro => {
				console.log(erro)
			}
		})
		 
		$('#nome1').show()
		$('#sobre1').show()
		$('#aniversario1').show()
		$('#mora1').show()
		$('#trabalho1').show()
		$('#faculdade1').show()
		$('#hobbies1').show()  
	}

	$('#foto_form').submit(e => {
		e.preventDefault()
		var formData = new FormData($("form[name='foto_form']")[0])
		  
		  $.ajax({
		    url: "../controllers/perfil_controller.php",
		    type: "POST",
		    data: formData,
		    success: function (mensagem) {
		    	$('#area').load('perfil.php')
		    },

		    cache: false,
		    contentType: false,
		    processData: false
		  })

	})

	$(() => {

		if('<?=$proprio?>' == '1') {
			$('#foto_perfil').click(() => {
				$('#enviar_foto').trigger('click')
			})
		}

		
		$('#enviar_foto').change(() => {	
			$('#foto_perfil').attr('src','../imagens/imagem3.gif')
			$('#salvar').trigger('click')
		})

	})

</script>

<html>

	<form id="foto_form" name="foto_form" class="ocultar" method="post" enctype="multipart/form-data">
		<input id="enviar_foto" type="file" name="foto">
		<input id="salvar" type="submit">
	</form>

	<span id="area_imagem">

	<?php if(!is_null($registros[0]['imagem'])){ ?>
		<div class="d-flex justify-content-center mt-3">		
			<img style="height: 200px; width: 200px; border-radius: 50%" src="../imagens/<?=$registros[0]['imagem']?>" id="foto_perfil">
		
	<?php } else { ?>

		<div class="d-flex justify-content-center mt-3">		
			<img style="height: 200px; width: 200px; border-radius: 50%" src="../imagens/imagem2.png" id="foto_perfil">
		
	<?php } ?>

	</span>

	<?php if($proprio == 0){ ?>

		<ul id="opcoes" style="list-style: none" class="align-self-center col-1">
			<li class="mouse" onclick="seguir()">
				<h3>
					<i id="segue" class="fas fa-user-plus text-info"></i>
				</h3>
			</li>

			<li class="mt-5 mouse" onclick="conversa()">
				<h3>
					<i class="fas fa-comments text-info"></i>
				</h3>
			</li>
		</ul>

	<?php } ?>

	</div>

	<div class="text-center">
		<h4 class="text-info">
			<span id="nome">
				<?php 
					if(isset($_GET['id_perfil'])){
						echo $_GET['nome'];
					} else {
						echo $_SESSION['nome'];
					}
				?>
			</span>

			<i id="nome1" class="far fa-edit text-info ml-2" onclick="editar('nome')"></i>
			

		</h4>

		<div class="d-flex justify-content-center">
			<h6 class="card p-1 col-4 col-md-3 mouse" 
				onclick="verSeguidores(<?=$id_perfil?>)">
				Seguidores <span class="text-success" id="seguidores">0</span>
			</h6>

			<h6 class="card p-1 col-4 col-md-3 mouse" 
				onclick="verSeguindo(<?=$id_perfil?>)">
				Seguindo <span class="text-success" id="seguindo">0</span>
			</h6>

			<h6 class="card p-1 col-4 col-md-3 mouse"
				onclick="rolar_baixo()">				
				Publicações <span class="text-success" id="publicacoes "> 
					<?=$tamanho?>
				</span>
			</h6>

		</div>

	</div>

	<div class="mt-5">

		<h5 id="sobre2">
			<i class="fas fa-address-card text-primary"></i>
			<?php if($proprio == 1){ ?> Sobre você: <?php } ?>
			<span id="sobre"> 
				<?php mostrar($registros[0]['sobre']) ?> 
			</span>

			<i id="sobre1" class="far fa-edit text-info ml-2" onclick="editar('sobre')"></i>
		
		</h5>

		<h5 class="mt-4">
			<i class="fas fa-birthday-cake text-warning"></i>
			<?php if($proprio == 1){ ?> Aniversário: <?php } ?> 
			<span id="aniversario">
				<?php 
					if(isset($_GET['id_perfil'])){
						echo $_GET['nascimento'];
					} else {
						echo $_SESSION['nascimento'];
					}
				?>
			</span>

			<i id="aniversario1" class="far fa-edit text-info ml-2" onclick="editar('aniversario')"></i>
			
		</h5>

		<h5 id="mora2" class="mt-4">
			<i class="fas fa-city text-dark"></i> 
			 <?php if($proprio == 1){ ?> Mora em: <?php } ?> 
			 <span id="mora">
			 	<?php mostrar($registros[0]['cidade']) ?>
			 </span>
				 	
			<i id="mora1" class="far fa-edit text-info ml-2" onclick="editar('mora')"></i>
		
			
		</h5>

		<h5 id="trabalho2" class="mt-4">
			<i class="fas fa-briefcase text-secondary"></i> 
			 <?php if($proprio == 1){ ?> Trabalho: <?php } ?> 
			 <span id="trabalho">
			 	<?php mostrar($registros[0]['trabalho']) ?>
			 </span>
	
			<i id="trabalho1" class="far fa-edit text-info ml-2" onclick="editar('trabalho')"></i>
		
			
		</h5>
	
		<h5 id="faculdade2" class="mt-4">
			<i class="fas fa-graduation-cap text-info"></i>
			 <?php if($proprio == 1){ ?> Faculdade/Escola: <?php } ?> 
			 <span id="faculdade">
			 	<?php mostrar($registros[0]['faculdade']) ?>
			 </span>
		 
			<i id="faculdade1" class="far fa-edit text-info ml-2" onclick="editar('faculdade')"></i>
			
			
		</h5>
		
		<h5 id="hobbies2" class="mt-4">
			<i class="fab fa-angellist text-info"></i>
			 <?php if($proprio == 1){ ?> Hobbies: <?php } ?> 
			 <span id="hobbies">
			 	<?php mostrar($registros[0]['hobbies']) ?>
			 </span>
		
			<i id="hobbies1" class="far fa-edit text-info ml-2" onclick="editar('hobbies')"></i>
			
			
		</h5>
		
	</div>

	<div class="mt-5"></div>

	<?php for($i = 0; $i < $tamanho; $i++) { 

		if($postagens[$i]['status'] == 1){

			date_default_timezone_set('America/Sao_Paulo');
			$postagem_data = $postagens[$i]['data'];
			$p1 = explode(' ', $postagem_data);
			$p2 = explode('/', $p1[0]);
			if($p2[0] == date('d')){
				$texto_data = "Hoje às $p1[1]";
			} 
			else if($p2[0] == (date('d') - 1)){
				$texto_data = "Ontem às $p1[1]";
			} else {
				$texto_data = "Em  $p1[0] às $p1[1]";
			}

	?>
		<?php if($usuarios[$i]['id'] != $_SESSION['id']){ ?>
			<div class="d-flex justify-content-start mouse" onclick="perfil(<?=$usuarios[$i]['id'] ?>, '<?= $usuarios[$i]['nome'] ?>', '<?= $usuarios[$i]['nascimento'] ?>')">
		<?php } else { ?>
			<div class="d-flex justify-content-start mouse" onclick="proprio_perfil()">
		<?php } ?>

			<?php  if(!is_null($imagens[$i]['imagem'])){ ?>
				<img src="../imagens/<?=$imagens[$i]['imagem']?>" style="border-radius: 50%; height: 50px; width: 50px">

			<?php } else { ?>
				<img src="../imagens/imagem2.png" style="border-radius: 50%; height: 50px; width: 50px">
			<?php } ?>

			<h5 style="color: #5858FA" class="ml-2 align-self-center">
				<?=$usuarios[$i]['nome']?>		
			</h5>
		</div>

		<p><?=$postagens[$i]['descricao']?></p>
		<div class="d-flex justify-content-center">
			<?php if(!is_null($postagens[$i]['imagem'])){ ?>
				<img class="img-fluid col-11" src="../imagens/<?=$postagens[$i]['imagem']?>">
			<?php } ?>
		</div>
		<p class="text-right"><?=$texto_data?></p>

	<?php } } ?>

</html>