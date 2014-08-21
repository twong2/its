<?php
	if (!isUser() && !isAdmin()) {
		header('Location: ?noAuth');
		exit;
	} // END if (!isUser() && !isAdmin())
?>
<div id="right">
	<h1>
		History
	</h1>
	<p></p>
	<style>
		 .fieldLabel {
		 	background-color: #CCCCCC;
		 	font-weight: bold;
		 }
	</style>
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

	// use to display "no history" message
	$order_history = false;

	$contact_info = array(
		'customer_id' => '',
		'first_name' => '',
		'last_name' => '',
	);
	//DB tables needed for pulling information
	$contact_info_sql =
		"SELECT customer_id, first_name, last_name " . // specify which fields you are going to use
		" FROM contact_info " .
		" WHERE uh_username = '$username' " .
		" LIMIT 1;"; // expecting only one row returned. Use LIMIT to only return first row.
	// echo 'contact info sql: ' . $contact_info_sql; exit;

	if ($contact_info_results = mysqli_query($con, $contact_info_sql)) {
		// only expecting one row. Use IF instead of WHILE.
		// If you want to use the table column name, use mysqli_fetch_assoc instead of mysqli_fetch_array.
		if ($contact_info_row = mysqli_fetch_assoc($contact_info_results)) {
			$contact_info = $contact_info_row;
			// DEBUG - see that we got the contact_info correctly
			// print_r($contact_info); exit;
		} // END if ($contact_info_row = mysqli_fetch_array($contact_info_results))
	} // END if ($contact_info)

	echo
		'<div>' . PHP_EOL .
		'	<div>' . PHP_EOL .
		'		Orders for: ' . PHP_EOL .
		'		' . $contact_info['first_name'] . PHP_EOL .
		'		' . $contact_info['last_name'] . PHP_EOL .
		'	</div>' . PHP_EOL .
		'</div>' . PHP_EOL;

	$order_header_sql =
		"SELECT customer_id, order_id, order_date, status " . // specify which fields you are going to use. do we need customer_id? that's same as $customer_info['customer_id']
		" FROM orders_header " .
		" WHERE customer_id = " . $contact_info['customer_id'] . ";";
	// echo 'order header sql: ' . $order_header_sql; exit;

	$orders = array();
	if ($order_header_results = mysqli_query($con, $order_header_sql)){
		while($order_header_row = mysqli_fetch_assoc($order_header_results)){
			$orders[] = $order_header_row;
		} // END while($order_header_row = mysqli_fetch_assoc($order_header_results))
	} // END if ($order_header_results)
        
        $headerHTML = '';
        $orderTotalHTML = '';
        $statusHTML = '';
        $orderIdHTML = '';
        $lineItems = '';
        
	// check if there's an order header, which means likely there is a related order
	foreach ($orders as $order_header) {
		$order_items_sql =
			"SELECT product_id, price, quantity " .
			" FROM order_items " .
			" WHERE order_id = " . $order_header['order_id'] . ";";
//                echo 'order item sql: ' . $order_items_sql; exit;
		if ($order_items_query = mysqli_query($con, $order_items_sql)) {

            
            //Taking the status number to actual word
            $status_sql =  
                "SELECT *" .
                " FROM order_statuses" .
                " WHERE status_id = " . $order_header['status'] . ";";
            if ($status_results = mysqli_query($con, $status_sql)) {
                if ($status_info_row = mysqli_fetch_assoc($status_results)) {
                    $status_info = $status_info_row;
                } // END if ($contact_info_row = mysqli_fetch_array($contact_info_results))
            } // END if ($contact_info)
//            echo $status_info['status_report']; exit;
        $status = $status_info['status_report'];
        
                    
			// get order line items
			$orderTotal = 0;
			$lineItems =
				'<table width="100%">' . PHP_EOL .
				'<tr class="fieldLabel">' . PHP_EOL .
				'	<td width="60%">' . PHP_EOL .
				'		Product Name' . PHP_EOL .
				'	</td>' . PHP_EOL .
                                '       <td>' . PHP_EOL .
				'		Quantity ' . PHP_EOL .
				'	</td>' . PHP_EOL .
				'	<td>' . PHP_EOL .
				'		Price: ' . PHP_EOL .
				'	</td>' . PHP_EOL .
				'</tr>' . PHP_EOL;
			while ($order_row = mysqli_fetch_assoc($order_items_query)) {
				$orderTotal += $order_row['price']*$order_row['quantity']; 
				$headerHTML =
					'<table width="100%">' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td class="fieldLabel">' . PHP_EOL .
					'		Ordered date:' . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td>' . PHP_EOL .
					'		' . date("F j, Y, H:i A", strtotime($order_header['order_date'])) . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'</table>' . PHP_EOL;

				$orderTotalHTML =
				/*/
					'<tr>' .
					'	<td>' .
					'	</td>' .
					'	<td>' .
					'		For time period Month Year - Month Year' .
					'	</td>' .
					'</tr>' .
				/*/
					'<table width="100%">' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td class="fieldLabel">' . PHP_EOL .
					'		Total: ' . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td>' . PHP_EOL .
					'		$' . $orderTotal . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'</table>' . PHP_EOL;
                                $statusHTML = 
                                        '<table width="100%">' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td class="fieldLabel">' . PHP_EOL .
					'		Status:' . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td>' . PHP_EOL .
					'		' . $status . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'</table>' . PHP_EOL;
				$orderIdHTML =
					'<table width="100%">' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td class="fieldLabel">' . PHP_EOL .
					'		Order ID:' . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td>' . PHP_EOL .
					'		' . $order_header['order_id'] . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'</table>' . PHP_EOL;
				$lineItems .=
					'<tr>' . PHP_EOL .
//					'	<td>' . PHP_EOL .
//					'		' . $order_row['status'] . PHP_EOL .
//					'	</td>' . PHP_EOL .
					'	<td>'. PHP_EOL .
					'		' . getProductName($con, $order_row['product_id']) . PHP_EOL .
					'	</td>' . PHP_EOL .
                                        '       <td align="center">'. PHP_EOL .
					'		' .  $order_row['quantity'] . PHP_EOL .
					'	</td>' . PHP_EOL .
					'	<td align="right">' . PHP_EOL .
					'		$' . $order_row['price'] . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL;
			} // END while ($order_row = mysqli_fetch_assoc($order_items_query))
			$lineItems .= '</table>' . PHP_EOL;
		} // END if ($order_items_query = mysqli_query($con, $order_items_sql))
	echo
		'<table width="100%">' . PHP_EOL .
		'<tr valign="top">' . PHP_EOL .
		'	<td width="25%">' . PHP_EOL .
		'		' . $headerHTML . PHP_EOL .
		'		' . $orderTotalHTML . PHP_EOL .
                '               ' . $statusHTML . PHP_EOL .
		'		' . $orderIdHTML . PHP_EOL .
		'	</td>' . PHP_EOL .
		'	<td>' . PHP_EOL .
		'		' . $lineItems . PHP_EOL .
		'	</td>' . PHP_EOL .
		'</tr>' . PHP_EOL .
		'</table>' . PHP_EOL .
		'<hr>' . PHP_EOL;

	} // END foreach ($orders as $order_header)


	function getProductName($con, $productId) {
		$productName = ''; // or, you can put "Product not found" as the default returned value
		$productsSql =
			"SELECT product_name " .
			" FROM products " .
			" WHERE product_id = '$productId' " .
			" LIMIT 1;"; // expecting only one row
		if ($productsResult = mysqli_query($con, $productsSql)) {
			// expecting one row, use IF instead of WHILE
			if ($productRow = mysqli_fetch_assoc($productsResult)) {
				if (!empty($productRow['product_name'])) {
					$productName = $productRow['product_name'];
				} // END if (!empty($productRow['product_name']))
			} // END if ($productRow = mysqli_fetch_assoc)
		} // END if ($productsResult)
		return $productName;
	} // END function getProductName($productId)
            ?>

        </div> <!-- left -->