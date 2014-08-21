<!--To confirm and send contact info to DB-->
<div id="right">
<?php
$con = mysqli_connect($db_host, $db_username, $db_password,$db_name);

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
            
            
            //Get values from form
            $campus= ($_POST['campus']);
            $department= ($_POST['department']);
            $first_name= ($_POST['first_name']);
            $last_name= ($_POST['last_name']);
            $telephone = preg_replace('/\D+/', "", $_POST['telephone']);
            $address= ($_POST['address']);
            $fax_number = preg_replace('/\D+/', "", $_POST['fax_number']);
            $city= ($_POST['city']);
            $state= ($_POST['state']);
            $zip= ($_POST['zip']);
            $uh_username= ($_POST['uh_username']);
            $affiliation= ($_POST['affiliation']);

$sql = "INSERT INTO contact_info (campus, department, first_name, last_name, telephone, address, fax_number, city, state, zip, uh_username, affiliation) "
        . "VALUES ('$campus', '$department', '$first_name', '$last_name', '$telephone', '$address', '$fax_number', '$city', '$state', '$zip', '$uh_username', '$affiliation');";

$agreement = "INSERT INTO agreement_form (uh_username)"
        . "VALUES ('$uh_username');";

$result = mysqli_query($con, $sql);
$agreement_username_insert= mysqli_query($con, $agreement);

// if successfully insert data into database, displays message "Successful". 
if($result){
echo "Successful submission of form, you will be redirected to the home page";
     }else {
//echo "ERROR in sending form";
         die('Error:'.mysqli_error('contact_info'));
     }    
?>

    <!--Show info from db -->
<form action="<?php $_PHP_SELF ?>" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <table>
                <tr>
                    <td>
                        Campus: 
                    </td>
                    <td>
                        <?php print $_POST['campus'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Department Name: 
                    </td>
                    <td>
                        <?php print $_POST['department'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Contact First Name: 
                    </td>
                    <td>
                        <?php print $_POST['first_name'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Contact Last Name: 
                    </td>
                    <td>
                        <?php print $_POST['last_name'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Telephone: 
                    </td>
                    <td>
                        <?php print $_POST['telephone'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Fax Number: </td>
                    <td>
                            <?php print $_POST['fax_number'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Contact Address: 
                    </td>
                    <td>
                        <?php print $_POST['address'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        City: 
                    </td>
                    <td>
                        <?php print $_POST['city'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        State: 
                    </td>
                    <td>
                        <?php print $_POST['state'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Zip: 
                    </td>
                    <td>
                        <?php print $_POST['zip'];?>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Primary email Address: 
                    </td>
                    <td>
                        <?php print $_POST['uh_username'];?>@hawaii.edu
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Affiliation: 
                    </td>
                    <td>
                        <?php print $_POST['affiliation'];?>
                    </td>
                </tr>
                
            </table>

</form>
    <?php
    //close connection
    mysqli_close();

    ?>
    <meta http-equiv="refresh" content="3;url=?section=index">
</div>