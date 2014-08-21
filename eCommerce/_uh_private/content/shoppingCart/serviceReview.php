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
    ?>
    
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>View shopping cart</title>
<link href="?section=style" rel="stylesheet" type="text/css"></head>
<body>
<div id="products-wrapper">
    <div id="right">
 <h1>View Review</h1>
 <div class="view-cart">
     
     <form action="?section=placeReview" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
         
 	<?php
        $currency = '$'; //Currency sumbol or code
        
        $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        
	if(isset ($_SESSION["products"]))
        {
	    $total = 0;
		//echo '<form action="?section=placeOrder" method="post" action='.$_SERVER["PHP_SELF"].">";
		echo '<ul>';
		$cart_items = 0;
		foreach ($_SESSION["products"] as $cart_itm)
            {
               $product_code = $cart_itm["code"];
                       $results = $mysqli->query("SELECT product_name, price FROM products WHERE product_code='$product_code' LIMIT 1;");
                       $obj = mysqli_fetch_array($results);   

                echo '<li class="cart-itm">'. PHP_EOL;
                echo '<span class="remove-itm"><a href="?section=cartUpdate&removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>'. PHP_EOL;
                echo '<div class="p-price">'.$currency.$cart_itm['price'].'</div>'. PHP_EOL;
                echo '<div class="product-info">'. PHP_EOL;
                echo '<h2>'.$obj['product_name'].'</h2><h3> (Code :'.$product_code.')</h3> '. PHP_EOL;
                echo '<div class="p-qty">Qty : '.$cart_itm["qty"].'</div>'. PHP_EOL;
                echo '</div>'. PHP_EOL;
                echo '</li>'. PHP_EOL;
                            //Calculation for total
                            $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
                            $total = ($total + $subtotal);

                            echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$obj['product_name'].'" />';
                            echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$product_code.'" />';
                            echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
                            echo '<input type="hidden" name="price['.$cart_items.']" value="'.$cart_itm["price"].'" />';
                            echo '<input type="hidden" name="order_total['.$cart_items.']" value="'.$total.'" />';
                            $cart_items ++;
			
            }
    	echo '</ul>';
		echo '<span class="check-out-txt">'. PHP_EOL;
		echo '<strong>Total : '.$currency.$total.'</strong>  '. PHP_EOL;
		echo '</span>'. PHP_EOL;
		//echo '</form>';
                ?>
         
                 Technician Name: 
                 <select name="techName">
                     <option type="checkbox" name="techName" value="osamum">Osamu Makiguchi
                     <option type="checkbox" name="techName" value="zhongw">Michael Wu
                     <option type="checkbox" name="techName" value="byronw">Byron Watanabe
                     <option type="checkbox" name="techName" value="deannacp">Deanna Pasternak
                     <!--<option type="checkbox" name="techID" value="">-->
                 </select>
                
                <?php
                echo '<br><center><input type="submit" name="placeReview" value="Place Review"></center>';
        }else{
		echo 'You have nothing in your shopping cart to submit for review';
	}

    ?>
     <?php
     //print_r(unserialize($));
     ?>
         
     </form>
    </div>
    </div>
</div>