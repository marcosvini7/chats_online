<?php
	
	require 'conexao.php';

	class Mensagem extends Conexao{
		private $mensagem;
		private $data;
		private $id_usuario;
		private $nome_usuario;
		private $id_destinatario;
		private $imagem;
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
		$query = 'insert into mensagens(mensagem, id_usuario, nome_usuario, data) values
		(:mensagem, :id_usuario, :nome_usuario, :data)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':mensagem', $this->mensagem);
		$stmt->bindValue(':id_usuario', $this->id_usuario);
		$stmt->bindValue(':nome_usuario', $this->nome_usuario);
		$stmt->bindValue(':data', $this->data);
		return $stmt->execute();
	}

	public function recuperar(){
		$query = 'select * from mensagens where id_destinatario = 0';
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function recuperar_mensagens_privadas(){
		$query = 'select * from mensagens where (id_usuario = :id_usuario and id_destinatario = :id_destinatario) or (id_usuario = :id_destinatario and id_destinatario = :id_usuario)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_usuario', $this->id_usuario);
		$stmt->bindValue(':id_destinatario', $this->id_destinatario);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function salvar_mensagem_privada(){
		$query = 'insert into mensagens(mensagem, id_usuario, nome_usuario, id_destinatario, data) values
		(:mensagem, :id_usuario, :nome_usuario, :id_destinatario, :data)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':mensagem', $this->mensagem);
		$stmt->bindValue(':id_usuario', $this->id_usuario);
		$stmt->bindValue(':nome_usuario', $this->nome_usuario);
		$stmt->bindValue(':id_destinatario', $this->id_destinatario);
		$stmt->bindValue(':data', $this->data);
		return $stmt->execute();
	}

	public function recuperar_conversas(){
		$query = 'select * from mensagens where (id_usuario = :id_usuario or id_destinatario = :id_usuario) and id_destinatario != 0 order by id desc';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_usuario', $this->id_usuario);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

	public function buscarNomeUsuario($id){
		$query = 'select nome from usuarios where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetch()['nome'];
		
	}

	public function recuperarNascimento(){
		$query = 'select nascimento from usuarios where id = :id_destinatario';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_destinatario', $this->id_destinatario);
		$stmt->execute();
		return $stmt->fetch()['nascimento'];
	}

	public function salvar_imagem_privada(){
		$query = 'insert into mensagens(id_usuario,nome_usuario, id_destinatario, data, imagem) values(:id_usuario, :nome_usuario, :id_destinatario, :data, :imagem)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_usuario', $this->id_usuario);
		$stmt->bindValue(':nome_usuario', $this->nome_usuario);
		$stmt->bindValue(':id_destinatario', $this->id_destinatario);
		$stmt->bindValue(':data', $this->data);
		$stmt->bindValue(':imagem', $this->imagem);
		$stmt->execute();
	}

	public function salvar_imagem(){
		$query = 'insert into mensagens(id_usuario, nome_usuario, data, imagem) values(:id_usuario, :nome_usuario, :data, :imagem)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_usuario', $this->id_usuario);
		$stmt->bindValue(':nome_usuario', $this->nome_usuario);
		$stmt->bindValue(':data', $this->data);
		$stmt->bindValue(':imagem', $this->imagem);
		$stmt->execute();
	}
}

?>