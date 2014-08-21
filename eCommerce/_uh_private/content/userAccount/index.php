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
                    }
                }
?>

<div id="right">
    
<h1>
    Account Menu
</h1>
    
    <li><a href="?section=acctInfo">View User Information</a></li>
    
    <li><a href="?section=history">View Purchase History</a></li>

</div>
