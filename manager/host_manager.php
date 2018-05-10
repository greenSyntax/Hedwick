<?php

class HostManager {

    // Get Host Name
    static function getHostName() {
        return gethostbyname();
    }

    // Get IP
    static function getIP() {
        //$_SERVER['SERVER_ADDR']
        return gethostbyname(gethostbyname());
    }

}

?>