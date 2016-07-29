<?php
require_once "func.php";
require_once "class.db.php";

ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
define("TOKEN", "kakamimi");
define("LOG_FILE", 'data/car.log');
define("DEFAULT_LOG_LEVEL", "ERROR");
define("DEFAULT_LOG_TIMEZONE", 'Asia/Shanghai');

try{
	//MySQL
	/*
	$dsn = 'mysql:host=mysql13.000webhost.com;port=3306;dbname=a2900283_car';
	$dbuser = 'xxx';
	$dbpass = 'xxx';
	$mysqlOptions = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"
	);
	$db = new db($dsn, $dbuser, $dbpass, $mysqlOptions);
	*/

	
	//SQLite
	$dsn = 'sqlite:data/carpark.db3';
	$db = new db($dsn);
	
	//Give the callback function to logging in order to log some SQL Errors.
	$db->setErrorCallbackFunction("logging","text");
} catch (Exception $e) {
	logging("初始化数据库连接失败: ".$e->getMessage());
	exit;
}
?>