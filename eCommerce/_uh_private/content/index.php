<?php
/*
//see if user is logged in
    $username = '';
                    if (!empty($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                    } // END if (!empty($_SESSION['username']))
                
 $results = mysql_query("SELECT * FROM contact_info WHERE uh_username = '$username'");
            if ($results){
                while($row = mysql_fetch_array($results))
                
                //if the user is logged in and did not filled out contact info, then it redirects them to fill out contact info page
                if ($username == $row['uh_username'])  {
                        header ('Location:?section=index');
                        exit();
                } else {
                        header('Location:?section=insertInfo');
                        exit();
                }
            }
 * 
 */

?>

<div id="right">
            <!-- 
            *~*~*~* RIGHT COLUMN CONTENT *~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~
            -->
            
            <h1>Welcome!</h1>

            <p>We offer a variety of services such as software and tech support.</p>

            <p>This site is still in development.</p>
            
            <p></p>
            


        </div> <!-- left -->