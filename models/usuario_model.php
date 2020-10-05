<?php
	require 'conexao.php';

	class Usuario extends Conexao{
		private $nome;
		private $nome_usuario;
		private $nascimento;
		private $email;
		private $senha;
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

		public function cadastrar(){
			$query = 'insert into usuarios(nome, nome_usuario, nascimento, email, senha) values
			(:nome, :nome_usuario, :nascimento, :email, :senha)';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':nome', $this->nome);
			$stmt->bindValue(':nome_usuario', $this->nome_usuario);
			$stmt->bindValue(':nascimento', $this->nascimento);
			$stmt->bindValue(':email', $this->email);
			$stmt->bindValue(':senha', $this->senha);
			return $stmt->execute();
		}

		public function recuperarTodos(){
			$query = 'select * from usuarios';
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC); 
		}

        public function recuperarTodosOutros(){
			$query = 'select * from usuarios where id != :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id', $_SESSION['id']);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC); 
		}

		public function criarPerfil(){
			$query = 'insert into perfis(id_usuario) values (:id_usuario)';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_usuario', $_SESSION['id']);
			$stmt->execute();
		}
	}

?>