<?php
include_once 'user_class.php';
class UserDB
{
	public static function connect_mysql()
	{
		$servername = "localhost";
		$username = "root";
		$password = "pikachu1985";
		$dbname = "mydb";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		return $conn;
	}
	
	public static function runquery()
	{
	}
}
?>