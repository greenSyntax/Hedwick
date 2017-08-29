<?php

	class Utility{

		static function randomText($length = 10) {

	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';

	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
		}

		# GET FIRST NAME OF THE APP
		static function getFirstName($appName){

			$newName = strstr( $appName, '-', true);

			if($newName == null){
				return strstr( $appName, '.', true);

			}

			return $newName;
		}
	}

?>
