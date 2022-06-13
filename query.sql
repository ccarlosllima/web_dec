create database web_db;
use web_db;

create table estados(
	id int auto_increment not null,
    uf char(2) not null,
    primary key(id)
);

create table enderecos(
	id int auto_increment not null,
    estado_id int not null,
    cep varchar(11) not null,
    endereco varchar(100) not null,
    numero varchar(8) not null,
    primary key(id),
    foreign key(estado_id)references estados(id)
);

create table pessoas(
	id int auto_increment not null,
    endereco_id int not null,
    nome varchar(100) not null,
    cpf varchar(11) not null,
    rg varchar (11) not null,
    data_nascimento date not null,
    data_cadastro datetime not null,
    data_atualizacao datetime,
    data_exclusao datetime,
    primary key(id),
    foreign key(endereco_id)references enderecos(id)
);
create table telefones(
	id int auto_increment not null,
    pessoa_id int not null,
    telefone varchar(11) not null,
    primary key(id),
    foreign key(pessoa_id)references pessoas(id)
);
create table usuarios(
    id int not null auto_increment,
    nome varchar(100) not null,
    email varchar(150) not null,
    senha varchar(32)not null,
    primary key(id)
);