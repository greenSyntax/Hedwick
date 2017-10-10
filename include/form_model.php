<?php

class FormModel{

	private $appName = "";
	private $bundleId = "";
	private $versionNumber = "";
	private $fileData = "";

	function __construct($appName, $bundleId, $versionNumber, $fileData){

		// Intialize Form Model
		$this->appName = $appName;
		$this->bundleId = $bundleId;
		$this->versionNumber = $versionNumber;
		$this->fileData = $fileData;
	}
}

class IpaModel{

	private $appName = "";
	private $bundleId = "";
	private $versionNumber = "";

	function __constrcut($appName, $bundleId, $versionNumber){

		$this->appName = $appName;
		$this->bundleId = $bundleId;
		$this->versionNumber = $versionNumber;
	}

	public function getAppName(){

		return $this->appName;
	}

	public function getBundle(){

		return $this->bundleId;
	}

	public function getVersion(){

		return $this->versionNumber;
	}
}

?>
