<?php
class ConnectionLib{
	// static significa que o atributo ou método pertence à classe e não a instância dela
	private static $instance;

	public function __construct(){}

	public static function getConnection(){
		if (!self::$instance){
			ConnectionLib::open();
		}
		return self::$instance;
	
}
	private static function open(){
		$dbType 	= DBTYPE;
		$host 		= HOST;
		$dbname 	= DBNAME;
		$user		= USER;
		$pass 		= PASS;
		$dns 		= "{$dbType}:host={$host};dbname={$dbname};charset=utf8";

		try{
			$con = new PDO($dns, $user, $pass);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$instance = $con;
		}catch (PDOException $e){
			return "ERRO NA CONEXAO COM O BANCO DE DADOS: {$e->getMessage()}";
		}	
		return self::$instance;
	}
}
?>