<?php
    include_once 'include/init.php'; //session started
    unset($_SESSION['username']);
    unset($_SESSION['uid']);
    unset($_SESSION['eduPersonAffiliation']);
    unset($_SESSION['sn']);
    unset($_SESSION['eduPersonOrgDN']);
    unset($_SESSION['uhUuid']);
    unset($_SESSION['cn']);
    unset($_SESSION['uhOrgAffiliation']);
    unset($_SESSION['givenName']);
    $_SESSION = array();
    session_destroy();
    header('Location: ' . getWebService());
    exit;
?>