<!-- Edits the information-->
<div id="right">
    
    <h1>Edit Information</h1>

<SCRIPT LANGUAGE="JavaScript">
        function addDashes(f)
            {
                f.value = f.value.replace(/\D/g, '');

                f.value = f.value.slice(0,3)+"-"+f.value.slice(3,6)+"-"+f.value.slice(6,15);
            }
</SCRIPT>
    
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
                }
            }

            $results = mysqli_query($con, "SELECT * FROM contact_info WHERE uh_username = '$username';");
            if ($results){
                while($row = mysqli_fetch_array($results)){
    ?>
    
    <form action="?section=updateInfo" method="post" action="<?php $_PHP_SELF?>">
        <!--Show info from db -->
            <input type="hidden" name="user_info" value="<?php echo $username?>">
               <table>
                    <tr>
                        <td>
                            Campus: 
                        </td>
                        <td>
                            <input type="text" name="campus" size="40" required value="<?php echo $row['campus']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Department Name: 
                        </td>
                        <td>
                            <input type="text" name="department" size="40" required value="<?php echo $row['department']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            First Name: 
                        </td>
                        <td>
                            <input type="text" name="first_name" size="40" required value="<?php echo $row['first_name']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Last Name: 
                        </td>
                        <td>
                            <input type="text" name="last_name" size="40" required value="<?php echo $row['last_name']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Telephone: 
                        </td>
                        <td>
                            <input type="text" name="telephone" maxlength="14" size="40" required value="<?php echo $row['telephone']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Fax Number: 
                        </td>
                        <td>
                            <input type="text" name="fax_number" maxlength="14" size="40" required value="<?php echo $row['fax_number']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Contact Address: 
                        </td>
                        <td>
                            <input type="text" name="address" size="40" required value="<?php echo $row['address']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            City: 
                        </td>
                        <td>
                            <input type="text" name="city" size="40" required value="<?php echo $row['city']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            State: 
                        </td>
                        <td>
                            <input type="text" name="state" size="40" required value="<?php echo $row['state']?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Zip: 
                        </td>
                        <td>
                            <input type="text" name="zip" size="40" maxlength="5" required value="<?php echo $row['zip']?>">
                        </td>
                    </tr>
                    
                 <tr>
                        <td>
                            Affiliation:
                        </td>
                        <td>
            <?php
            $affiliation_array = array('Faculty', 'Staff', 'Student');
            echo '<select name="affiliation">';
            for ($i = 0; $i<count($affiliation_array); $i++){
                print '<option type="checkbox" name="'.$affiliation_array[$i].'" value="'.$affiliation_array[$i].'"'.(($row['affiliation']==$affiliation_array[$i])?' selected="selected"' : '').'>'.$affiliation_array[$i].'';
            }
//                                     echo '<option type="checkbox" name="affiliation" value="Faculty"'.(($row['affiliation']=='Faculty')?' selected="selected"' : '').'>Faculty';
//                                     echo '<option type="checkbox" name="affiliation" value="Staff"'.(($row['affiliation']=='Staff')?' selected="selected"' : '').'>Staff';
//                                     echo '<option type="checkbox" name="affiliation" value="Student"'.(($row['affiliation']=='Student')?' selected="selected"' : '').'>Student';

                    ?>
                         </td>
                 </tr>
                            </select>
               </table>
            
                    <input type="submit" name="contactInfo" value="Submit">
        </form>
<?php
                    }//END while($row = mysqli_fetch_array($results))
            }//END if ($results)
            ?>
</div>