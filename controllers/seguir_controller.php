<?php

	require '../models/seguir_model.php';
	
	if(!isset($_SESSION)){
		session_start();
	}

	$acao = isset($_POST['acao']) ? $_POST['acao'] : $acao;

	if($acao == 'seguir'){
		$seguir = new Seguir();
		$seguir->id_usuario = $_SESSION['id'];
		$seguir->id_perfil = $_POST['id'];
		if($seguir->verificar()){
			$seguir->deixarDeSeguir();
		} else {
			$seguir->seguir();
		}
	}

	if($acao == 'verificar'){
		$seguir = new Seguir();
		$seguir->id_usuario = $_SESSION['id'];
		$seguir->id_perfil = $_POST['id'];
		if($seguir->verificar()){
			echo '{"seguindo" : "1"}';
		} else {
			echo '{"seguindo" : "0"}';
		}
	}


	if($acao == 'calcular'){
		$seguir = new Seguir();
		$seguir->id_perfil = $_POST['id'];
		$seguidores = sizeof($seguir->calcularSeguidores());
		$seguindo = sizeof($seguir->calcularSeguindo());
		$array = array();
		array_push($array, $seguidores);
		array_push($array, $seguindo);
		echo json_encode($array);

	}

	if($acao == 'verseguidores'){
		$seguir = new Seguir();
		$seguir->id_perfil = $id_perfil;
		$seguidores = $seguir->calcularSeguidores();
		$registros = array();
		foreach ($seguidores as $seguidor) {
			array_push($registros, $seguir->buscarUsuario($seguidor[0]));
					
		}
		
	}

	if($acao == 'verseguindo'){
		$seguir = new Seguir();
		$seguir->id_perfil = $id_perfil;
		$seguidores = $seguir->calcularSeguindo();
		$registros = array();
		foreach ($seguidores as $seguidor) {
			array_push($registros, $seguir->buscarUsuario($seguidor[0]));
							
		}
		
	}

	if($acao == 'pesquisar'){
		$seguir = new Seguir();
		$seguir->id_perfil = $_POST['id'];

		if($_POST['ver'] == 'verseguidores'){
			$seguidores = $seguir->calcularSeguidores();
		} else {
			$seguidores = $seguir->calcularSeguindo();
		}

		$registros = array();
		foreach ($seguidores as $seguidor) {
			array_push($registros, $seguir->buscarUsuario($seguidor[0]));
							
		}

		$usuarios = array();
		foreach ($registros as $registro) {
			if(strpos($registro['nome_usuario'], $_POST['pesquisa']) !== false and $registro['id'] != $_SESSION['id']) {
				array_push($usuarios, $registro);
			}
		}

		echo json_encode($usuarios);
	}


?>