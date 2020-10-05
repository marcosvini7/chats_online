<?php

	require '../models/mensagem_model.php';

	if(session_id() == ''){ 
    	session_start();
	}

	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	if($acao == 'enviar_mensagem'){
		$mensagem = new Mensagem();
		$mensagem->mensagem = $_GET['mensagem'];
		$mensagem->id_usuario = $_SESSION['id'];
		$mensagem->nome_usuario = $_SESSION['nome'];
		date_default_timezone_set('America/Sao_Paulo');
		$date = date('d/m/y H:i');
		$mensagem->data = $date;

		if(isset($_SESSION['id_destinatario'])){
			if($mensagem->mensagem == ''){
                $mensagem->id_destinatario = $_SESSION['id_destinatario'];
				$registros = $mensagem->recuperar_mensagens_privadas();
				echo json_encode($registros);
			} else {
				$mensagem->id_destinatario = $_SESSION['id_destinatario'];
				$mensagem->salvar_mensagem_privada();
				$registros = $mensagem->recuperar_mensagens_privadas();
				echo json_encode($registros);
			} 

		} else {
			if($mensagem->mensagem == ''){
				$registros = $mensagem->recuperar();
				echo json_encode($registros);
			} else {
				$mensagem->salvar();
				die();
			}
		}
	} 
	
	if($acao == 'recuperar_mensagens'){
		$mensagem = new Mensagem();
		$registros = $mensagem->recuperar();
	}

	if($acao == 'recuperar_mensagens_privadas'){
		$mensagem = new Mensagem();
		$mensagem->id_usuario = $_SESSION['id'];
		$mensagem->id_destinatario = $_SESSION['id_destinatario'];
		$nascimento = $mensagem->recuperarNascimento();
		$registros = $mensagem->recuperar_mensagens_privadas();
	}

	if($acao == 'recuperar_conversas'){
		$mensagem = new Mensagem();
		$mensagem->id_usuario = $_SESSION['id'];
		$mensagens = $mensagem->recuperar_conversas();
		$registros = array();
		$adicionados = array();
		$nomes = array();
		foreach ($mensagens as $mensagem) {
			$pular = 0;
			$n = $mensagem['id_usuario'] . ' ' . $mensagem['id_destinatario'];
			$n1 = $mensagem['id_destinatario'] . ' ' . $mensagem['id_usuario'];
			foreach ($adicionados as $adicionado) {
				if($adicionado == $n or $adicionado == $n1){
					$pular = 1;
					break;
				}
			}
			if($pular){
				continue;
			}
								
			array_push($adicionados, $n);
			array_push($adicionados, $n1);
			array_push($registros, $mensagem);
		}

		$mensagem = new Mensagem();
		
		$i = 0;
		foreach ($adicionados as $adicionado) {
			$i++;
			if(($i % 2) == 0 ){
				continue;
			}

			$ids = explode(' ', $adicionado);
		
			if($mensagem->buscarNomeUsuario($ids[0]) == $_SESSION['nome']){
				array_push($nomes, $mensagem->buscarNomeUsuario($ids[1]));			
			} else {
				array_push($nomes, $mensagem->buscarNomeUsuario($ids[0]));
			}
			
		}

	}

	if(isset($_FILES['foto'])){
 		$arquivo_tmp = $_FILES['foto']['tmp_name'];
 		$nome = $_FILES[ 'foto' ][ 'name' ];
 		$extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
 		$extensao = strtolower ( $extensao );
 		if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
 			$novoNome = uniqid ( time () ) . '.' . $extensao;
 			$destino = '../imagens/' . $novoNome;
 			move_uploaded_file( $arquivo_tmp, $destino);

 			$mensagem = new Mensagem();
			$mensagem->id_usuario = $_SESSION['id'];
			$mensagem->nome_usuario = $_SESSION['nome'];
			date_default_timezone_set('America/Sao_Paulo');
			$date = date('d/m/y H:i');
			$mensagem->data = $date;
			$mensagem->imagem = $novoNome;
 			if(isset($_SESSION['id_destinatario'])){				
                $mensagem->id_destinatario = $_SESSION['id_destinatario'];
				$mensagem->salvar_imagem_privada();
			} else {
				$mensagem->salvar_imagem();
			}
		}
	}
?>