<!--Confirmation of information-->
<div id="right">
    <p>
        <b>
        
        </b>
    </p>
    
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
           
        $esri_sig = ($_POST['esri_sig']);
        
        //convert to right date format for DB
        $originalDate = ($_POST['esri_date']);
        $esri_date = date("Y-m-d", strtotime($originalDate));
        
        $row = "UPDATE agreement_form "
             . "SET esri = '$esri_sig', esri_date = '$esri_date' "
             . "WHERE uh_username = '$username';";
                
        $result = mysqli_query($con, $row);
        
        if($result){
            echo "Thank you for agreeing with the terms and conditions. You will be redirected to the products page soon";
        } else {
            die('Error'.mysqli_error('agreement_form'));
            echo "Didn't Work";
        }

// close connection 
//mysql_close();
?>
    <meta http-equiv="refresh" content="3;url=?section=esriProducts">
</div><!--Right-->