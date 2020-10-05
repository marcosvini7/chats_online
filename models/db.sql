create database chat;

create table usuarios(
	id int not null primary key auto_increment,
	nome varchar(255) not null,
	nome_usuario varchar(255) not null, 
	nascimento varchar(255) not null,
	email varchar(255) not null,
	senha varchar(255) not null
);

create table mensagens(
	id int not null primary key auto_increment,
	mensagem text not null,
	data varchar(255) not null,
	id_usuario int not null
	nome_usuario varchar(255) not null,
	id_destinatario int not null default 0
);
 
create table perfis(
	id_usuario int not null primary key,
	imagem varchar(255),
	sobre varchar(255),
	cidade varchar(255),
	trabalho varchar(255),
	faculdade varchar(255),
	hobbies varchar(255) 
);

create table seguir(
	id int not null primary key auto_increment,
	id_usuario int not null,
	id_perfil int not null
);

create table postagem(
	id int not null primary key auto_increment,
	id_usuario int not null,
	descricao text,
	imagem varchar(250),
	data varchar(250),
	status int default 0
);

alter table mensagens modify mensagem text;
alter table mensagens add column imagem varchar(250);