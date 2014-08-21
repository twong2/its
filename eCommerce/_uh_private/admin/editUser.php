<?php
if (!isUser() && !isAdmin()) {
    header('Location: ?noAuth');
    exit;
} // END if (!isUser() && !isAdmin())

$addNewUsersButtonText = 'Add New Users';
$saveUserListButtonText = 'Save User List';

if (!empty($_REQUEST['submit'])) {
    // form submitted, save new list
    $action = $_REQUEST['submit'];
    $newUserText = '';
    if ($action == $addNewUsersButtonText) {
        // clean user input. remove all spaces
        $newUserText = htmlspecialchars(strtolower($_REQUEST['newUserList']));
        $userList = getUserList();
    } else if ($action == $saveUserListButtonText) {
        // clean user input. remove all spaces
        $newUserText = htmlspecialchars(strtolower($_REQUEST['currentUserList']));
        $userList = array();
    } // END if ($action == $addNewUsersButtonText)
    if (!empty($newUserText)) {
        $newUserText = str_replace(' ', ',', $newUserText);
        $newUserText = str_replace(PHP_EOL, ',', $newUserText);
        // need this special case on the linux box
        $newUserText = str_replace("
", ',', $newUserText);
        $newUserList = explode(',', $newUserText);
        $newUserList = array_merge($userList, $newUserList);
        setUserList($newUserList);
    } // END if (!empty($newUserText))
} // END if (!empty($_REQUEST['submit']))

$userList = getUserList();
asort($userList);
$userListString = implode(',' . PHP_EOL, $userList);
?>

<div id="right">
<h1>
    Admin Menu - Edit Users
</h1>

Enter a list of usernames to add, separated by commas or spaces:
<br />
<form action="" method="post">
    <input type="text" size="50" name="newUserList">
    <input type="submit" name="submit" value="<?php echo $addNewUsersButtonText; ?>">
    <br />
    (eg: user1, user2,user3 user4)

    <br />
    <br />
    <b>OR</b> edit the user list:
    <br />
    <textarea cols="25" rows="20" name="currentUserList"><?php echo $userListString; ?></textarea>
    <br />
    <input type="submit" name="submit" value="<?php echo $saveUserListButtonText; ?>">
</form>
</div>