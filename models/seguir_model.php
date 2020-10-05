<?php

	require 'conexao.php';

	class Seguir extends Conexao{
		private $id_usuario;
		private $id_perfil;
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

		public function seguir(){
			$query = 'insert into seguir(id_usuario, id_perfil) values (:id_usuario, :id_perfil)';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_usuario', $this->id_usuario);
			$stmt->bindValue(':id_perfil', $this->id_perfil);
			$stmt->execute();
		}

		public function verificar(){
			$query = 'select * from seguir where id_usuario = :id_usuario and id_perfil = :id_perfil';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_usuario', $this->id_usuario);
			$stmt->bindValue(':id_perfil', $this->id_perfil);
			$stmt->execute();
			return $stmt->fetch();

		}

		public function deixarDeSeguir(){
			$query = 'delete from seguir where id_usuario = :id_usuario and id_perfil = :id_perfil';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_usuario', $this->id_usuario);
			$stmt->bindValue(':id_perfil', $this->id_perfil);
			$stmt->execute();
		}

		public function calcularSeguidores(){
			$query = 'select id_usuario from seguir where id_perfil = :id_perfil';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_perfil', $this->id_perfil);
			$stmt->execute();
			return $stmt->fetchAll();
		}

		public function calcularSeguindo(){
			$query = 'select id_perfil from seguir where id_usuario = :id_perfil';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_perfil', $this->id_perfil);
			$stmt->execute();
			return $stmt->fetchAll();
		}

		public function buscarUsuario($id){
			$query = 'select * from usuarios where id = :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			return $stmt->fetch();
		}
	}


?>