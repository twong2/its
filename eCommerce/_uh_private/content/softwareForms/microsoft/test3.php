<?php
$currency = '$'; //Currency sumbol or code
$con = mysqli_connect($db_host, $db_username, $db_password,$db_name);

//User needs to log in to view cart
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

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Shopping Cart</title>
    <link href="?section=style" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="products-wrapper">
    <div id="right">
        <center>
            <img src="http://download.microsoft.com/download/B/1/0/B102AB56-BB7E-4BCF-9D80-1278A029F95A/MSFT_logo_png.png" width="500" height="200">
        </center>
    <h1>Servers</h1>
    <div class="products">
        
    <?php
    
    //current URL of the Page. cart_update.php redirects back to this URL
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    
	$results = mysqli_query($con, "SELECT * FROM products LIMIT 40,16;");//Collect data from products table
            if ($results) {

                //fetch results set as object and output HTML
                while($obj = mysqli_fetch_array($results))
                {
                                echo '<div class="product">'; 
                    echo '<form method="post" action="?section=cartUpdate">';
                    echo '<div class="product-content"><b>'.$obj['product_name'].'</b>';
                    echo '<div class="product-info">';
                                echo 'Price '.$currency.$obj['price'].' | ';
                    echo 'Qty <input type="text" name="product_qty" value="1" size="3" />';
                                echo '<button class="add_to_cart">Add To Cart</button>';
                                echo '</div></div>';
                    echo '<input type="hidden" name="product_code" value="'.$obj['product_code'].'" />';
                    echo '<input type="hidden" name="type" value="add" />';
                                echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
                    echo '</form>';
                    echo '</div>';
                }

            }
    ?>
    </div>
    
    <div class="shopping-cart">
        
    <h2>Your Shopping Cart</h2>
<?php
    if(isset($_SESSION["products"]))
    {
        $total = 0;
        echo '<ol>';
        foreach ($_SESSION["products"] as $cart_itm)
        {
            //shows products from mysql table
            echo '<li class="cart-itm">';
            echo '<span class="remove-itm"><a href="?section=cartUpdate&removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';
            echo '<h3>'.$cart_itm["name"].'</h3>';
            echo '<div class="p-code">P code : '.$cart_itm["code"].'</div>';
            echo '<div class="p-qty">Qty : '.$cart_itm["qty"].'</div>';
            echo '<div class="p-price">Price :'.$currency.$cart_itm["price"].'</div>';
            echo '</li>';
            $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
            $total = ($total + $subtotal);
        }
        echo '</ol>';
        echo '<span class="check-out-txt"><strong>Total : '.$currency.$total.'</strong> <a href="?section=viewCart">Check-out!</a></span>';
        echo '<span class="empty-cart"><a href="?section=cartUpdate&emptycart=1&return_url='.$current_url.'">Empty Cart</a></span>';
    }else{
        echo 'Your Cart is empty';
    }
?>
</div>
    </div>
</div>

</body>
</html>
