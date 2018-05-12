<?php

require 'utils/context.php';

class ZipManager{

	function __construct(){

	}

	function extract($zipPath){

		$zip = new ZipArchive();

		if($zip->open($zipPath) === true){

			$extractPath = './'.ZIP_DIRECTORY_NAME.'/'.Utility::randomText();

			$zip->extractTo($extractPath);
			$zip->close();

			# echo "ZIP Extrcated Path : $extractPath";

			return $extractPath;
		}
		else{

			# echo "Cant Open Zip";
		}

	}
}

?>