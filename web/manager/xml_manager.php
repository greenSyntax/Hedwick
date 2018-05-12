<?php

require 'utils/context.php';

class XmlManager{

	function __construct(){

	}

	function parse($pathOfUnzip, $appName){

		$url = $pathOfUnzip."/Payload/".$appName.".app/Info.plist";

		$xml = simplexml_load_file($url);

		if($xml == null){
			return FAIL_LOAD_XML;
		}

		$appName = $xml->dict->string[13];
		$versionNumber = $xml->dict->string[6];
		$bundleId = $xml->dict->string[15];

		echo "<pre>";
		print_r($xml->dict);
		print_r($xml->dict->string[13]);
		print_r($xml->dict->string[6]);
		print_r($xml->dict->string[15]);

		echo "</pre>";

		$model = array("appName"=>$appName, "version" => $versionNumber, "bundleId" => $bundleId);

		return $model;
	}
}

?>
