<?php
require('includes.inc.php');

class SingletonDB
{
	private static $connection;
	
	private function __construct()
	{
		//echo "SingletonDB a fost construita!";
	}
	
	public static function connect()
	{
		if(!isset(self::$connection))
		{
			self::$connection = new mysqli(ADDRESS, USERNAME, PASSWORD, DATABASE);
			
			if(mysqli_connect_error() || !self::$connection)
				throw new DBException('connect');
		}
		
		return self::$connection;
	}
	
	public function __clone()
	{
		trigger_error("Cloning is not alowed in SingletonDB!", E_USER_ERROR);
	}
}

?>
