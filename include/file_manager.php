<?php 

class FileManager{


	static function createManifestFile($manifestText){

		$myfile = fopen("manifest/manifest.plist", "w") or die("Unable to open file!");
		
		fwrite($myfile, $manifestText);
		
		fclose($myfile);

		return true;
	}

	static function deleteFile($fileName){

		
	}
}

?>