<?php
	
	require "../models/feed_model.php";
	
	if(!isset($_SESSION)){
		session_start();
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
 			$postagem = new Postagem();
			$postagem->id_usuario = $_SESSION['id'];
			$postagem->imagem = $novoNome;
			$postagem->salvar();
			echo $novoNome;		
		} else {
			echo "error";
		}

		die();
	}

	if(isset($_POST['acao']) and $_POST['acao'] == 'atualizar'){
		$postagem = new Postagem();
		$postagem->id_usuario = $_SESSION['id'];
		$postagem->id = $postagem->ultimaPostagem()[0];
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/y H:i');
		$postagem->data = $data;

		if(isset($_POST['texto'])){
			$postagem->descricao = $_POST['texto'];
			$postagem->ativarComDescricao();
		} else {
			$postagem->ativar();
		}	
	}

	if(isset($_POST['acao']) and $_POST['acao'] == 'salvar_publicacao'){
		$postagem = new Postagem();
		$postagem->id_usuario = $_SESSION['id'];
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/y H:i');
		$postagem->data = $data;
		$postagem->descricao = $_POST['descricao'];
		$postagem->status = 1;
		$postagem->salvar_publicacao();
	}

	if($acao == 'recuperar_postagens' or isset($acao1)){
		$postagem = new Postagem();
		$postagem->id_usuario = $_SESSION['id'];
		$todas_postagens = $postagem->recuperar_postagens();
		$seguindos = $postagem->calcularSeguindo();	
		$postagens = array();
		$usuarios = array();
		$imagens = array();
		$id_pessoa = isset($acao1) ? $id_perfil : $_SESSION['id'];

		foreach ($todas_postagens as $postagem1) {
			if($postagem1['id_usuario'] == $id_pessoa){
				array_push($postagens, $postagem1);
				array_push($usuarios, $postagem->buscarUsuario($postagem1['id_usuario']));
				array_push($imagens, $postagem->buscarImagem($postagem1['id_usuario']));
			} 
			if(isset($acao1)){
				continue;
			} else {
				foreach ($seguindos as $seguindo) {
					if($postagem1['id_usuario'] == $seguindo[0]){
						array_push($postagens, $postagem1);
						array_push($usuarios, $postagem->buscarUsuario($postagem1['id_usuario']));
						array_push($imagens, $postagem->buscarImagem($postagem1['id_usuario']));
						break;
					}
				}
			}	
		}
	}

	if(isset($_POST['acao']) and $_POST['acao'] == "apagar_inativos"){
		$postagem = new Postagem();
		$postagem->id_usuario = $_SESSION['id'];
		$registros = $postagem->ultimaPostagem();
		if($registros[2] == 0){
			$postagem->apagarPostagem($registros[0]);
			unlink("../imagens/$registros[1]");
		} 

	}