<?php

require_once 'include/utility.php';
require_once 'include/constant.php';

class FileManager{

	static function createManifestFile($manifestText){

		$manifestName = Utility::randomText().".plist";

		$myfile = fopen(MANIFEST_DIRECTORY_NAME."/".$manifestName, "w") or die("Unable to open file!");

		fwrite($myfile, $manifestText);

		fclose($myfile);

		return $manifestName;
	}

	static function readFile($filePath){

		$file = fopen($filePath, "r") or die("Unable to Open $filePath file");

	}

	static function deleteFile($fileName){

			//Delete Param Files

	}
}

?>
