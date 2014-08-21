<?php
    if (!isUser() && !isAdmin()) {
        header('Location: ?noAuth');
        exit;
    } // END if (!isUser() && !isAdmin())

    $username = '';
                        if (!empty($_SESSION['username'])) {
                            $username = $_SESSION['username'];
                        } // END if (!empty($_SESSION['username']))

    //People cannot check out without logging in
    if (!isUser()) {
        if(empty ($username)){
            header('Location:' .getCASServer() . '/cas/login?service=' . getCASLoginPage() . '?section=' . $section);    
        }//END if(empty ($username))
    }//END if (!isUser())
?>

<div id="right">
<h1>
    Admin Menu
</h1>

    <li>
        <a href="?section=adminEditUser">Edit Users</a>
    </li>
    
    <li>
        <a href="?section=viewReviews">View Reviews</a>
    </li>
    
<?php if (isAdmin()) { ?>
    
    <li>
        <a href="?section=adminEditAdmin">Edit Admins</a>
    </li>
    
<?php } // END if (isAdmin()) ?>
    
</div>
