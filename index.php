<?php

require_once 'include/constant.php';
require_once 'include/upload_manager.php';
require_once 'include/global_context.php';
require_once 'include/validation_manager.php';
require_once 'include/file_manager.php';
require_once 'include/tiny_url_manager.php';
require_once 'include/zip_manager.php';
require_once 'include/xml_manager.php';

//Error
$errorLog = array();

if(count($_FILES) > 0){

	if(!empty($_FILES['build_ipa'])){

		$upload = new UploadManager();
		$uploadPath = $upload->uploadFile($_FILES['build_ipa']);

		$appName = GlobalContext::$appName;

		if($appName != null){

		$zipPath = $uploadPath;

		#$appName = Utility::getFirstName($zipPath);

		//Extract Zip
		$zipPath = ZipManager::extract($zipPath);

		//Parse XML
		$xmlManager =  new XmlManager();
		$model = $xmlManager->parse($zipPath, $appName);

		echo $model["appName"];
		$createManifestFile = FileManager::createManifestFile(Constant::getManifestText($model["appName"], $uploadPath, $model["version"], $model["bundleId"]));

		//Successfully Created
		GlobalContext::$readyToDownload = true;
		}
	}
	else{

		// No Build
		array_push($errorLog, ERROR_NO_BUILD);
	}

}
else{

	// Very First Time
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
				<div class="text-right"><small><?php echo APP_VERSION; ?>  <strong>ALPHA</strong></small></div>
				<div class="text-center">
					<h1><i class="fa fa-cloud" aria-hidden="true"></i>&nbsp;Share IPA</h1>
					<h5 class="subtitle">Just Upload Your IPA and Distribute your AdHoc Build</h5>
					<hr>
				</div>

				<form id="formUpload" method="POST" enctype="multipart/form-data">
					<!--
					<div class="form-group">
						<label for="appName">App Name</label>
						<input type="text" name="app_name" class="form-control" id="app_name" placeholder="App Name">
					</div>
					<div class="form-group">
						<label for="bunldeLabel">Bunde ID</label>
						<input type="text" class="form-control" name="bundle_id" id="bundle_id" placeholder="com.domain.appname">
					</div>
					<div class="form-group">
						<label for="versionLabel">Version No.</label>
						<input type="text" class="form-control" name="version_no" id="version_no" placeholder="1.0.1">
					</div>
				-->

				<div class="form-group">
					<div class="alert alert-info" role="alert">
						<label for="buildLabel">Upload Bundle</label>
						<input type="file" id="build_ipa" name="build_ipa">
					</div>
				</div>

				<!--
				<br>

				<div class="progress" id="percentageBar">
  					<div class="progress-bar" id="uploadProgress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">

  					</div>
				</div>
				-->

				<?php

				if(GlobalContext::$readyToDownload == true){

					echo '<p></p>';

					$url = Constant::getLinkUrl($createManifestFile);

					# echo $url;

					$linkUrl = TinyUrlManager::getMinifiedURL($url);

					if($linkUrl == null){

						echo '<div class="alert alert-error" role="alert">';
						echo '<i class="fa fa-check-circle" aria-hidden="true"></i> There might be some error. Please try again :/';
						echo '</div>';
					}
					else{
						echo '<div class="alert alert-success" role="alert">';
						echo '<i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;'.$linkUrl;
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
			<h5 class="text-center strong"><i class="fa fa-copyright" aria-hidden="true"></i>&nbsp;InnovationM | <a href="https://github.com/greenSyntax/IPA-Distribution-Interface">Fork on Github&nbsp;<i class="fa fa-github" aria-hidden="true"></i></a></h5>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- <script src="//oss.maxcdn.com/jquery.form/3.50/jquery.form.min.js"></script> -->

<script>

	function upload_ipa(){

		$('#formUpload').ajaxForm({

			beforeSubmit: function(){

				//percentage.html("0%");
				//$('#uploadProgress').attr('aria-valuenow', 0).css('width', 0+"%").text(0+"%");
				$(".progress-bar").width("0%").html("0%");
			},

			uploadProgress: function(event, position, total, percentageComplete){


				//percentage.html(percentageValue);

				//$('#uploadProgress').attr('aria-valuenow', percentageComplete).css('width', percentageComplete+"%").text(percentageComplete+"%");
				$(".progress-bar").width(percentageComplete+"%").html(percentageComplete+"%");

			},

			success: function(){

				//percentage.html("100%");
				//$('#uploadProgress').attr('aria-valuenow', 100).css('width', 100+"%").text(100+"%");
				$(".progress-bar").width("100%").html("100%");
			},

			complete: function(xhr){

			}
		});
	}

</script>

</body>
</html>
