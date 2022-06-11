<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action 
{
    /**
     * MÉTODO RESPONSÁVEL POR LISTAR PESSOAS
     */
    public function index()
    {   
        $pessoa = Container::getModel('pessoa');
        $lista_pessoas = $pessoa->select();
        $this->$view->pessoas = $lista_pessoas; 
        return $this->render('listagem');
    }

    /**
     * MÉTODO RESPONSÁVEL POR EXIBIR FORMULÁRIO PARA CADASTRAR PESSOA
     */
    public function create()
    {
        return $this->render('cadastro');
    }
    
    /**
     * MÉTODO RESPONSÁVEL POR ARMAZENAR NOVA PESSOA
     */
    public function store()
    {
        $pessoa = Container::getModel('pessoa');
        
        $pessoa->__set('nome', $_POST['nome']);
        $pessoa->__set('cpf',$_POST['cpf']);
        $pessoa->__set('dataNascimento',$_POST['data_nascimento']);
        $pessoa->__set('rg',$_POST['rg']);
        $pessoa->__set('telefone',$_POST['telefone']);
        $pessoa->__set('uf',$_POST['uf']);
        $pessoa->__set('cep',$_POST['cep']);
        $pessoa->__set('numero',$_POST['numero']);
        $pessoa->__set('endereco',$_POST['endereco']);
       
        $pessoa->save();

        header('location:/pessoa');
        exit;

        return true ;
    }

    public function edit()
    {
        $pessoa = Container::getModel('pessoa');

        if (isset($_GET['id']) && $_GET['id'] != '') {
        
            $res = $pessoa->selectById($_GET['id']);
        }
    }


    public function destroy()
    {
        $pessoa = Container::getModel('pessoa');
        if (isset($_GET['id']) && $_GET['id'] != '') {
        
            $pessoa->__set('id', $_GET['id']);
        }

        $pessoa->delete();

    }

   






















    function dd($dados = [])
    {
        echo "<pre>";
        print_r($dados);
        echo "</pre>";
        echo "<hr>";
    }
    
}

?>