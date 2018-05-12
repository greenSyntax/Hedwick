<?php

require 'utils/context.php';

class FileManager{

	// Write File
	static function createManifestFile($manifestText){

		$manifestName = Utility::randomText().".plist";

		$myfile = fopen(MANIFEST_DIRECTORY_NAME."/".$manifestName, "w") or die("Unable to open file!");
		fwrite($myfile, $manifestText);
		fclose($myfile);

		return $manifestName;
	}

	// Read File
	static function readFile($filePath){

		$file = fopen($filePath, "r") or die("Unable to Open $filePath file");

	}

	// Delete File
	static function deleteFile($fileName){

	}
}

?>
