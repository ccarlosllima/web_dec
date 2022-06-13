<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action 
{
    /**
     * MÉTODO RESPONSÁVEL POR EXECUTAR A LISTAGEM PESSOAS
     */
    public function index()
    {   
        // inicia a sessão
        session_start();
        if ($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
            
            // realiza uma instância de pessoa
            $pessoa = Container::getModel('pessoa');
            $listaPessoas = $pessoa->select();

            // cria uma variavél (pessoa) na view, atribui o resultado de (lista_pessoas)
            $this->view->pessoas = $listaPessoas; 

            return $this->render('listagem');
        }else {

            header('Location:/?acesso=negado');
        }

    }

    /**
     * MÉTODO RESPONSÁVEL POR EXIBIR FORMULÁRIO PARA CADASTRAR PESSOA
     */
    public function create()
    {
        // inicia a sessão
        session_start();
        if ($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
        
            // renderiza o formulário
            return $this->render('cadastro');
          
        }else {
            // redirecionamento para raiz
            header('Location:/?acesso=negado');
            exit;
        }
    }
    
    /**
     * MÉTODO RESPONSÁVEL POR ARMAZENAR NOVA PESSOA
     */
    public function store()
    {
        session_start();

        if ($_SESSION['id'] != '' && $_SESSION['nome'] != '') { 

            if (!empty($_POST['id'])) {

                // Lógica para atualizar os registros
                $pessoa = Container::getModel('pessoa');
               
                // informaçõa de pessoa
                $pessoa->__set('id', $_POST['id']);
                $pessoa->__set('nome', $_POST['nome']);
                $pessoa->__set('cpf',$_POST['cpf']);
                $pessoa->__set('dataNascimento',$_POST['data_nascimento']);
                $pessoa->__set('rg',$_POST['rg']);

                // informação de endereco
                $pessoa->__set('cep',$_POST['cep']);
                $pessoa->__set('numero',$_POST['numero']);
                $pessoa->__set('endereco',$_POST['endereco']);
                
                // informação de estado
                $pessoa->__set('uf',$_POST['uf']);
                
                // informação de telefone
                $pessoa->__set('telefone',$_POST['telefone']);                                                                        

                // executa a atualização
                $pessoa->update();

                header('Location:/pessoa');
            }else {

                // realiza uma instância de pessoa 
                $pessoa = Container::getModel('pessoa'); 
                
                // preenche seus atributos do objeto
                $pessoa->__set('nome', $_POST['nome']);
                $pessoa->__set('cpf',$_POST['cpf']);
                $pessoa->__set('dataNascimento',$_POST['data_nascimento']);
                $pessoa->__set('rg',$_POST['rg']);
                $pessoa->__set('telefone',$_POST['telefone']);
                $pessoa->__set('uf',$_POST['uf']);
                $pessoa->__set('cep',$_POST['cep']);
                $pessoa->__set('numero',$_POST['numero']);
                $pessoa->__set('endereco',$_POST['endereco']);
                
                // salva as informações
                $pessoa->save();

                header('location:/pessoa');
                exit;
            }

        }else {

            header('Location:/?acesso=negado');
            exit;
        }    

        return true ;
    }
    /**
     * MÉTODO RESPONSÁVEL POR EXIBIR FORMULÁRIO COM AS INFORMAÇÕES PARA ATUALIZAÇÃO
     */
    public function edit()
    {
        session_start();

        if ($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
        
            if (isset($_GET['id']) && $_GET['id'] != '') {
                // envia o ID para o model
                $pessoa = Container::getModel('pessoa');
                $pessoa->__set('id', $_GET['id']);

                // busca as informações
                $dados = $pessoa->selectPessoaDetalhe();

                // envia para view
                $this->view->pessoa = $dados; 
                 
                // renderiza a view
                return $this->render('cadastro');
            }
          
        }else {

            header('Location:/?acesso=negado');

            exit;
        }
    }

/**
 * MÉTODO RESPONSÁVEL POR DESATIVAR UM REGISTRO
 */
    public function destroy()
    {
        session_start();
        if ($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
         
            if (isset($_GET['id']) && $_GET['id'] != '') {
                
                // realiza uma instância de pessoa 
                $pessoa = Container::getModel('pessoa');

                // envia o ID para o model
                $pessoa->__set('id', $_GET['id']);

                // desativa o registro
                $pessoa->delete();

                header('Location:\pessoa');
                exit;
            }
          
        }else {

            header('Location:/?acesso=negado');
            exit;
        }

    }
    
    public function exibirDetalhe()
    {
        session_start();

        if ($_SESSION['id'] != '' && $_SESSION['nome'] != '') {
            
            // realiza intância de pessoa
            $pessoa = Container::getModel('pessoa');

            if (isset($_GET['id']) && $_GET['id'] != '') {

                // envia o ID para o model
                $pessoa->__set('id', $_GET['id']);
                
                // obtem o array de pessoas
                $dados = $pessoa->selectPessoaDetalhe();
                
                // envia o array para view
                $this->view->pessoa = $dados;
                
                // renderiza a view
                $this->render('detalhe');
            }
                 
        }else {

            header('Location:/?acesso=negado');

            exit;
        }
    }

}

?>