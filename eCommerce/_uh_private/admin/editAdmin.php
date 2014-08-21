<?php
if (!isAdmin()) {
    header('Location: ?noAuth');
    exit;
} // END if (!isAdmin())

$addNewAdminsButtonText = 'Add New Admins';
$saveAdminListButtonText = 'Save Admin List';

if (!empty($_REQUEST['submit'])) {
    // form submitted, save new list
    $action = $_REQUEST['submit'];
    $newAdminText = '';
    if ($action == $addNewAdminsButtonText) {
        // clean user input. remove all spaces
        $newAdminText = htmlspecialchars(strtolower($_REQUEST['newAdminList']));
        $adminList = getAdminList();
    } else if ($action == $saveAdminListButtonText) {
        // clean user input. remove all spaces
        $newAdminText = htmlspecialchars(strtolower($_REQUEST['currentAdminList']));
        $adminList = array();
    } // END if ($action == $addNewAdminsButtonText)
    if (!empty($newAdminText)) {
        $newAdminText = str_replace(' ', ',', $newAdminText);
        $newAdminText = str_replace(PHP_EOL, ',', $newAdminText);
        // need this special case on linux box
        $newAdminText = str_replace("
", ',', $newAdminText);
        $newAdminList = explode(',', $newAdminText);
        $newAdminList = array_merge($adminList, $newAdminList);
        setAdminList($newAdminList);
    } // END if (!empty($newAdminText))
} // END if (!empty($_REQUEST['submit']))

$adminList = getAdminList();
asort($adminList);
$adminListString = implode(',' . PHP_EOL, $adminList)
?>

<div id="right">
<h1>
    Admin Menu - Edit Admins
</h1>

Enter a list of usernames to add, separated by commas or spaces:
<br />
<form action="" method="post">
    <input type="text" size="50" name="newAdminList">
    <input type="submit" name="submit" value="<?php echo $addNewAdminsButtonText; ?>">
    <br />
    (eg: admin1, admin2,admin3 admin4)

    <br />
    <br />
    <b>OR</b> edit the admin list:
    <br />
    <textarea cols="25" rows="20" name="currentAdminList"><?php echo $adminListString; ?></textarea>
    <br />
    <input type="submit" name="submit" value="<?php echo $saveAdminListButtonText; ?>">
</form>
</div>
