<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model 
{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $value)
    {
        $this->$atributo = $value;
    }

    /**
     * SALVA USUARIO NO BANCO DE DADOS
     */
    public function salvar()
    {
        $query = 'INSERT INTO usuarios(nome, email, senha) VALUES(:nome, :email, :senha)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();
        return $this;
    }
    /**
     * DETERMINA UMA CONDIÇÃO PARA O CADASTRO PODER SER CONCLUIDO COM SUCESSO
     */
    public function validarCadastro()
    {
        $valido = true;
        
        if (strlen($this->__get('nome')) < 3) {
            $valido = false;
        }
        if (strlen($this->__get('email')) < 3 ) {
            $valido = false;
        }
        if (strlen($this->__get('senha')) < 3) {
            $valido = false;
        }
        return $valido;
    }
    /**
     * MÉTODO RESPONSAVEL POR VERIFICAR SE O EMAIL DE UM USUARIO JÁ ESTA CADASTRADO NO BANCO
     */
    public function getUsuarioPorEmail()
    {
        $query = 'SELECT nome, email, senha FROM usuarios WHERE email = :email';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email',$this->__get('email'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    /**
     * MÉTODO RESPONSAVEL POR BUSCAR UM USUÁRIO NO BANCO DE DADOS
     */
    public function autenticar()
    {
        $query = 'SELECT * FROM usuarios WHERE email = :email AND senha = :senha';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha',$this->__get('senha'));
        $stmt->execute();
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($usuario['id'] != "" && $usuario['nome'] != "") {
            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']);
        }

        return $this;
    }

   
}


?>