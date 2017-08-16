<?php

$zipPath = "ChatDemo.ipa";

$zip = new ZipArchive();

if($zip->open($zipPath) === true){

	$zip->extractTo('./temp');
	$zip->close();

	echo "Successfully...";
}
else{

	echo "Error";
}

class Ziper{

	function __construct(){

	}

	static function createZip(){
		
	}
}

?>