<?php

class HostManager {

    // Get Host Name
    static function getHostName() {
        return gethostbyname();
    }

    static function getDomain() {
        return $_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI'];
    }


    // Get IP
    static function getIP() {
        //$_SERVER['SERVER_ADDR']
        return gethostbyname(gethostbyname());
    }

}

?>