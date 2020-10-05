<?php

	$acao = 'recuperar_postagens';
	require "../controllers/feed_controller.php";		

	$tamanho = sizeof($postagens);

?>


<script type="text/javascript">

	$('html, body').scrollTop(0)

	$.ajax({
		url: "../controllers/feed_controller.php",
		type: "POST",
		data: "acao=apagar_inativos"
	})

	function proprio_perfil(){
		$('#area').load('perfil.php', 'rolar=sim');
	}

	function perfil(id, nome, nascimento){
		clearInterval(intervalo) 
		$('#area').load('perfil.php' , `id_perfil=${id}&nome=${nome}&nascimento=${nascimento}&rolar=sim`)
	}

	$('#publicar').click(() => {
		let texto = $('#texto').val()

		$.ajax({
		    url: "../controllers/feed_controller.php",
		    type: "POST",
		    data: "acao=salvar_publicacao&descricao="+texto,
		    success: () => {
		    	$('#area').load('feed.php')
		    }
		})
	})

	$('#postagem').submit((e) => {
		  e.preventDefault()
		  
		  var formData = new FormData($("form[name='postagem']")[0])
		  
		  $.ajax({
		    url: "../controllers/feed_controller.php",
		    type: "POST",
		    data: formData,
		    success: function (imagem) {
		    	imagem = imagem.trim()
		    	if(imagem == 'error'){
		    		$('#area').load('feed.php')
		    	} else {
		    		$('#botoes').removeClass('d-none')
		        	$('#areaimagem').html(`<img class="img-fluid col-12" src="../imagens/${imagem}" >`)
		    	}	    	
		    },

		    cache: false,
		    contentType: false,
		    processData: false
		  })
		  
	})

	$('textarea').keyup(() => {
		$('#publicar').removeClass('d-none')
	})

	$('textarea').focusout(() => {
		if($('textarea').val() == ''){
			$('#publicar').addClass('d-none')
		}
	})

	$('#foto').click(() => {
		$('#imagem').trigger("click")
		$('#texto').attr("placeholder", "Adicione uma descrição para sua imagem(opcional)")
	})

	$('#imagem').change(() => {
		$('#areaimagem').addClass('justify-content-center')
		$('#areaimagem').html('<img src="../imagens/imagem3.gif">')
		$('#enviarimagem').trigger("click")	
	})

	$('#cancelar').click(() => {
		$('#area').load('feed.php')
	})

	$('#confirmar').click(() => {
		let texto = $('#texto').val()
		let data

		if($('#texto').val() == ''){
			data = 'acao=atualizar'	
		} else {	
			data = `acao=atualizar&texto=${texto}`
		}
		
		$.ajax({
			url: '../controllers/feed_controller.php',
			type: "POST",
			data: data,
			success: () => {
				$('#area').load('feed.php')
			}
		})
	})


</script>

<html>

	<textarea id="texto" class="form-control mt-2" type="text" placeholder="O que você quer compartilhar?"></textarea>

	<div class="d-flex mt-2" id="areaimagem">	
		<h1>
			<i id="foto" class="far fa-image text-info"></i>
		</h1>
		<button id="publicar" class="btn btn-info col-3 ml-auto d-none">Publicar</button>	
	</div>

	<form id="postagem" name="postagem" class="d-none" enctype="multipart/form-data">
		<input type="file" id="imagem" name="foto">
		<input type="submit" id="enviarimagem">
	</form>

	<div id="botoes" class="mt-3 d-none">
		<div class="d-flex justify-content-center">
			<button id="confirmar" class="btn btn-success col-3 mr-2">Publicar</button>
			<button id="cancelar" class="btn btn-danger col-3">Cancelar</button>
		</div>
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