<?php

require_once 'include/constant.php';
require_once 'include/upload_manager.php';
require_once 'include/global_context.php';
require_once 'include/validation_manager.php';
require_once 'include/file_manager.php';
require_once 'include/tiny_url_manager.php';

//Error
$errorLog = array();

if(count($_POST) > 0){
	
	// Validate HTML Tags
	if(!empty($_POST['app_name'])){

		if(!empty($_POST['bundle_id'])){

			if(!empty($_POST['version_no'])){

				if(!empty($_FILES['build_ipa'])){

					$appName = ValidationManager::validateField($_POST['app_name']);
					$bundleId = ValidationManager::validateField($_POST['bundle_id']);
					$versionNo = ValidationManager::validateField($_POST['version_no']);


					$upload = new UploadManager();
					$uploadResponse = $upload->uploadFile($_FILES['build_ipa']);

					if(FileManager::createManifestFile(Constant::getManifestText($appName, $versionNo, $bundleId, $uploadResponse)) == true){

						//Successfully Createt
						GlobalContext::$readyToDownload = true;
					}
					else{

						GlobalContext::$readyToDownload = false;
					}

				}
				else{

					// No Build
					array_push($errorLog, ERROR_NO_BUILD);
				}
			}
			else{

				// No Version Number
				array_push($errorLog, ERROR_NO_VERSION);
			}
		}
		else{

			// No Bundle ID
			array_push($errorLog, ERROR_NO_BUNDLE);
		}
	}
	else{

		// No App Name
		array_push($errorLog, ERROR_NO_APP_NAME);
	}
}
else{
	
	// Very First Time
	
	//array_push($errorLog, ERROR_NO_APP_NAME);
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

	<link href="https://fonts.googleapis.com/css?family=Montserrat:300" rel="stylesheet">

	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 boxContainer">

				<div class="text-center">
					<h1><i class="fa fa-cloud" aria-hidden="true"></i>&nbsp;Share IPA</h1>
					<h5 class="subtitle">Just Upload Your IPA and Distribute your Build</h5>
					<hr>
				</div>

				<form id="formUpload" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="appName">App Name</label>
						<input type="text" name="app_name" class="form-control" id="app_name" placeholder="App Name">
					</div>
					<div class="form-group">
						<label for="bunldeLabel">Bunde ID</label>
						<input type="text" class="form-control" name="bundle_id" id="bundle_id" placeholder="App's Bundle ID">
					</div>
					<div class="form-group">
						<label for="versionLabel">Version No.</label>
						<input type="text" class="form-control" name="version_no" id="version_no" placeholder="App's Version Number">
					</div>
					<div class="form-group">
						<label for="buildLabel">Upload Bundle</label>
						<input type="file" id="build_ipa" name="build_ipa">
					</div>

					<input type="submit" class="btn btn-success " value="Distribute Your IPA"></input>
					<p></p>
					<?php

					if(GlobalContext::$readyToDownload == true){

						$url = Constant::getLinkUrl("manifest.plist");
						//echo "<a href=".$url." class='btn btn-primary'>Install Your App</a>";

						$linkUrl = TinyUrlManager::getMinifiedURL($url);

						echo "<p><input class='form-control input-sm strong' type='text' value='$linkUrl' readonly>";
					}

					?>

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
				<h5 class="text-center strong"><i class="fa fa-copyright" aria-hidden="true"></i>&nbsp;InnovationM | <a href="http://github.com/">Fork on Github&nbsp;<i class="fa fa-github" aria-hidden="true"></i></a></h5>
			</div>
			<div class="col-sm-3"></div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>