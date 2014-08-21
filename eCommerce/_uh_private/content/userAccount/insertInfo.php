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

        $results = mysqli_query($con, "SELECT * FROM contact_info WHERE uh_username = '$username';");
            if ($results){
                while($row = mysqli_fetch_array($results))

                //if the user is logged in and already filled out contact info, then it redirects them to view/edit page
                if ($username == $row['uh_username'])  {
                    header("Location:?section=account");
                    exit();
                }//END if ($username == $row['uh_username'])
            }//END if ($results)
                    
        /*
        if(mysql_num_rows($result) > 0){
        //if ($username !=$results){
            echo "That username is already taken";
        } else {
            //insert to table
        }
         * 
         */
                   
    //Validation for duplicate UH Usernames
                    //doesn't work yet
//                if($_POST['uh_username']=$row['uh_username']){
//                    "That username is already being used!";
//                }
                
?>
    
<SCRIPT LANGUAGE="JavaScript">
    function addDashes(f)
        {
            f.value = f.value.replace(/\D/g, '');

            f.value = f.value.slice(0,3)+"-"+f.value.slice(3,6)+"-"+f.value.slice(6,15);
        }
</SCRIPT>
    
<p>Contact Information</p>
         <form action="?section=infoConfirm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
               <table>
                    <tr>
                        <td>
                            Campus:
                        </td>
                        <td>
                            <input type="text" name="campus" size="40" required value="<?php if(isset($_POST['campus'])) echo $_POST['campus']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Department Name:
                        </td>
                        <td>
                            <input type="text" name="department" size="40" required value="<?php if(isset($_POST['department'])) echo $_POST['department']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Contact First Name:
                        </td>
                        <td>
                            <input type="text" name="first_name" required value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Contact Last Name:
                        </td>
                        <td>
                            <input type="text" name="last_name" required value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Telephone:
                        </td>
                        <td>
                            <input type="text" name="telephone" maxlength="14" required value="<?php if(isset($_POST['telephone'])) echo $_POST['telephone']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Fax Number:
                        </td>
                        <td>
                            <input type="text" name="fax_number" maxlength="14" value="<?php if(isset($_POST['fax_number'])) echo $_POST['fax_number']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Contact Address:
                        </td>
                        <td>
                            <input type="text" name="address" required value="<?php if(isset($_POST['address'])) echo $_POST['address']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            City:
                        </td>
                        <td>
                            <input type="text" name="city" required value="<?php if(isset($_POST['city'])) echo $_POST['city']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            State:
                        </td>
                        <td>
                            <input type="text" name="state" required value="<?php if(isset($_POST['state'])) echo $_POST['state']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Zip:
                        </td>
                        <td>
                            <input type="text" name="zip" maxlength="5" required value="<?php if(isset($_POST['zip'])) echo $_POST['zip']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Primary email Address:
                        </td>
                        <td>
                            <input type="text" name="uh_username" required value="<?php if(isset($_POST['uh_username'])) echo $_POST['uh_username']?>">@hawaii.edu
                        </td>
                    </tr>
                    
                    <!--<tr><td>UH Username:</td><td><input type="text" name="uh_username" required value="<?php// if(isset($_POST['uh_username'])) echo $_POST['uh_username']?>"></td></tr>-->
               </table>
               <table>
                   <tr>
                       <td>
                            <select name="affiliation">
                                 <option type="checkbox" name="affiliation" value="Faculty">Faculty
                                 <option type="checkbox" name="affiliation" value="Staff">Staff
                                 <option type="checkbox" name="affiliation" value="Student">Student
                       </td>
                   </tr>
                    </select>
               </table>
             
                    <input type="submit" name="contactInfo" value="Submit">
        </form>

</div>
