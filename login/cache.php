<?php

class loginCache {
    private $isLoggedIn = false;

    function __construct($loginstatus) {
        $this->isLoggedIn = $loginstatus;
    }
}

?>