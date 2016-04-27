<?php

class Logging{

	protected $_logLevel = "";	//INFO, DEBUG, ERROR
	protected $_logFileName = "./carQuery.log";
	protected $_logText = "";

    public function __construct( ) {
    }
	
	public function ERROR($logText){
		$this->$_logLevel = "ERROR";
		$this->$_writeLog();
	}
	
	private function _writeLog(){
		$fileHandle = fopen($this->_logFileName, "a");
		
	}
}
?>