<?php

namespace MF\Controller;

abstract class Action {

	protected $view;

	public function __construct() {
		$this->view = new \stdClass();
	}

	/**
	 * MÉTODO RESPONSÁVEL POR RENDERIZAR VIEW
	 */
	protected function render($view, $layout = 'layout') {
		$this->view->page = $view;

		if(file_exists("../App/Views/".$layout.".phtml")) {
			require_once "../App/Views/".$layout.".phtml";
		} else {
			$this->content();
		}
	}

	/**
	 * MÉTODO RESPONSÁVEL PELO CONTEÚDO DA VIEW
	 */
	protected function content() {
		$classAtual = get_class($this);

		$classAtual = str_replace('App\\Controllers\\', '', $classAtual);

		$classAtual = strtolower(str_replace('Controller', '', $classAtual));

		require_once "../App/Views/".$classAtual."/".$this->view->page.".phtml";
	}
}

?>