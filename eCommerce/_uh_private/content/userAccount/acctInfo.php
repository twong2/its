<!--To view and possibly edit account information grabbed from DB-->
<div id="right">
<?php
    if (!isUser() && !isAdmin()) {
        header('Location: ?noAuth');
        exit;
    } // END if (!isUser() && !isAdmin())
?>

            <!--*~*~*~* RIGHT COLUMN CONTENT *~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~-->
            
            <h1>Account Information</h1>

            <p></p>
            
            <p></p>
                <form action="?section=editInfo" method="post" action="<?php $_PHP_SELF?>">
            
    <?php
        $con = mysqli_connect($db_host, $db_username, $db_password,$db_name);
            
            //For the page to recognize the user
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

            $results = mysqli_query($con, "SELECT * FROM contact_info WHERE uh_username = '$username';");
            if ($results){
            while($row = mysqli_fetch_array($results)){
            
                //For some reason the department, first and last name, and telephone does not show on the page
                echo '<table>';
                echo '<tr><td>Campus: </td><td>'.$row['campus'].'</td></tr>';
                echo '<tr><td>Department Name: </td><td>' .$row['department'].'</td></tr>';
                echo '<tr><td>First Name: </td><td>' .$row['first_name'].'</td></tr>';
                echo '<tr><td>Last Name: </td><td>' .$row['last_name'].'</td></tr>';

                //If statement for different number lengths
                $number = $row['telephone'];
                $phone_number = " ".substr($number,0,3)."-".substr($number,3,6);
                $phone_number2 = "(".substr($number,0,3).") ".substr($number,3,3)."-".substr($number,6);
                if(strlen($number) == 7)
                    {
                echo '<tr><td>Telephone: </td><td>' .$phone_number.'</td></tr>';
                    }
                elseif(strlen ($number) == 10)
                    {
                echo '<tr><td>Telephone: </td><td>' .$phone_number2.'</td></tr>';
                    }


                 //If statement for different number lengths
                $fax = $row['fax_number'];
                $fax_number1 = " ".substr($fax,0,3)."-".substr($fax,3,6);
                $fax_number2 = "(".substr($fax,0,3).") ".substr($fax,3,3)."-".substr($fax,6);
                if(strlen($fax) == 7)
                    {
                echo '<tr><td>Fax Number: </td><td>' .$fax_number1.'</td></tr>';
                    }
                elseif(strlen ($fax) == 10)
                    {
                echo '<tr><td>Fax Number: </td><td>' .$fax_number2.'</td></tr>';
                    }

                echo '<tr><td>Contact Address: </td><td>' .$row['address'].'</td></tr>';
                echo '<tr><td>City: </td><td>' .$row['city'].'</td></tr>';
                echo '<tr><td>State: </td><td>' .$row['state'].'</td></tr>';
                echo '<tr><td>Zip: </td><td>' .$row['zip'].'</td></tr>';
                echo '<tr><td>Primary email Address: </td><td>' .$row['uh_username'].'@hawaii.edu</td></tr>';
                echo '<tr><td>Affiliation: </td><td>' .$row['affiliation'].'</td></tr>';
                echo '</table>';
                    }
        }
                
    ?>
            
            <input type="submit" name="editInfo" value="Edit Information">
            </center>
            </form>
        </div> <!-- right -->