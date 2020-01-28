<?php
class Database {
	private static $dbName = 's145924' ;
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 's145924';
	private static $dbUserPassword = 'IxbcPRvAu6!H';

	private static $conn  = null;

	public function __construct() {
		die('Funkcja Init nie jest dozwolona');
	}

	public static function connect()
	{
		// Jedno po³aczenie za poœrednictwem aplikacji
		if ( null == self::$conn ) {
			try {
				self::$conn =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
			}
			catch(PDOException $e) {
				die($e->getMessage()); 
			}
		}
		// self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return self::$conn;
	}

	public static function disconnect() {
		self::$conn = null;
	}
}

?>