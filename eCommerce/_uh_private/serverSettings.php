<?php
 ini_set('session.save_path', '/dev/its/eCommerce/_uh_private/sessions');
session_start();

$db_username = 'test';
$db_password = 'zBtSNVpf2JnYKvCf';
$db_name = 'ecommerce';
$db_host = 'localhost';
$mysqli = new mysqli($db_host, $db_username, $db_password,$db_name);

mysql_connect($db_host, $db_username, $db_password) or die ("cannot connect to DB". mysql_errno());
mysql_select_db($db_name) or die ("cannot select DB");

function getHomeDirectory() {
        // return '/webinfo/1/policy';
        return '/dev/its/eCommerce';
} // END function getHomeDirectory()

function getCASServer() {
    // return 'https://authn.hawaii.edu';
    return 'https://cas-test.its.hawaii.edu';
} // END function getCASServer()

function getWebServer() {
    // return 'https://www.hawaii.edu/policy';
    return 'http://127.0.0.1';
} // END function getWebServer()

function getWebDirectory() {
    return '/its/eCommerce';
} // END function getWebDirectory()

function getWebService() {
    return getWebServer() . getWebDirectory();
} // END function getWebService()

function getCASLoginPage() {
    return getWebService() . '/login.php';
} // END function getCASLoginPage()

function getDbServer() {
    // return 'mdb41.its.hawaii.edu';
    return '127.0.0.1';
} // END function getDbName()

/*
function getDbName() {
    return 'sys_contact_form';
} // END function getDbName()

function getDbUser() {
    return 'sys_test';
} // END function getDbUser()

function getDbPass() {
    return 'TBUmen4K37UqMAcc';
} // END function getDbPass()

function getDbConnection() {
    $mysqli_conn = new mysqli(getDbServer(), getDbUser(), getDbPass(), getDbName());
    if ($mysqli->connect_errno) {
        echo 'Failed to connect to database: ' . $mysql_conn->connect_error . ' (' . $mysql_conn->connect_errno . ')';
        exit;
    } // END if ($mysqli->connect_errno)
    return $mysqli_conn;
} // END function getDbConnection()
 * 
 */

function getVerifyPeer() {
    return '0';
    // return '1';
} // END function getVerifyPeer()

function getVerifyHost() {
    return '0';
    // return '2';
} // END function getVerifyHost()

?>