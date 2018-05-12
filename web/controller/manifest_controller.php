<?php

class ManifestController {

    // Create Manifest File
    static function createManifestFile($appName, $uploadPath) {
        return FileManager::createManifestFile(ManifestController::prepareManifestContent($appName, "com.apple.developer", "1.0.1", Utility::getHostName()."".$uploadPath));
    }

    // Prepare Manifest Body Content
    static function prepareManifestContent($appName, $bundleId, $version, $buildPath) {

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
		$manifestText = str_replace("{APP_URL}", $buildPath, $manifestText);

		return $manifestText;
	}

}

?>