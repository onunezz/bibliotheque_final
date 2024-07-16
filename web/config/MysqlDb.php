<?php 
/**
 * Conexión con la base de datos MySQL
 * 
 * @method connect() devuelve un objeto PDO de conexion con la base
 * 
 */

class MysqlDb {
	
	public function connect() {

		$pdo = new PDO("mysql:host=".$_ENV["SQL_SERVER"]."; dbname=".$_ENV["SQL_DATABASE"], $_ENV["SQL_USER"], $_ENV["SQL_PASS"]);
		$pdo->exec("set names utf8");
		return $pdo;

	}

}