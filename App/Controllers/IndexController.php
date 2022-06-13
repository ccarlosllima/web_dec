<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action 
{
	/**
	 * MÉTODO RESPONSÁVEL POR EXIBIR VIEW DE LOGIN
	 */
	public function index() 
	{
		$this->render('index');
	}
	
	/**
	 * MÉTODO RESPONSÁVEL POR EXIBIR VIWE DE INSCRIÇÃO PARA NOVOS USUÁRIOS
	 */
	public function inscreverse() 
	{	
		$this->view->usuario = array(
			'nome'  => '',
			'email' => '',
			'senha' => ''
		);
		$this->view->errorCadastro = false;

		$this->render('inscreverse');
	}
	
	/**
	 * MÉTODO RESPONSÁVEL POR REALIZAR O CADASTRO DE NOVOS USUÁRIOS
	 */
	public function registrar()
	{	
		// cria um instância de (Usuario)
		$usuario = Container::getModel('Usuario');

		// preenche os atributos da classe
		$usuario->__set('nome',$_POST['nome']);
		$usuario->__set('email',$_POST['email']);
		$usuario->__set('senha',$_POST['senha']);

		//verifica se o usuário existe 
		if ($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0) {	
		
			$usuario->salvar();

			$this->render('cadastro');
			
		}else{
			$this->view->usuario = array(
				'nome'  => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			);
			$this->view->errorCadastro = true;
			$this->render('inscreverse');
		}
			
	}

}

?>