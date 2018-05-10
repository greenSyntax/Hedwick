<?php

class SharingController {

    // IPA Link
    function sharableIPALink($url) {
        return TinyUrlManager::getMinifiedURL($url);
    }   

    // Android Link
    function sharableAndroidLink($url) {
        return TinyUrlManager::getMinifiedURL(UPLOAD_DIRECTORY_ABSOLUTE_PATH.$url);
    }

}

?>