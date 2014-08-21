<?php
    require_once 'functions.php';
    require_once '_uh_private/serverSettings.php';

    if (!noLoginRequired() && empty($_SESSION['username'])) {
        echo 'init: ' . getCASServer() . '/cas/login?service=' . getCASLoginPage();
        exit;
    } // END if (empty($_SESSION['username']))

    function noLoginRequired() {
        $unsecurePages = array(
            getWebDirectory() . '/login.php',
            getWebDirectory() . '/index.php',
        );
        return in_array($_SERVER['PHP_SELF'], $unsecurePages);
    } // END function noLoginRequired()
?>