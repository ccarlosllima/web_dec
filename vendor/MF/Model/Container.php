<?php

namespace MF\Model;

use App\Connection;

class Container {

	/**
	 * MÉTODO RESPONSÁVEL POR INSTANCIAR UM MODEL COM A CONEXÃO AO DB
	 */
	public static function getModel($model) {
		$class = "\\App\\Models\\".ucfirst($model);
		$conn = Connection::getDb();

		return new $class($conn);
	}
}


?>