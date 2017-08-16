<?php

require_once 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogManager{

	private static $fileName = "history.log";

	function __construct(){

	}

	public static function report($code, $message){

		$log = new Logger("Log");
		$log->pushHandler(new StreamHandler(LogManager::$fileName, Logger::WARNING));

		#$log->warning('Foo');
		$log->error($code." : ".$message);
	}
}


?>