<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action
{
    /**
     * MÉTODO RESPONSÁVEL POR EXECUTAR A AUTENTICAÇÃO DO USUÁRIO
     */
    public function autenticar()
    {
        //cria instância de usuário
        $usuario = Container::getModel('usuario');

        // recupera os dados do formulário e seta os atributos de da classe usuário
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', md5($_POST['senha']));

        // realiza a autenticação
        $usuario->autenticar();
    
        //verifica na classe usuário se existe (id e nome)
        if ($usuario->__get('id') != '' && $usuario->__get('nome') != '') {

            // cria uma sessão e rediriciona para página de listagem
            session_start();
            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['nome'] = $usuario->__get('nome');

            header('location:/pessoa');
            
        }else{
            header('location:/?login=error');
            exit;
        }
       
    }
    
    /**
     * MÉTODO RESPONSÁVEL POR DESCONECTAR O USUÁRIO
     */
    public function sair()
    {   
        session_start();

        session_destroy();

        header("location:/");
    }

  
}

?>