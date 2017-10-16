<?php

//HOST_NAME
#define("HOST_NAME", "http://app.greensyntax.co.in");
#define("HOST_NAME", "http://localhost:7070/app/Share");
define("HOST_NAME", "https://innovationm.com/iOSBuild");


define("APP_VERSION", "v1.0.6");
define("isDevelopment", false);


define("MANIFEST_DIRECTORY_NAME", "manifest");
define("UPLOADS_DIRECTORY_NAME", "uploads");
define("ZIP_DIRECTORY_NAME", "temp");

define("UPLOAD_DIRECTORY_NAME", "uploads");
define("UPLOAD_FILE_SIZE", "500000000");
define("IPA", "ipa");
define("APK", "apk");

define("ERROR_INCORRECT_PATH", "Incorrect Path");
define("ERROR_INVALID_SIZE", "Greater than assigned size");
define("ERROR_INVALID_FILE", "Invalid File");

define("ERROR_NO_APP_NAME", "There is No AppName");
define("ERROR_NO_BUNDLE", "There is No BundleID");
define("ERROR_NO_VERSION", "There is No Version Number");
define("ERROR_NO_BUILD", "There is No IPA Build");
define("FAIL_LOAD_XML", "Cannot Load XML");


class Constant{

	static function getLinkUrl($manifestPath){

		return "itms-services://?action=download-manifest&url=".HOST_NAME."/manifest/".$manifestPath;
	}

	static function getIPA($path){

		return HOST_NAME."/".$path;
	}

	static function getManifestText($appName, $ipaPath, $bundleId, $version){

		$manifestText = "<?xml version='1.0' encoding='UTF-8'?>
		<!DOCTYPE plist PUBLIC '-//Apple//DTD PLIST 1.0//EN' 'http://www.apple.com/DTDs/PropertyList-1.0.dtd'>
		<plist version='1.0'>
		<dict>
		<key>items</key>
		<array>
		<dict>
		<key>assets</key>
		<array>
		<dict>
		<key>kind</key>
		<string>software-package</string>
		<key>url</key>
		<string>{APP_URL}</string>
		</dict>
		</array>
		<key>metadata</key>
		<dict>
		<key>bundle-identifier</key>
		<string>{APP_BUNDLE}</string>
		<key>bundle-version</key>
		<string>{APP_VERSION}</string>
		<key>kind</key>
		<string>software</string>
		<key>title</key>
		<string>{APP_NAME}</string>
		</dict>
		</dict>
		</array>
		</dict>
		</plist>";

		//Replace App Name
		$manifestText = str_replace("{APP_NAME}", $appName, $manifestText);
		$manifestText = str_replace("{APP_BUNDLE}", $bundleId, $manifestText);
		$manifestText = str_replace("{APP_VERSION}", $version, $manifestText);
		$manifestText = str_replace("{APP_URL}", Constant::getIPA($ipaPath), $manifestText);

		# echo ">>".$manifestText;

		return $manifestText;

	}

}
?>
