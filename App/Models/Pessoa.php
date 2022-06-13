<?php
namespace App\Models;

use MF\Model\Model;

class Pessoa extends Model
{
    private $id;
    private $cep;
    private $endereco;
    private $numero;
    private $uf;
    private $telefone;
    private $nome;
    private $cpf;
    private $rg;
    private $dataNascimento;
    private $dataCadastro;
    private $dataAtualizacao;
    private $dataExclusao;
    
    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $value)
    {
        $this->$atributo = $value;
    }

    /**
     * MÉTODO RESPONSÁVEL POR RECUPERAR DADOS DE UM PESSOAS
     */
    public function select()
    {
        $query = '
            select * from 
                pessoas 
            inner join 
                telefones on pessoas.id = telefones.id
            inner join 
                enderecos on pessoas.id = enderecos.id
            inner join
                estados   on estados.id = endereco_id
            where 
                pessoas.data_exclusao is null';
            
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $pessoa = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        return $pessoa;
    }

    /**
     * MÉTODO RESPONSÁVEL POR RECUPERA OS DADOS DE TODAS AS TABELAS
     */
    public function selectPessoaDetalhe()
    {

        $buscaTodosDados = '
            select 
                nome,cpf,rg, data_cadastro, data_atualizacao, data_nascimento, telefone,endereco,cep,numero,uf
            from 
                pessoas 
            inner join 
                telefones on pessoas.id = telefones.id
            inner join 
                enderecos on pessoas.id = enderecos.id
            inner join
                estados   on estados.id = endereco_id
            where 
                pessoas.id = :id
            ';
        $stmt = $this->db->prepare($buscaTodosDados);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        $pessoa = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $pessoa;
    }


    /**
     * MÉTODO RESPONSÁVEL POR INSERIR REGISTROS NO BANCO
     */
    public function save()
    {
        // insere registros na tabela de estados e retorna o id do mesmo cadastrado
        $cadastraEstado = 'INSERT INTO estados(uf) VALUES(:uf)';
        $stmt = $this->db->prepare($cadastraEstado);
        $stmt->bindValue(':uf',$this->__get('uf'));
        $stmt->execute();
        $estadoId = $this->db->lastInsertId();

        // insere registros na tabela de endereços e retorna o id do mesmo cadastrado
        $cadastraEndereco = 'INSERT INTO enderecos(estado_id,cep,endereco,numero) VALUES (:estado_id, :cep, :endereco, :numero)';
        $stmt = $this->db->prepare($cadastraEndereco);
        $stmt->bindValue(':estado_id',$estadoId);
        $stmt->bindValue(':cep',$this->__get('cep'));
        $stmt->bindValue(':endereco', $this->__get('endereco'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->execute();
        $enderecoId = $this->db->lastInsertId();

        // insere registros na tabela de pessoas e retorna o id do mesmo cadastrado
        $cadastraPessoa = 'INSERT INTO pessoas(endereco_id,nome,cpf,rg,data_nascimento,data_cadastro) 
                             VALUES(:endereco_id, :nome, :cpf, :rg, :data_nascimento, :data_cadastro)';
        $stmt = $this->db->prepare($cadastraPessoa);
        $stmt->bindValue(':endereco_id', $enderecoId);
        $stmt->bindValue(':nome',$this->__get('nome'));
        $stmt->bindValue(':cpf',$this->__get('cpf'));
        $stmt->bindValue(':rg',$this->__get('rg'));
        $stmt->bindValue(':data_nascimento', $this->__get('dataNascimento'));
        $stmt->bindValue(':data_cadastro', date('Y/m/d H:i:s'));
        $stmt->execute();
        $pessoa_id = $this->db->lastInsertId();

        // insere registros de tabela de telefones
        $cadastraTelefone = 'INSERT INTO telefones(pessoa_id,telefone) VALUES(:pessoa_id,:telefone)';
        $stmt = $this->db->prepare($cadastraTelefone);
        $stmt->bindValue(':pessoa_id', $pessoa_id);
        $stmt->bindValue(':telefone', $this->__get('telefone'));
        $stmt->execute();

        return true;
    }

    
    /**
     * MÉTODO RESPONSÁVEL POR REMOVER UM REGISTRO
     */
    public function delete()
    {
        $query = "UPDATE pessoas SET data_exclusao = :data_exclusao WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':data_exclusao', date('Y/m/d H:i:s'));
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->execute(); 
    }

    
    /**
     * MÉTODO RESPONSÁVEL POR ATUALIZAR UM REGISTRO
     */
    public function update()
    {
        $updatePessoa = ' UPDATE pessoas SET nome = :nome, cpf = :cpf,rg = :rg,data_atualizacao = :data_atualizacao,
                        data_nascimento = :dt_nas
                        where id = :id';

        $stmt = $this->db->prepare($updatePessoa);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':rg', $this->__get('rg'));
        $stmt->bindValue(':data_atualizacao', date('Y/m/d H:i:s'));
        $stmt->bindValue(':dt_nas', $this->__get('dataNascimento'));
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();


        $updateEndereco = 'UPDATE enderecos SET endereco = :ender, cep = :cep, numero = :num where id = :id';
        $stmt = $this->db->prepare($updateEndereco);
        $stmt->bindValue(':ender', $this->__get('endereco'));
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':num', $this->__get('numero'));
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();


        $updateEstado = ' UPDATE estados SET uf = :uf where id = :id';
        $stmt = $this->db->prepare($updateEstado);
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        $updateTelefone = 'UPDATE telefones SET telefone = :fone where id = :id';
        $stmt = $this->db->prepare($updateTelefone);
        $stmt->bindValue(':fone', $this->__get('telefone'));
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

              
    }
}


?>