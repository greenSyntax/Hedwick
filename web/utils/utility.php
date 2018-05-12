<?php

class Utility {
	
	// Get Requested Domain Name
	static function getHostName() {
		return "https://".HostManager::getDomain();
	}
	
    // Random Text of defined Length
    static function randomText($length = 10) {

	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';

	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
	    return $randomString;
	}

    // File First Name
	static function getFirstName($appName){

        $newName = strstr( $appName, '-', true);
        
        if($newName == null){
			return strstr( $appName, '.', true);
        }

		return $newName;
	}

    // Current Date
	static function getCurrentDateTime(){

		return date("Y-m-d h:i:sa", time());
	}

}

?>