<?php


namespace MF\Model;

abstract class Model {

	protected $db;
    /**
	 * MÉTODO RESPONSÁVEL RECEBER A CONEXÃO COM BD 
	 */
	public function __construct(\PDO $db) {
		$this->db = $db;
	}
}


?>