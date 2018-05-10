<?php

class ValidationManager{

	static function validateField($data){
		
		$data = htmlspecialchars($data);
		$data = trim($data);
  		$data = stripslashes($data);
  		return $data;
	}
}

?>