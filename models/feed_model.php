<?php 

	if(!isset($acao1)){
		require 'conexao.php';
	}
	
	class Postagem extends Conexao{
		private $id;
		private $id_usuario;
		private $descricao;
		private $imagem;
		private $status;
		private $data;
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

		public function salvar(){
			$query = "insert into postagens(id_usuario, imagem) values(:id_usuario, :imagem)";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_usuario', $this->id_usuario);
			$stmt->bindValue(':imagem', $this->imagem);
			$stmt->execute();
		}

		public function salvar_publicacao(){
			$query = "insert into postagens(id_usuario, descricao, data, status) values(:id_usuario, :descricao, :data, :status)";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_usuario', $this->id_usuario);
			$stmt->bindValue(':descricao', $this->descricao);
			$stmt->bindValue(':data', $this->data);
			$stmt->bindValue(':status', $this->status);
			$stmt->execute();
		}

		public function ultimaPostagem(){
			$query = "select id,imagem,status from postagens where id_usuario = :id_usuario order by id desc limit 1";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_usuario', $this->id_usuario);
			$stmt->execute();
			return $stmt->fetch();

		}

		public function ativar(){
			$query = 'update postagens set status = :valor, data = :data where id = :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':valor', 1);
			$stmt->bindValue(':id', $this->id);
			$stmt->bindValue(':data', $this->data);
			$stmt->execute();
		}

		public function ativarComDescricao(){
			$query = 'update postagens set status = :valor, descricao = :descricao, data = :data where id = :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':valor', 1);
			$stmt->bindValue(':descricao', $this->descricao);
			$stmt->bindValue(':id', $this->id);
			$stmt->bindValue(':data', $this->data);
			$stmt->execute();
		}

		public function recuperar_postagens(){
			$query = "select * from postagens order by id desc";
			$stmt = $this->conexao->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll();
		}

		public function calcularSeguindo(){
			$query = 'select id_perfil from seguir where id_usuario = :id_perfil';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id_perfil', $_SESSION['id']);
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

		public function buscarImagem($id){
			$query = 'select imagem from perfis where id_usuario = :id';
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			return $stmt->fetch();
		}

		public function apagarPostagem($id){
			$query = "delete from postagens where id = :id";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
		}
	}

?>



