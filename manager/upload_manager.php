<?php

class UploadManager{

	function __construct(){
		require 'utils/context.php';
	}

	function uploadFile($uploadFile){

		if(isset($uploadFile)){

			//File Information
			$file_name = $uploadFile['name'];
			$file_path = $uploadFile['tmp_name'];
			$file_size = $uploadFile['size'];
			$file_error = $uploadFile['error'];

			$file_name_array = explode('.', $file_name);
			$file_extension = strtolower(end($file_name_array));

			//Only *.IPA and *.APK files are allowed
			$allowedExtension = array(APK, IPA);

			if(in_array($file_extension, $allowedExtension)){

				if($file_error == null){

					if($file_size < (int)UPLOAD_FILE_SIZE){

						//Everything is file, Upload to Destination
						$file_new_name = uniqid('',true).'.'.$file_extension;

						$file_destination = UPLOAD_DIRECTORY_NAME.'/'.$file_new_name;

						if(move_uploaded_file($file_path, $file_destination)){

							# echo "Successfully Uploaded  ".$file_destination. " :)";

							return $file_destination;
						}
						else{

							return ERROR_INCORRECT_PATH;
						}
					}
					else{

						return ERROR_INVALID_SIZE; //Size is greather than Limit.
					}
				}
				else{

					return "$file_error";
				}
			}
			else{

				if($file_extension != null){
					return ERROR_INVALID_FILE;
				}
				else{
					return ERROR_NO_BUILD;
				}
			}
		}
	}
}

?>
