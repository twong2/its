<div id="right">
  
    <?php
    $con = mysqli_connect($db_host, $db_username, $db_password,$db_name);
    
    $signature = '';
        if(!empty($_POST['endNote_sig'])) {
            $signature = htmlspecialchars ($_POST['endNote_sig']);
        }
        
    $endNote_date = '';
        if(!empty($_POST['endNote_date'])) {
            $endNote_date = htmlspecialchars ($_POST['endNote_date']);
        } else {
            $endNote_date = date("m/d/Y");
        }
        
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

       //Looks for username in DB to check if user agreed already
       $sql = mysqli_query($con, "SELECT * FROM agreement_form WHERE uh_username = '$username';"); 
       while ($row = mysqli_fetch_array($sql)){
           if( empty ($row['endNote'])){
               echo '<b>Please read and sign to continue</b>';
           }else{
                   header ("Location:?section=endNoteProducts");
                }
       }//END while ($row = mysqli_fetch_array($sql))
           
        echo '<h1><p><b>University of Hawaii Agreement Form</b></p></h1>' . PHP_EOL ;
        echo '<p><b>Use of EndNote Software for Windows and Macintosh</b></p>'. PHP_EOL ;
        echo '<p>
            The University of Hawai&#699;i (UH) Information Technology Services (ITS) ("Licensee") has licensed the ISI&copy; ResearchSoft EndNote software from ISI&copy; ResearchSoft, a division of ISI (Institute for Scientific Information) ("Licensor"). 
            By purchasing this license through ITS, you agree to be bound by the terms of this agreement form, as well as the Licensor&#699;s end user license agreement ("Agreement"). 
            If you do not agree to the terms of either Agreements, you must not install any EndNote software obtained from the ITS Site License Office. 
            Licensor may discontinue the license if the UH fails to comply with any of the terms and conditions of their Agreement. 
        </p>'. PHP_EOL ;
        echo '<p>
            This site license is in effect for a maximum period of one (1) year ending June 30 of the current UH fiscal year. 
            Licenses can be renewed annually thereafter. 
            Certain exceptions may apply for departments that fall under different terms. 
            Unless otherwise specified, (1) license is valid for only (1) computer. 
        </p>'. PHP_EOL ;
        echo '<p>
            The AUTHORIZED USER (USER) acknowledges that these products are copyrighted and that the Licensor retains all title and ownership rights to the products. 
            USER agrees they will <b>NOT COPY</b> nor permit others to copy any products under this Agreement, in whole or in part. 
            The software may be used only while the USER is an active member of UH. Active UH faculty, staff and students include any student taking a UH credit course and any faculty/staff currently employed by UH. 
            Upon termination of employment or student status at UH, all copies of the EndNote software obtained through the ITS site license must be uninstalled, and the media must be destroyed. 
            USERs of this software on personally owned or UH owned workstations do so at their own risk. UH will not accept any responsibility or liability for any consequential damage or lost data resulting from the use of this software. 
        </p>'. PHP_EOL ;
        echo '<p>
            USER agrees to use the software under this agreement only on a computer which is 1) owned or leased by the UH or 2) owned by the USER. 
            USER further agrees that the products must remain under their control, and that resale or other transfer is explicitly prohibited. 
            USER agrees to use the products only for the University of Hawaii&#699;s educational data processing requirements and NOT for commercial, time-sharing, rental, service bureau or any other outside use. USER agrees not to create, or attempt to create, or permit or help others to create, the source code from products furnished under this agreement. 
            USER agrees that he/she will not reverse engineer or decompile the products. 
        </p>'. PHP_EOL ;
        echo '<p>
            Upon the USER&#699;s termination (as an employee), or if advised by ITS that the site license with the Licensor has been terminated, USER agrees to return to ITS or destroy at once, any and all copies of EndNote software in the USER&#699;s possession (including all backups) and to forward written notice to ITS (2565 McCarthy Mall &ndash; Keller Hall 109, Honolulu, HI 96822) that all programs and materials containing the products have been destroyed or deleted from all computer libraries, storage and memory devices, and are no longer in use or usable. 
        </p>'. PHP_EOL ;
        echo '<p>
            <b>
            I agree to be bound by the Licensor&#699;s Agreement and the terms and conditions provided above for the duration of each valid license period. 
            I further agree to submit the renewal payment for each proceeding fiscal year to ITS in order to continue use of the site licensed software. 
            If this license is cancelled and renewal payment is not submitted to ITS, I agree to remove all software installed under this site license program
            </b>
        </p>'. PHP_EOL ;
    
    ?>
    
<!--  Code for Calendar 
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>-->
    
    <form action="?section=endNoteConfirmationForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
        
        Electronic Signature:<input type="text" name="endNote_sig" required value="<?php echo $signature; ?>">
 
        Date: <input type="text" id="datepicker" name="endNote_date" required value="<?php echo $endNote_date; ?>">
        
        <input type="submit" name="agreementForm" value="Submit">
    </form>

</div><!--Right -->
