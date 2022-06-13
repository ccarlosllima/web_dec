<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {
		// rota raiz, retorna formulário para login
		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);
		// rota para disponibilizar formulario para cadastro de usuário
		$routes['inscreverse'] = array(
			'route' => '/inscreverse',
			'controller' => 'indexController',
			'action' => 'inscreverse'
		);
		// rota onde recebe os dados do usuário pra registro no sistema
		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		// rota para usuario ter acesso
		$routes['autentica'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

		// rota para sair do sistema 
		$routes['autenticar'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		// ============================================

		// rota onde exibe tabela com as informações de pessoas cadastradas
		$routes['pessoa'] = array(
			'route' => '/pessoa',
			'controller' => 'AppController',
			'action' => 'index'
		);
		// rota para criar nova pessoa, retorna view de cadastro 
		$routes['create'] = array(
			'route' => '/create',
			'controller' => 'AppController',
			'action' => 'create'
		);
		// rota onde recebe as informações para persistir no DB
		$routes['store'] = array(
			'route' => '/store',
			'controller' => 'AppController',
			'action' => 'store'
		);
		// rota para edicao de pessoas
		$routes['edit'] = array(
			'route' => '/edit',
			'controller' => 'AppController',
			'action' => 'edit'
		);
		// rota para deletar pessoas
		$routes['destroy'] = array(
			'route' => '/destroy',
			'controller' => 'AppController',
			'action' => 'destroy'
		);
		// rota para exibir todas as informações de pessoa 
		$routes['detalhe'] = array(
			'route' => '/detalhe',
			'controller' => 'AppController',
			'action' => 'exibirDetalhe'
		);
	
		$this->setRoutes($routes);
	}

}

?>