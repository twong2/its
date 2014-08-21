<?php
function getAdminList() {
    $adminList = array();
    $adminFileLocation = getHomeDirectory() . '/_uh_private/adminList.php';
    if (file_exists($adminFileLocation)) {
        $adminList = unserialize(file_get_contents($adminFileLocation));
    } // END if (file_exists($adminFileLocation))
    return $adminList;
} // END function getAdminList()

function setAdminList($newAdminList) {
    // remove empty elements
    $newAdminList = array_filter($newAdminList);
    // remove duplicate elements
    $newAdminList = array_unique($newAdminList);
    // convert to string to save to text file
    $newAdminList = serialize($newAdminList);
    $adminFileLocation = getHomeDirectory() . '/_uh_private/adminList.php';
    if (file_exists($adminFileLocation)) {
        file_put_contents($adminFileLocation, $newAdminList);
    } // END if (file_exists($adminFileLocation))
} // END function setAdminList($newAdminList)

function isAdmin() {
    $adminList = getAdminList();
    return in_array(getUsername(), $adminList);
} // END function isAdmin()

function getUserList() {
    $userList = array();
    $userFileLocation = getHomeDirectory() . '/_uh_private/userList.php';
    if (file_exists($userFileLocation)) {
        $userList = unserialize(file_get_contents($userFileLocation));
    } // END if (file_exists($userFileLocation))
    return $userList;
} // END function getUserList()

function setUserList($newUserList) {
    // remove empty elements
    $newUserList = array_filter($newUserList);
    // remove duplicate elements
    $newUserList = array_unique($newUserList);
    // convert to string to save to text file
    $newUserList = serialize($newUserList);

    $userFileLocation = getHomeDirectory() . '/_uh_private/userList.php';
    if (file_exists($userFileLocation)) {
        // echo $newUserList; exit;
        file_put_contents($userFileLocation, $newUserList);
    } // END if (file_exists($userFileLocation))
} // END function setUserList($newUserList)

function isUser() {
    $userList = getUserList();
    return in_array(getUsername(), $userList);
} // END function isUser()

function getUsername() {
    $username = '';
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } // END if (!empty($_SESSION['username']))
    return $username;
} // END function getUsername()

function getFilesDirectory($dirName = '') {
        return getHomeDirectory() . '/_uh_private/content' . $dirName;
} // END function getFilesDirectory();

?>