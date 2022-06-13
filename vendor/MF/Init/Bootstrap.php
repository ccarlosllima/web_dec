<?php

namespace MF\Init;

abstract class Bootstrap {

	private $routes;

	abstract protected function initRoutes(); 

	public function __construct() {
		$this->initRoutes();
		$this->run($this->getUrl());
	}

	/**
	 * MÉTODO RESPONSÁVEL POR OBTER ROTA
	 */
	public function getRoutes() {
		return $this->routes;
	}

	/**
	 * MÉTODO RESPONSÁVEL PARA SETAR ROTA
	 */
	public function setRoutes(array $routes) {
		$this->routes = $routes;
	}

	/**
	 * MOÉTODO RESPONSÁVEL POR EXECUTAR ROTA
	 */
	protected function run($url) {
		foreach ($this->getRoutes() as $key => $route) {
			if($url == $route['route']) {
				$class = "App\\Controllers\\".ucfirst($route['controller']);

				$controller = new $class;
				
				$action = $route['action'];

				$controller->$action();
			}
		}
	}

	/**
	 * MÉTODO RESPONSÁVEL POR OBTER URL
	 */
	protected function getUrl() {
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}
}

?>