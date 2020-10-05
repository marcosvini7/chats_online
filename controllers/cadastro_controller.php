<?php 
	 
	require '../models/usuario_model.php';

	
	$acao = isset($_POST['acao']) ? $_POST['acao'] : $acao;
	session_start();

	if($acao == 'cadastrar'){
		if(strlen($_POST['nome_usuario']) < 3){
			header('location: ../views/cadastro.php?cadastro=5');
			die();
		}

		if(strlen($_POST['nome']) < 3 or strlen($_POST['nome']) > 15 or strlen($_POST['senha']) < 5){
			header('location: ../views/cadastro.php?cadastro=4');
			die();
		} 

		if(empty($_POST['nascimento']) or empty($_POST['email'])){
			header('location: ../views/cadastro.php?cadastro=2');
			die();
		}

		$usuario = new Usuario();
		$usuario->nome = $_POST['nome'];
		$usuario->nome_usuario = $_POST['nome_usuario'];
		$usuario->nascimento = $_POST['nascimento'];
		$usuario->email = $_POST['email'];
		$usuario->senha = sha1($_POST['senha']);
		$registros = $usuario->recuperarTodos();
		foreach ($registros as $registro) {
			if($registro['email'] == $usuario->email){
				header('location: ../views/cadastro.php?cadastro=3');
				die();
			}
		}
		foreach ($registros as $registro) {
			if($registro['nome_usuario'] == $usuario->nome_usuario){
				header('location: ../views/cadastro.php?cadastro=6');
				die();
			}
		}

		if($usuario->cadastrar()){
			$registros = $usuario->recuperarTodos();
			foreach ($registros as $registro) {
				if($registro['email'] == $usuario->email and $registro['senha'] == $usuario->senha){
					$_SESSION['id'] = $registro['id'];
					$_SESSION['nome'] = $registro['nome'];
					$_SESSION['nascimento'] = $registro['nascimento'];
					$usuario->criarPerfil();
					header('location: ../views/home.php?cadastro=1');
					die();				
				}
			}		
		} 
	}

	if($acao == 'login'){
		if(empty($_POST['email']) or empty($_POST['senha'])){
			header('location: ../index.php?login=2');
			die();
		}
		$usuario = new Usuario();
		$usuario->email = $_POST['email'];
		$usuario->senha = sha1($_POST['senha']);
		$registros = $usuario->recuperarTodos();
		foreach ($registros as $registro) {
			if($registro['email'] == $usuario->email and $registro['senha'] == $usuario->senha){
				$_SESSION['id'] = $registro['id'];
				$_SESSION['nome'] = $registro['nome'];
				$_SESSION['nascimento'] = $registro['nascimento'];
				header('location: ../views/home.php?login=1');
				die();
			}
		}
		header('location: ../index.php?login=3');
	}

	if(isset($_GET['acao']) and $_GET['acao'] == 'sair'){
		session_destroy();
		header('location: ../index.php');
	}

	if($acao == 'pesquisar_usuarios'){
		$usuario = new Usuario();
		$registros = $usuario->recuperarTodosOutros();
	}

	if(isset($_POST['acao']) and $_POST['acao'] == 'pesquisar'){

		$usuario = new Usuario();
		$usuarios = $usuario->recuperarTodos();
		$registros = array();
		foreach ($usuarios as $usuario) {
			if(strpos($usuario['nome_usuario'], $_POST['pesquisa']) !== false and $usuario['id'] != $_SESSION['id']){
				array_push($registros, $usuario);
			}
		}
		echo json_encode($registros);

	} 
		
?>