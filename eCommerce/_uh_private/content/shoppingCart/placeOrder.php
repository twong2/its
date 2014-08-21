<!--This page submits the users order to the DB -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Placed Order</title>
    <link href="?section=style" rel="stylesheet" type="text/css"></head>
    <body>
        <div id="products-wrapper">
            <div id="right">
               <div class="view-cart">

    <?php

	function lookupCustomerId($mysqli, $lookupUsername) {
		$returnUsername = '';
		$sql =
			'SELECT customer_id ' .
			'  FROM contact_info ' .
			' WHERE uh_username="' . $lookupUsername . '";';
		// echo $sql; exit;
		if ($results = $mysqli->query($sql)) {
			if ($row = mysqli_fetch_array($results)) {
				$returnUsername = $row['customer_id'];
			} // END if ($row = mysqli_fetch_array($results))
		} // END if ($mysqli->query($sql))
		return $returnUsername;
	} // END function lookupCustomerId($username)
        
    $currency="$";

    //For the page to recognize the user for DB
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

        
	//Shows table of products ordered and submits order to DB
	if(isset ($_SESSION["products"])) {
	    $total = 0;
            echo '<ul>';
            $cart_items = 0;
            
            foreach ($_SESSION["products"] as $cart_itm){
           $product_code = $cart_itm["code"];
           $results = $mysqli->query("SELECT product_name, price "
                   . "FROM products "
                   . "WHERE product_code='$product_code';");
           $obj = mysqli_fetch_array($results);

            echo '<li class="cart-itm">';
            echo '<div class="p-price">'.$currency.$cart_itm['price'].'</div>';
            echo '<div class="product-info">';
            echo '<h2>'.$obj['product_name'].'</h2><h3> (Code :'.$product_code.')</h3> ';
            echo '<div class="p-qty">Qty : '.$cart_itm["qty"].'</div>';
            echo '</div>';
            echo '</li>';

            //Calculation for total
            $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
            $total = ($total + $subtotal);
            }
                echo '</ul>';
		echo '<span class="check-out-txt">';
		echo '<strong>Total : '.$currency.$total.'</strong>  ';
		echo '</span>';
                //echo '</form>';
	}//end of table showing contents

    $con = mysqli_connect($db_host, $db_username, $db_password,$db_name);

    //Grabbing customer_id from contact_info table, places into orders_header table
    $sql =
    	'INSERT INTO orders_header (customer_id, status)' .
		'(SELECT customer_id, 1 ' .
		'  FROM contact_info ' .
		' WHERE uh_username="' . $username . '");';

    $sql =
    	'INSERT INTO orders_header (customer_id, status) ' .
		'VALUES (' . lookupCustomerId($mysqli, $username) . ', 1);';
	// echo $sql; exit;
    $customer_info_insert = $mysqli->query($sql);
    $order_id = $mysqli->insert_id;
//    echo $order_id;
    
    $sql =
    	'SELECT * ' .
    	'  FROM orders_header ' .
    	' WHERE order_date=CURRENT_TIMESTAMP';
    // echo $sql;
    $order_info = mysqli_query($con, $sql);
    while($row =  mysqli_fetch_array($order_info)){
        $order_id = $row['order_id'];

        //Inserting product information into order_items table
        //Loops for multiple items in shopping cart
            for ($i = 0; $i < sizeof($_POST["item_name"]); $i++){
            $product_name =  mysqli_real_escape_string($con, $_POST['item_name'][$i]);
            $quantity =  mysqli_real_escape_string($con, $_POST['item_qty'][$i]);
            $price =  mysqli_real_escape_string($con, $_POST['price'][$i]);
//            $product_code =  mysql_real_escape_string($_POST['item_code'][$i]);
//            $total = mysql_real_escape_string($_POST["order_total"][$i]);
            
        //Grabs the product_id and type from products table when user places in an order
        $product_id_info = mysqli_query($con, "SELECT * FROM products WHERE product_name = '$product_name';");
            while($row2 = mysqli_fetch_array($product_id_info)){
                $product_id = $row2['product_id'];
                $type = $row2['type'];

            $sql = "INSERT INTO order_items (order_id, product_id, quantity, type, price)"
                    . "VALUES ('$order_id','$product_id', '$quantity', '$type', '$price');";
            
//            echo $sql;
//            exit();
            $mysqli->query($sql);
//            $order_id = $mysqli->insert_id;

            
        }//END while($row2 = mysqli_fetch_array($product_id_info))
            }//END of the for ($i = 0; $i < sizeof($_POST["item_name"]); $i++)
    }//END of while($row =  mysql_fetch_array($order_info))

    // if successfully insert data into database, displays message "Successful".
    if($mysqli){
    echo "<b>Successful submission of order</b>";
    unset($_SESSION['products']);
     }else {
             echo "<b>ERROR in sending form</b>";
             die('Error in submission of order'.mysql_error('order_items'));
           }//END of if($mysqli)

    ?>

                    </div><!--view-cart-->
            </div><!--right-->
    </div><!--products wrapper-->
</body>
</html>