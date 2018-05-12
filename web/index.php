<?php

require 'utils/context.php';

if(!isDevelopment){
	// Turn off all error reporting
	error_reporting(0);
}

# print_r($_POST);

//Error
$errorLog = array();

if(count($_FILES) > 0) {

	if(!empty($_FILES['build_ipa'])) {

		LogManager::report(0, "=============================");

		// Upload Files
		$buildController = new BuildController();
		$uploadPath = $buildController->uploadBuild($_FILES['build_ipa']);
		
		echo "\nUpload Status : ".$uploadPath;

		// Check Upload Status
		if (strpos($uploadPath, 'uploads') === 0 || strpos($uploadPath, 'uploads') !== false) {
		
			LogManager::report(1, "Upload Path : ".$uploadPath);

			// Save Metadata to Context
			$buildController->saveAppDetails($_FILES['build_ipa']);		
			
			if(CacheStorage::$extension == strtolower("APK")) {
				archiveForAndroid($uploadPath);
			}		
			else {
				archiveForiOS($uploadPath, $buildController);
			}

		} 
		else {

			// Can't Uploaded Successfully
			LogManager::report(0, "Failed Upload : ".$uploadPath);
			CacheStorage::$readyToDownload = false;
		}

		LogManager::report(0, "=============================");

	}
	else{

		// No Build
		LogManager::report(0, "Files are not available." );
		array_push($errorLog, ERROR_NO_BUILD);
	}
}

function archiveForAndroid($uploadPath) {

	if($uploadPath != null) {

		$sharing = new SharingController();

		// Minifed URL for Android
		CacheStorage::$sharingLink = $sharing->sharableAndroidLink($uploadPath);
		LogManager::report(1, "Android Sharable Link : ".CacheStorage::$sharingLink );
		CacheStorage::$readyToDownload = true;
	}
	else {
		CacheStorage::$readyToDownload = false;
	}
}

function archiveForiOS($uploadPath, $buildController) {

	if($uploadPath != null) {

		$sharing = new SharingController();

		// Create Manifest
		$manifestController = new ManifestController();
		$manifestPath = $manifestController->createManifestFile(CacheStorage::$appName, $uploadPath);
	
		LogManager::report(1, "iOS Maniefest.plist Path : ".$manifestPath );

		// Prepare Formatted Manifest Path
		$sharablableUrl = $buildController->getIPALinkUrl($manifestPath);
	
		// Minified URL for iOS
		CacheStorage::$sharingLink = $sharing->sharableIPALink($sharablableUrl);
		LogManager::report(1, "iOS Sharable Link : ".CacheStorage::$sharingLink );
		CacheStorage::$readyToDownload = true;

	}
	else {
		CacheStorage::$readyToDownload = false;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Abhishek Kumar Ravi">

	<title>Share Your IPA</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 boxContainer">
				<div class="text-right"><small><?php echo APP_VERSION; ?>  <strong>BETA</strong></small></div>
				<div class="text-center">
					<h1><i class="fa fa-cloud" aria-hidden="true"></i>&nbsp;<?php echo APP_NAME; ?></h1>
					<h5 class="subtitle"><?php echo APP_DESCRIPTION; ?></h5>
					<hr>
				</div>

				<form id="formUpload" method="POST" enctype="multipart/form-data">

				<div class="form-group">
					<div class="alert alert-info" role="alert">
						<label for="buildLabel">Upload Bundle</label>
						<input type="file" id="build_ipa" name="build_ipa">
					</div>
				</div>

				<?php

				if(CacheStorage::$readyToDownload == true){

					echo '<p></p>';

					if(CacheStorage::$sharingLink == null) {

						echo '<div class="alert alert-error" role="alert">';
						echo '<i class="fa fa-check-circle" aria-hidden="true"></i> There might be some error. Please try again :/';
						echo '</div>';
					}
					else{
						
						echo '<div class="alert alert-success" role="alert">';
						echo '<i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;'.CacheStorage::$sharingLink;
						echo '</div>';
					}
				}

				?>

				<br>

				<div class="text-center">
					<input type="submit" class="btn btn-success" value="Upload Your IPA" onclick="upload_ipa();"></input>

				</div>

				<p></p>


				<?php

				//If There is any Error
				if(isset($errorLog)){

					foreach ($errorLog as $error) {

						echo '<div class="alert alert-danger" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">Error:</span>'.
						$error.'
						</div>';
					}
				}
				?>

			</form>

		</div>
		<div class="col-sm-3"></div>
	</div>

	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6 footer">
			<h5 class="text-center strong"><i class="fa fa-copyright" aria-hidden="true"></i>&nbsp;<strong>Abhishek Kunar Ravi</strong> | <a href="https://github.com/greenSyntax/IPA-Distribution-Interface"> Want to Contribute&nbsp;<i class="fa fa-github" aria-hidden="true"></i></a></h5>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
