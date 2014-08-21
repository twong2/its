<?php
//include_once("config.php");
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

            //Is the word, need to convert to number
            $status = ($_POST['statusCode']);

            
            //convert to status to number
            $order_statuses_sql = 
                    "SELECT *" .
                    " FROM order_statuses" .
                    " WHERE status_report = '$status'";
//            echo $order_statuses_sql; exit();
            if ($order_statuses_results = mysqli_query($con, $order_statuses_sql)) {
                if ($order_statues_row = mysqli_fetch_assoc($order_statuses_results)) {
                    $order_statues_info = $order_statues_row;
                } // END if ($contact_info_row = mysqli_fetch_array($contact_info_results))
            } // END if ($contact_info)
//            echo $order_statues_info['status_id']; exit();
                     
            $orderID = ($_POST['order_id']);
//            $orderID = $order_statues_info['status_id'];
//            echo $orderID;
            
    if(isset($_POST['statusCode'])){
        
        $return_url = base64_decode($_POST["return_url"]); //return url

        $order_review_sql = 
                "UPDATE orders_header" .
                " SET status = ".$order_statues_info['status_id']." " .
                " WHERE order_id = '$orderID';";
//        echo $order_review_sql; exit();
        
        mysqli_query($con, $order_review_sql);
        
        {
            header('Location:'.$return_url);
        }
    }
    
    
?>