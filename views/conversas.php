<?php
	
	$acao = 'recuperar_conversas';
	require '../controllers/mensagem_controller.php';
  	
  	if(!isset($_SESSION['id'])){
		header('location: ../index.php');
	}

	$i = 0;

?>

<script type="text/javascript">

	function selecionado(id_usuario, id_destinatario, nome){
		$('#area').load('bate_papo.php', `id_usuario=${id_usuario}&id_destinatario=${id_destinatario}&nome=${nome}`)	
        		
	}

</script>


<html>

	<ul class="list-group mt-3 mouse altura rolar">
		<?php foreach ($registros as $registro){

			$mensagem = $registro['mensagem'];
			if($registro['imagem'] != 0){
				$mensagem = 'Imagem';
			}
		?>
			
			<li class="list-group-item" style="background: #F9F2FA" onclick="selecionado(<?=$registro['id_usuario']?>, <?=$registro['id_destinatario']?>, '<?=$nomes[$i]?>')">
				<h5 style="color: #5858FA">					
					<?= $nomes[$i] ?>
				</h5>	
				<?php if($registro['id_usuario'] == $_SESSION['id']) { ?>				
					<b>Você: </b><?= $mensagem ?>
				<?php } else { ?>
				 	<?= $mensagem ?>	
				<?php } ?>		 				
				<span style="float: right; color: #6E6E6E; font-size: 0.8em">
					<?=$registro['data']?>
				</span>
			</li>

		<?php $i++; } ?>
	</ul>

</html>