<?php 
	
	session_start();
		
	function chatPrivado(){
		if(isset($_GET['id_destinatario'])){
			return 1;
		} else { 
			return 0;
		}
	}


	if(chatPrivado()){
		if($_GET['id_destinatario'] == $_SESSION['id']){
			$_SESSION['id_destinatario'] = $_GET['id_usuario'];
		} else {
			$_SESSION['id_destinatario'] = $_GET['id_destinatario'];
		}
		$acao = 'recuperar_mensagens_privadas';
		$id_perfil = $_SESSION['id_destinatario'];
		$nome_perfil = $_GET['nome'];
	} else {
		unset($_SESSION['id_destinatario']);
		$acao = 'recuperar_mensagens';
	}

	require '../controllers/mensagem_controller.php';
	
	if(!isset($_SESSION['id'])){
		header('location: ../index.php');
	}	
	
?>

<script type="text/javascript">

		function mostrarData(id){
			$('#'+id).removeClass('d-none')
		}

		function perfil(id, nome, nascimento){
			clearInterval(intervalo) 
			$('#area').load('perfil.php' , `id_perfil=${id}&nome=${nome}&nascimento=${nascimento}`)
		}

       function atualizar(){
			let mensagem = ''
			$.ajax({
				url: '../controllers/mensagem_controller.php',
				type: 'get',
				dataType: 'json',
				data: `mensagem=${mensagem}&acao=enviar_mensagem`,
				success: registros => {
					$('#area_mensagens').html('')
					let chat = '<?= $acao ?>' 
					registros.forEach(registro => {
						let data = registro.data.split(' ')
						if(data[1] == undefined){
							data[1] = ''
						}
						if(chat == 'recuperar_mensagens'){
							
							if (registro.id_usuario == <?= $_SESSION['id'] ?> ){	

								if(registro.imagem != 0){
								$('#area_mensagens').append(`
									<div class="msg" style="background: #EFF8FB; padding: 5px; border-radius: 20px">
									<img src="../imagens/${registro.imagem}" class="img-fluid col-9">

									<span style="float: right; color: #6E6E6E; font-size: 0.8em" onclick="mostrarData(${registro.id})">
										 		<span class="d-none" id=${registro.id}>
										 	${data[0]}</span> ${data[1]}
										 </span>
									</div>
								`)
							} else {

								$('#area_mensagens').append(`
									<div class="msg" style="background: #EFF8FB; padding: 5px; border-radius: 20px">	
														
	        			 				${registro.mensagem}
	        			 				<span style="float: right; color: #6E6E6E; font-size: 0.8em" onclick="mostrarData(${registro.id})">
										 		<span class="d-none" id=${registro.id}>
										 	${data[0]}</span> ${data[1]}
										 </span>
									</div>
							`)}}  else {

								if(registro.imagem != 0){
								$('#area_mensagens').append(`
									<div class="msg" style="background: #E0F8EC; padding: 5px; border-radius: 20px">
									<b>${registro.nome_usuario}: </b><br>
									<img src="../imagens/${registro.imagem}" class="img-fluid col-9">

									<span style="float: right; color: #6E6E6E; font-size: 0.8em" onclick="mostrarData(${registro.id})">
										 		<span class="d-none" id=${registro.id}>
										 	${data[0]}</span> ${data[1]}
										 </span>
									</div>
								`)
							} else {

								$('#area_mensagens').append(`						
									<div class="msg" style="background: #E0F8EC; padding: 5px; border-radius: 20px">
	        			 						<b>${registro.nome_usuario}: </b>
										 ${registro.mensagem}
										 <span style="float: right; color: #6E6E6E; font-size: 0.8em" onclick="mostrarData(${registro.id})">
										 		<span class="d-none" id=${registro.id}>
										 	${data[0]}</span> ${data[1]}
										 </span>
									</div>
								
						`)}}} else {

							if (registro.id_usuario == <?= $_SESSION['id'] ?> ){	

								if(registro.imagem != 0){
								$('#area_mensagens').append(`
									<div class="msg" style="background: #EFF8FB; padding: 5px; border-radius: 20px">
									<img src="../imagens/${registro.imagem}" class="img-fluid col-9">

									<span style="float: right; color: #6E6E6E; font-size: 0.8em" onclick="mostrarData(${registro.id})">
										 		<span class="d-none" id=${registro.id}>
										 	${data[0]}</span> ${data[1]}
										 </span>
									</div>
								`) 
							} else {

								$('#area_mensagens').append(`
									<div class="msg" style="background: #EFF8FB; padding: 5px; border-radius: 20px">
	        			 					${registro.mensagem}
	        			 					<span style="float: right; color: #6E6E6E; font-size: 0.8em" onclick="mostrarData(${registro.id})">
										 		<span class="d-none" id=${registro.id}>
										 	${data[0]}</span> ${data[1]}
										 	</span>
									</div>
							`)}} else {	

								if(registro.imagem != 0){
								$('#area_mensagens').append(`
									<div class="msg" style="background: #E0F8EC; padding: 5px; border-radius: 20px">
									<img src="../imagens/${registro.imagem}" class="img-fluid col-9">

									<span style="float: right; color: #6E6E6E; font-size: 0.8em" onclick="mostrarData(${registro.id})">
										 		<span class="d-none" id=${registro.id}>
										 	${data[0]}</span> ${data[1]}
										 </span>
									</div>
								`) 
							} else {
								$('#area_mensagens').append(`						
									<div class="msg" style="background: #E0F8EC; padding: 5px; border-radius: 20px">
	        			 					${registro.mensagem}
	        			 					<span style="float: right; color: #6E6E6E; font-size: 0.8em" onclick="mostrarData(${registro.id})">
										 	<span class="d-none" id=${registro.id}>
										 	${data[0]}</span> ${data[1]}
										 		 
										 </span>
									</div>
												
							`)}				
						
					}}
					})
				}
			})
		}
	

        clearInterval(intervalo)

		intervalo = setInterval(() => {             
				atualizar()
			}, 3000)
        
        $(() => {

			$('#enviar').click(() => {
				let mensagem = $('input').val()
				if(mensagem != ''){
					$.ajax({
						url: '../controllers/mensagem_controller.php',
						type: 'get',
						data: `mensagem=${mensagem}&acao=enviar_mensagem`,
					})

					atualizar()
					setTimeout(() => {
						$('#area_mensagens').scrollTop($('#area_mensagens')[0].scrollHeight)
					}, 550)
					
					$('input').val('')
										
					}	
				}			
			)

			$('input').keydown(a => {
				if(a.keyCode == 13){
					$('#enviar').trigger('click')
				}
			})
		})

		atualizar()
		rolar = setTimeout(() => {
			$('#area_mensagens').scrollTop($('#area_mensagens')[0].scrollHeight)
		}, 550)

		function selecionar_foto(){
			$('#form_foto').trigger('click')
		}
		

		$('#form_foto').change(() => {
			$('#area_envio').html(`
				<h3 class="mt-2" style="color: #D8D8D8">
					<i class="fas fa-spinner"></i>
				</h3>
			`)

			$('#form_botao').trigger('click')
		})

		$('#form_imagem').submit(e => {
			e.preventDefault()
			var formData = new FormData($("form[name='form_imagem']")[0])
  
		  	$.ajax({
		    	url: "../controllers/mensagem_controller.php",
		    	type: "POST",
		    	data: formData,
		    	success: msg => {
		    		$('#area_envio').html(`
		    			<h3 class="mouse mt-2" onclick="selecionar_foto()">
							<i class="far fa-image text-info"></i>
						</h3>
		    		`)
		    		atualizar()
					setTimeout(() => {
						$('#area_mensagens').scrollTop($('#area_mensagens')[0].scrollHeight)
					}, 550)

				},
		    	cache: false,
		    	contentType: false,
		    	processData: false
			})

		})
	
</script>

<html> 

	<?php if(chatPrivado()) { ?>			
		<h4 onclick="perfil(<?= $id_perfil ?>, '<?= $nome_perfil ?>', '<?=     $nascimento ?>')" 
		class="text-center titulo mouse" style="color: #5858FA" > <?=$_GET['nome']?></h4>				
	<?php } else { ?>
				<h4 class="text-center titulo" style="color: #5858FA" >Chat Global</h4>
	<?php } ?>

	<div class="altura rolar" id="area_mensagens">
		
	</div>

	<div class="mt-auto">
		<div class="d-flex">
			<input class="form-control col-8 col-md-10 m-2" type="text" name="mensagem">
			<button id="enviar" class="btn btn-primary btn-sm m-2">Enviar</button>

			<span id="area_envio">
				<h3 class="mouse mt-2" onclick="selecionar_foto()">
					<i class="far fa-image text-info"></i>
				</h3>
			</span>
		</div>
	</div>

	<form class="d-none" id="form_imagem" name="form_imagem" enctype="multipart/form-data">
		<input id="form_foto" type="file" name="foto">
		<input id="form_botao" type="submit">
	</form>

</html>
	
