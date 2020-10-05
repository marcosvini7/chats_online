<?php

	require 'conexao.php';

	class Perfil extends Conexao{
		private $id_usuario;
		private $imagem;
		private $sobre;
		private $cidade;
		private $trabalho;
		private $faculdade;
		private $hobbies;
		private $conexao;

		function __construct(){
			$this->conexao = $this->conectar();
		}

		public function __get($attr){
			return $this->$attr;
		}

		public function __set($attr, $value){
			$this->$attr = $value;
		}

		public function salvar($item){
			$query = "update perfis set $item = :$item where id_usuario = :id_usuario";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(":id_usuario", $this->id_usuario);
			$stmt->bindValue(":$item", $this->$item);
			return $stmt->execute();
		}

		public function salvarDados($item){
			$query = "update usuarios set $item = :$item where id = :id_usuario";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(":id_usuario", $this->id_usuario);
			$stmt->bindValue(":$item", $this->$item);
			return $stmt->execute();
		}

		public function recuperarDados(){
			$query = "select * from perfis where id_usuario = :id_usuario";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(":id_usuario", $this->id_usuario);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function salvarImagem(){
			$query = "update perfis set imagem = :imagem where id_usuario = :id_usuario";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(":id_usuario", $this->id_usuario);
			$stmt->bindValue(":imagem", $this->imagem);
			return $stmt->execute();
		}
		public function recuperarImagem(){
			$query = 'select imagem from perfis where id_usuario = :id_usuario';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(":id_usuario", $this->id_usuario);
			$stmt->execute();
			return $stmt->fetch();
		}
	}




?>