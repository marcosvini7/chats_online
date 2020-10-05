<?php 

	$acao = 'pesquisar_usuarios';
	$id_perfil = 0;
	
	if(isset($_GET['acao'])){
		$acao = $_GET['acao'];
		$id_perfil = $_GET['id'];
		$nome = $_GET['nome'];
		$nascimento = $_GET['nascimento'];
		require '../controllers/seguir_controller.php';
	} else {
		require '../controllers/cadastro_controller.php';
	}
	 	
  	if(!isset($_SESSION['id'])){
		header('location: ../index.php');
	}
?>



<html>
	
	<script type="text/javascript">

	function selecionado(id_destinatario, nome){
		$('#area').load('bate_papo.php', `id_destinatario=${id_destinatario}&nome=${nome}`)			
	}

	function perfil(id, nome, nascimento){
		$('#area').load('perfil.php' , `id_perfil=${id}&nome=${nome}&nascimento=${nascimento}`)
	}

	$(() => {	 

		$('#enviar').click(() => {

			var pesquisa = $('input').val()
			let url = '../controllers/cadastro_controller.php'
			let data = `acao=pesquisar&pesquisa=${pesquisa}`

			if('<?=$acao?>' != 'pesquisar_usuarios'){
				url = '../controllers/seguir_controller.php'
				data = `acao=pesquisar&pesquisa=${pesquisa}&id=<?=$id_perfil?>&ver=<?=$acao?>`
			}

				$.ajax({
					url: url,
					type: 'post',
					dataType: 'json',
					data: data,
					success: usuarios => {
						$('#local').html('')
						usuarios.forEach(usuario => {
							$('#local').append(`
								<li class="list-group-item" style="background: #F2FAFC;" >
                                    <h6>
                                        <i class="fas fa-user text-info"></i>
                                        ${usuario.nome_usuario}
                
                                        <div style="float: right; font-size: 1.3em" class="mouse">
                                            <i class="fas fa-comments text-primary mr-3" 
                                                onclick="selecionado(${usuario.id},'${usuario.nome}')"></i>
                                                
                                            <i class="fas fa-user-tie text-info" onclick="perfil(${usuario.id}, 
                                                '${usuario.nome}', '${usuario.nascimento}')"></i>
                                        </div>
                                    </h6>
                                </li>
							`)
						})
					}								
				})						
			
			})

		$('input').keydown(a => {
			if(a.keyCode == 13){
				$('#enviar').trigger('click')
			}
		})							
	})

</script>
	
	<div class="mb-auto">
		<div class="row">
			<input class="form-control col-8 col-md-10 m-2" type="text" name="mensagem" placeholder="Digite o nome de usuário">
			<button id="enviar" class="btn btn-primary btn-sm m-2">Pesquisar</button>
		</div>
	</div>
	
	<?php if(isset($acao) and $acao == 'verseguindo'){ ?>
		<?php if($_GET['id'] == $_SESSION['id']){ ?>	
			<h5 class="text-info">Você está seguindo: </h5>

		<?php } else {?>

			<h5 class="text-info">
				<span class="text-primary mouse" onclick="perfil('<?=$id_perfil?>', '<?=$nome?>', '<?=$nascimento?>')"><?=$_GET['nome']?></span> está seguindo: 
			</h5>

	<?php } } ?>

	<?php if(isset($acao) and $acao == 'verseguidores'){ ?>
		<?php if($_GET['id'] == $_SESSION['id']){ ?>
			<h5 class="text-info">Seus seguidores: </h5>
		<?php } else { ?>

			<h5 class="text-info">Seguidores de <span class="text-primary mouse" onclick="perfil('<?=$id_perfil?>', '<?=$nome?>', '<?=$nascimento?>')"><?=$_GET['nome']?></span>: 
			</h5>
	<?php } } ?>

	<ul class="list-group mt-3 altura rolar" id="local">
		<?php foreach ($registros as $registro) { ?>	
			<li class="list-group-item" style="background: #F2FAFC;" >
				<h6>
					<i class="fas fa-user text-info"></i>
					<?= $registro['nome_usuario'] ?>

				<?php if($registro['id'] != $_SESSION['id']){ ?>

					<div style="float: right; font-size: 1.3em" class="mouse">
						<i class="fas fa-comments text-primary mr-3" 
							onclick="selecionado(<?=$registro['id']?>,'<?=$registro['nome']?>')"></i>
							
						<i class="fas fa-user-tie text-info" onclick="perfil(<?=$registro['id']?>, '<?=$registro['nome']?>',    '<?=$registro['nascimento']?>')"></i>
					</div>
				<?php } ?>
				</h6>
			</li>
		<?php } ?>
	</ul>

</html>