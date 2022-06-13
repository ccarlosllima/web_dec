<?php

namespace App;

class Connection {

	public static function getDb() {
		try {

			$conn = new \PDO(
				"mysql:host=localhost;dbname=web_db02;charset=utf8",
				"carloslima",
				"root" 
			);

			return $conn;

		} catch (\PDOException $e) {
			echo 'Erro ao conectar ao banco de dados '.$e->getMessage();
		}
	}
}

?>




























