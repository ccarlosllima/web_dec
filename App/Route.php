<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['inscreverse'] = array(
			'route' => '/inscreverse',
			'controller' => 'indexController',
			'action' => 'inscreverse'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['autentica'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);


		$routes['autenticar'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);





		
		// ============================================

		$routes['pessoa'] = array(
			'route' => '/pessoa',
			'controller' => 'AppController',
			'action' => 'index'
		);
		$routes['create'] = array(
			'route' => '/create',
			'controller' => 'AppController',
			'action' => 'create'
		);
		$routes['store'] = array(
			'route' => '/store',
			'controller' => 'AppController',
			'action' => 'store'
		);
		$routes['edit'] = array(
			'route' => '/edit',
			'controller' => 'AppController',
			'action' => 'edit'
		);
		$routes['destroy'] = array(
			'route' => '/destroy',
			'controller' => 'AppController',
			'action' => 'destroy'
		);
		$routes['detalhe'] = array(
			'route' => '/detalhe',
			'controller' => 'AppController',
			'action' => 'exibirDetalhe'
		);

		
		$this->setRoutes($routes);
	}

}

?>