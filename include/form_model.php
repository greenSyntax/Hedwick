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

?>