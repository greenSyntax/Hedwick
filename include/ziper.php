<?php

$zipPath = "ChatDemo-v1.0.1.ipa";

$zip = new ZipArchive();

if($zip->open($zipPath) === true){

	$zip->extractTo('./temp');
	$zip->close();

	echo "Successfully... >";

	$myfile = fopen("temp/Payload/ChatDemo.app/Info.plist", "r") or die("Unable to open file!");
	
	echo $myfile;

	echo fread($myfile,filesize("temp/Payload/ChatDemo.app/Info.plist"));

	fclose($myfile);
}
else{

	echo "Error";
}

?>