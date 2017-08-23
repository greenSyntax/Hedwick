<?php

// This is Development
require_once 'include/constant.php';
require_once 'include/utility.php';
require_once 'include/global_context.php';
require_once 'include/form_model.php';

class XmlManager{

	function __construct(){

	}

	function parse($pathOfUnzip, $appName){

		$url = $pathOfUnzip."/Payload/".$appName.".app/Info.plist";

		$xml = simplexml_load_file($url) or die('Cannot Load XML');

		$appName = $xml->dict->string[13];
		$versionNumber = $xml->dict->string[6];
		$bundleId = $xml->dict->string[15];

		echo "<pre>";
		print_r($xml->dict);
		//print_r($xml->dict->string[0]);
		//print_r($xml->dict->string[6]);
		//print_r($xml->dict->string[15]);

		echo "</pre>";
		
		$model = array("appName"=>$xml->dict->string[13], "version" => $xml->dict->string[6], "bundleId" => $xml->dict->string[15]);

		return $model;
	}
}

?>