 <?php

	if(!isset($_SESSION)){
		session_start();
	}
	
	require '../models/perfil_model.php';

	if(!isset($acao)){
		$acao = 'enviar_foto';
	}

	if(isset($_POST['item'])){

		$item = $_POST['item'];

		if($item == 'nome' and (strlen($_POST['valor']) < 3 or strlen($_POST['valor']) > 15)){
			echo json_encode($_SESSION['nome']);
			die();
		}

		if($item == 'aniversario' and empty($_POST['valor'])){
			echo json_encode($_SESSION['nascimento']);
			die();
		}

		if($item == 'mora'){
			$item = 'cidade';
		}

		if($item == 'aniversario'){
			$item = 'nascimento';
		}

		if($_POST['valor'] == ''){
			$_POST['valor'] = null;
		}

		$perfil = new Perfil();
		$perfil->id_usuario = $_SESSION['id'];
		$perfil->$item = $_POST['valor'];

		
		if($item == 'nascimento' or $item == 'nome'){
			$perfil->salvarDados($item);

			if($item == 'nascimento'){
				$_SESSION['nascimento'] = $_POST['valor'];
			} else {
				$_SESSION['nome'] = $_POST['valor'];
			}	

		} else {
			$perfil->salvar($item);
		}

		echo json_encode($_POST['valor']);
		die();
	}

	if($acao == 'recuperar_dados'){
		$perfil = new Perfil();
		$perfil->id_usuario = $_SESSION['id'];
		$registros = $perfil->recuperarDados();

	}

	if($acao == 'recuperar_dados_privados'){
		$perfil = new Perfil();
		$perfil->id_usuario = $id_perfil;
		$registros = $perfil->recuperarDados();
	}

	if($acao == 'enviar_foto'){

 		$arquivo_tmp = $_FILES['foto']['tmp_name'];
 		$nome = $_FILES[ 'foto' ][ 'name' ];
 		$extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
 		$extensao = strtolower ( $extensao );
 		if ( strstr ( '.jpg;.jpeg;.png', $extensao ) ) {
 			$novoNome = uniqid ( time () ) . '.' . $extensao;
 			$destino = '../imagens/' . $novoNome;
 			move_uploaded_file( $arquivo_tmp, $destino);	
 			$perfil = new Perfil();
			$perfil->id_usuario = $_SESSION['id'];
			$imagem_anterior = $perfil->recuperarImagem()[0];
			unlink("../imagens/$imagem_anterior");
			$perfil->imagem = $novoNome;
			$perfil->salvarImagem();
						
		} 
	}

?>
