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

    public function select()
    {
        $query = 'select * from pessoas';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $pessoa = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      
        return $pessoa;
    }

    /**
     * MÉTODO RESPONSÁVEL POR RECUPERA OS DADOS DE TODAS AS TABELAS
     */
    public function getAll()
    {
        $buscaTodosDados = '
        select 
            nome,
            cpf,
            rg,
            data_nascimento,
            data_cadastro, 
            telefone, 
            endereco,
            numero,
            cep, 
            uf
        from 
            pessoas

        inner join telefones on telefones.id = pessoa_id
        inner join enderecos on enderecos.id = pessoa_id
        inner join estados   on estados.id   = endereco_id;
        ';
        $stmt = $this->db->prepare($buscaTodosDados);
        $stmt->execute();
        $pessoa = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $pessoa;
    }

    /**
     * MÉTODO RESPONÁVEL POR BUSCAR UM ÚNICO REGISTRO
     */
    public function selectById($id)
    {   
        $query = 'SELECT * from pessoas WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * MÉTODO RESPONSÁVEL POR INSERIR REGISTROS NO BANCO
     */
    public function save()
    {
        $cadastraEstado = 'INSERT INTO estados(uf) VALUES(:uf)';
        $stmt = $this->db->prepare($cadastraEstado);
        $stmt->bindValue(':uf',$this->__get('uf'));
        $stmt->execute();
        $estadoId = $this->db->lastInsertId();

        $cadastraEndereco = 'INSERT INTO enderecos(estado_id,cep,endereco,numero) VALUES (:estado_id, :cep, :endereco, :numero)';
        $stmt = $this->db->prepare($cadastraEndereco);
        $stmt->bindValue(':estado_id',$estadoId);
        $stmt->bindValue(':cep',$this->__get('cep'));
        $stmt->bindValue(':endereco', $this->__get('endereco'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->execute();
        $enderecoId = $this->db->lastInsertId();


        $cadastraPessoa = 'INSERT INTO pessoas(endereco_id,nome,cpf,rg,data_nascimento,data_cadastro) VALUES(:endereco_id, :nome, :cpf, :rg, :data_nascimento, :data_cadastro)';
        $stmt = $this->db->prepare($cadastraPessoa);
        $stmt->bindValue(':endereco_id', $enderecoId);
        $stmt->bindValue(':nome',$this->__get('nome'));
        $stmt->bindValue(':cpf',$this->__get('cpf'));
        $stmt->bindValue(':rg',$this->__get('rg'));
        $stmt->bindValue(':data_nascimento', $this->__get('dataNascimento'));
        $stmt->bindValue(':data_cadastro', date('Y/m/d H:i:s'));
        $stmt->execute();
        $pessoa_id = $this->db->lastInsertId();

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
        $query = "DELETE FROM pessoas WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->execute(); 
        return $stmt->rowCount();
    }
}


?>