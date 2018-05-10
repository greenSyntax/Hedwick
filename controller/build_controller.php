<?php

require 'utils/context.php';

class BuildController {
 
    // Upload File to /upload Directory
    function uploadBuild($buildFile) {

        $upload = new UploadManager();
        $uploadPath = $upload->uploadFile($buildFile);
        return $uploadPath;
    }

    function getIPALinkUrl($manifestPath){
		return "itms-services://?action=download-manifest&url=".HOST_NAME."/".MANIFEST_DIRECTORY_NAME."/".$manifestPath;
	}

    function getBuildPath($path){
		return HOST_NAME."/".$path;
	}

    // Save Upload File Metadat into Context
    function saveAppDetails($build) {

        CacheStorage::$appName = Utility::getFirstName($build['name']);
        CacheStorage::$extension = strtolower(end(explode('.', $build['name'])));
    }
    
}

?>