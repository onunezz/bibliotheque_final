<?php

/**
 * Conexión con la base de datos MySQL
 * 
 * @method connect() devuelve un objeto PDO de conexion con la base
 * 
 */

class MysqlDb
{

	static public function connect()
	{
		$hostname = getenv("MYSQL_SERVER");
		$database = getenv("MYSQL_DATABASE");
		$username = getenv("MYSQL_USER");
		$password = getenv("MYSQL_PASS");
		$charset = "utf8";

		try {
			$connection = "mysql:host=" . $hostname . ";dbname=" . $database . ";charset=" . $charset;
			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES => false,
			];
			$pdo = new PDO($connection, $username, $password, $options);
			return $pdo;
		} catch (PDOException $e) {
			echo 'Error de conexión: ' . $e->getMessage();
			exit;
		}
	}

	static public function testConnection()
	{
		$pdo = self::connect(); // Llama al método estático de conexión

		if ($pdo) {
			echo "conexion exitosa";
		} else {
			echo 'Error al conectar a la base de datos.';
		}
	}
}
