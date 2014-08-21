<!--Updates the information in the DB -->

<div id="right">
    
<?php

    $con = mysqli_connect($db_host, $db_username, $db_password,$db_name);

            $username = '';
            if (!empty($_SESSION['username'])) {
                $username = $_SESSION['username'];
            } // END if (!empty($_SESSION['username'])

            //People cannot check out without logging in
            if (!isUser()) {
                if(empty ($username)){
                    header('Location:' .getCASServer() . '/cas/login?service=' . getCASLoginPage() . '?section=' . $section);    
                }//END if(empty ($username))
            }//END if (!isUser())

            $campus= ($_POST['campus']);
            $department= ($_POST['department']);
            $telephone = preg_replace('/\D+/', "", $_POST['telephone']);
            $address= ($_POST['address']);
            $fax_number = preg_replace('/\D+/', "", $_POST['fax_number']);
            $city= ($_POST['city']);
            $state= ($_POST['state']);
            $zip= ($_POST['zip']);
            $affiliation= ($_POST['affiliation']);


            $query = "UPDATE contact_info "
                    . "SET campus='$campus', department='$department', telephone='$telephone', address='$address', fax_number='$fax_number', city='$city', state='$state', zip='$zip', affiliation='$affiliation' "
                    . "WHERE uh_username='$username';";
//            echo $query;
//            exit();

            mysqli_query($con, $query);
            echo "<b>Information Updated</b>";

            mysqli_close($con);

        echo '<form action="'. $_SERVER['PHP_SELF'].'" method="post">';
            echo '<table>';
                echo '<input type="hidden">';
                echo '<tr><td>Campus: </td><td>'.$_POST['campus'].'</td></tr>'. PHP_EOL ;
                echo '<tr><td>Department Name: </td><td>' .$_POST['department'].'</td></tr>'. PHP_EOL ;
                echo '<tr><td>Telephone: </td><td>' .$_POST['telephone'].'</td></tr>'. PHP_EOL ;
                echo '<tr><td>Fax Number: </td><td>' .$_POST['fax_number'].'</td></tr>'. PHP_EOL ;
                echo '<tr><td>Contact Address: </td><td>' .$_POST['address'].'</td></tr>'. PHP_EOL ;
                echo '<tr><td>City: </td><td>' .$_POST['city'].'</td></tr>'. PHP_EOL ;
                echo '<tr><td>State: </td><td>' .$_POST['state'].'</td></tr>'. PHP_EOL ;
                echo '<tr><td>Zip: </td><td>' .$_POST['zip'].'</td></tr>'. PHP_EOL ;
                echo '<tr><td>Affiliation:</td><td>'.$_POST['affiliation'].'</td></tr>'. PHP_EOL ;
            echo '</table>';
        echo '</form>';

?>

</div>